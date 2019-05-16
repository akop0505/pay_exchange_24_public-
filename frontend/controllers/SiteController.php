<?php

namespace frontend\controllers;

use common\models\Currencies;
use common\models\enum\BtcWalletsCreateMode;
use common\models\Referrals;
use common\models\Reserves;
use common\models\Settings;
use common\services\BlockchainInfoService;
use common\services\CryptRateService;
use common\services\CurrenciesService;
use common\services\ReferralsService;
use common\services\StaticWallets;
use common\services\StatisticService;
use frontend\components\Controller;
use frontend\components\XmlGenerator;
use frontend\models\Directions;
use frontend\models\Feedback;
use frontend\models\Bids;
use frontend\models\forms\SigninForm;
use frontend\models\SignupForm;
use function GuzzleHttp\Psr7\str;
use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Cookie;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends Controller
{
    private $logFile;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            if (in_array($action->id, ['monitor-xml', 'monitor-json', 'get-data', 'reserve', 'is_user', 'coinbase-eth', 'currencies', 'coinbase'])) {
                $this->enableCsrfValidation = false;
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionMonitorXml()
    {
        \Yii::$app->response->content = XmlGenerator::getOrGenerate();
        \Yii::$app->response->format = Response::FORMAT_XML;
        return;
    }

    public function actionMonitorJson()
    {
        $map = [];
        $data = [];
        $amounts = Reserves::findAll(['enable' => true]);
        foreach ($amounts as $i => $amount) {

            $curr = $amount->currency == 'VTB24' ? 'TBRUB' : $amount->currency;
            $data['currencies']['aliases'][++$i] = $curr;
            if ((float) $amount->amount > 0) {
                $data['currencies']['amounts'][$i] = (float) $amount->amount;
            }

            $map[$curr] = $i;
        }


        /** @var Directions[] $models */
        $models = Directions::find()
            ->join('LEFT JOIN', 'price AS p1', 'p1.currency = d_from')
            ->join('LEFT JOIN', 'price AS p2', 'p2.currency = d_to')
            ->andWhere(['p1.enable' => true])
            ->andWhere(['p2.enable' => true])
            ->orderBy('d_from ASC')
            ->all();


        foreach ($models as $model) {
            $from = $model->d_from == 'VTB24' ? 'TBRUB' : $model->d_from;
            $to = $model->d_to == 'VTB24' ? 'TBRUB' : $model->d_to;


            $in = (float)$model->d_in;
            $inMinAmount = (float) $model->exchange_limit_min;
            $tmp = [
                //'id' => $map[$to],
                'in' =>  $in,
                'in_min_amount' => $inMinAmount,
            ];

            if ($in == 1) {
                unset($tmp['in']);
            }
            /*
            if ($inMinAmount < 0) {
                unset($tmp['in_min_amount']);
            }*/

            $data['from'][$map[$from]]['to'][$map[$to]] = $tmp;
        }

        $data['options'] = ['manual'];


        /*foreach ($data['from'] as $from) {

            $gr = ArrayHelper::map($from['to'], 'id', 'in_min_amount', function ($item) {
                return (string) $item['in_min_amount'];
            });

            //dbg([$from['to'], $gr]);
            $max = 0;
            $grMinA = 0;
            foreach ($gr as $minA => $group) {
                if (count($group) > $max) {
                    $max = count($group);
                    $grMinA = $minA;
                }
            }

            if ($grMinA > 0) {
                $to = [];
                foreach ($from['to'] as & $item) {

                }
            }
        }*/


        //dbg($data);

        return $this->asJson(['exchanges' => $data]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->setReferrals();

        StatisticService::create()->checkVisit();


        Yii::$app->session->set('user_id', Yii::$app->user->id);
        $feedback = Feedback::find()->where(['approved' => 1])->orderBy(['id' => SORT_DESC])->all();

        $amountExchanges = Yii::$app->db->createCommand("
            SELECT
                SUM(
                  IF(currency_from = 'BTC', 
                    sum_push * exchange_price, 
                    IF(currency_from = 'BCH', 
                      sum_push * exchange_price, 
                      IF(currency_from = 'ETH', 
                        sum_push * exchange_price, 
                        sum_push)))
                ) total
            FROM request 
            WHERE done = 1    
        ")->queryOne();

        $currencyList = ArrayHelper::map(
                Reserves::find()->orderBy('sort_order')->all(),
                'currency',
                function ($m) {
                    return $m;
                }
            );

        return $this->render('index', [
            'feedback' => $feedback,
            'currencyList' => $currencyList,

            'amountExchanges' => (string) ceil($amountExchanges['total'] / 60),
            'countExchanges' => (string) Bids::find()->where(['done' => 1])->count(),
            'countClients' => (string) Bids::find()->select('DISTINCT (email)')->count(),
        ]);
    }

    /**
     * @return bool|string
     */
    public function actionGetData()
    {
        $to = Yii::$app->request->post('to');
        $from = Yii::$app->request->post('from');
        if ($to && $from) {
            $command = Yii::$app->db->createCommand("SELECT *, price.amount as 'amount' FROM directions, price WHERE directions.price_id = price.id and (d_from = :d_from and d_to = :d_to)");
            $command->bindValue(':d_from', $from);
            $command->bindValue(':d_to', $to);
            $directions = $command->queryAll()[0];

            $directions['d_in'] = strlen($directions['d_in']) == 0 ? 0 : $directions['d_in'];
            $directions['d_out'] = strlen($directions['d_out']) == 0 ? 0 : $directions['d_out'];

            return "({'in': " . $directions['d_in'] . ", 'out': " . $directions['d_out'] . ", 'reserve': " . $directions['amount'] . "})";
        }

        return false;
    }

    public function actionCoinbase()
    {
        $mode = Settings::get()->enable_btc_static_wallets;

        switch ($mode) {
            case BtcWalletsCreateMode::STATIC:
                $address = StaticWallets::create()->getFreeWallet();
                break;
            case BtcWalletsCreateMode::COINBASE:
                $address = Yii::$app->coinbase->createBTCAddress();
                break;
            case BtcWalletsCreateMode::BLOCKCHAIN_INFO:
                $address = Yii::$app->blockchainInfo->createBTCAddress();
                break;
        }

        Yii::$app->session->set('__crypt_address', $address);

        return $address;
    }

    public function actionCoinbaseEth()
    {
        $address = Yii::$app->coinbase->createETHAddress();
        Yii::$app->session->set('__crypt_address', $address);

        return $address;
    }

    public function actionCoinbaseBch()
    {
        $address = Yii::$app->coinbase->createBCHAddress();
        Yii::$app->session->set('__crypt_address', $address);

        return $address;
    }

    public function actionCurrencies()
    {
        $count = null;
        $model = Currencies::find()->where(['send' => Yii::$app->request->post('send')])->one();

        $wallet = $model->wallet;

        return $this->asJson([
            'link' => $model->pay_link,
            'full_text' => $model->first_step_text,
            'text' => $model->pay_text,
            'number' => $wallet ? $wallet->requisite : false,
            'fio' => $wallet ? $wallet->requisite_full_name : false,
        ]);
    }

    private function setReferralStat($ref)
    {
        Yii::$app->db->createCommand()->insert('referer_stats', [
            'utm_source' => $ref,
            'visit_date' => date('Y-m-d H:i:s'),
        ])->execute();
    }

    private function setReferrals()
    {
        $currRef = Yii::$app->request->cookies['utm_source'];
        $requestRef = Yii::$app->request->get('utm_source', false);

        // если рефка уже стоит, с реквеста не принимаем
        if (isset(Yii::$app->request->cookies['utm_source'])) {
            $this->setReferralStat($currRef);
            return false;

        // если и в реквесте нет, возвращаемся
        } else if (!$requestRef) {
            return false;

        // если в реквесте есть
        } else {
            $referral = Referrals::find()->andWhere('referrer = :ref', [':ref' => $requestRef])->one();
            if ($referral) {
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'utm_source',
                    'value' => $requestRef,
                ]));

                $this->setReferralStat($requestRef);
            }

            return  $this->redirect(['/']);
        }
    }

    private function _setReferrals()
    {
        $currRef = Yii::$app->session->get('utm_source', false);
        $requestRef = Yii::$app->request->get('utm_source', false);

        // если рефка уже стоит, с реквеста не принимаем
        if ($currRef !== false) {
            $this->setReferralStat($currRef);
            return false;

        // если и в реквесте нет, возвращаемся
        } else if (!$requestRef) {
            return false;

        // если в реквесте есть
        } else {
            $referral = Referrals::find()->andWhere('referrer = :ref', [':ref' => $requestRef])->one();
            if ($referral) {
                Yii::$app->session->set('utm_source', $requestRef);
                $this->setReferralStat($requestRef);
            }

            return  $this->redirect(['/']);
        }
    }

    public function actionContacts()
    {
        return $this->render('contact');
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionRules()
    {
        return $this->render('rules');
    }

    private function log($smth, $isLast = false) {
        return;
        if($this->logFile == null) {
            $this->logFile = fopen(dirname(__DIR__) . '/runtime/logs/monitorXml.log', 'a');
        }
        fwrite($this->logFile, '[' . date('Y-m-d H:i:s') . "]: $smth\n");
        if ($isLast) {
            fwrite($this->logFile, "\n\n");
            fclose($this->logFile);
        }
    }
}
