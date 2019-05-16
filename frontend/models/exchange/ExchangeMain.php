<?php

namespace frontend\models\exchange;


use common\helpers\MailHelper;
use common\models\Directions;
use common\models\enum\RequestStatus;
use common\models\enum\Role;
use common\models\Request;
use common\models\Reserves;
use common\models\Settings;
use common\models\User;
use common\models\Wallets;
use common\services\ReferralsService;
use common\services\StaticWallets;
use common\services\WalletsService;
use frontend\helpers\CryptWalletHelper;
use frontend\models\Bids;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\Json;

class ExchangeMain extends Model
{
    const SCENARIO_INIT = 'init';
    const SCENARIO_CRYPT = 'crypt';

    const CRYPT_BTC = 'BTC';
    const CRYPT_ETH = 'ETH';
    const CRYPT_BCH = 'BCH';


    /** @var Directions */
    protected $direction;

    /** @var ExchangeCurrency */
    protected $fromModel;

    /** @var ExchangeCurrency */
    protected $toModel;



    public $amountFrom;

    public $amountTo;

    public $email;

    public $from;

    public $to;

    public $requisites;

    //public $reCaptcha;


    public function rules()
    {
        return [
            [['from', 'to'], 'required', 'on' => self::SCENARIO_INIT],

            [['email'], 'default', 'value' => function ($model, $attribute) {
                return !\Yii::$app->user->isGuest ? \Yii::$app->user->getIdentity()->email : $model->$attribute;
            }],

            [['amountFrom', 'amountTo', 'email', 'from', 'to'], 'required'],

            [['requisites'], 'safe'],

            //[['requisites'], 'required', 'on' => self::SCENARIO_CRYPT],

            //[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Ваш E-mail',
            'amountFrom' => 'Отправляете',
            'amountTo' => 'Получаете',
        ];
    }



    public function setDirection(Directions $direction)
    {
        $this->direction = $direction;

        $fromModelClass = 'frontend\models\exchange\\' . $direction->d_from . '_From';
        $toModelClass = 'frontend\models\exchange\\' . $direction->d_to . '_To';


        $this->fromModel = new $fromModelClass();
        $this->toModel = new $toModelClass();
    }

    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {

            $this->setScenario(self::SCENARIO_INIT);

            if (!parent::validate()) {
                return false;
            }

            $this->setScenario(self::SCENARIO_DEFAULT);

            $direction = Directions::findOne(['d_from' => $this->from, 'd_to' => $this->to]);

            if (!$direction) {
                return false;
            }

            $this->setDirection($direction);

            $this->amountFrom = str_replace(',', '.', $this->amountFrom);
            $this->amountTo = str_replace(',', '.', $this->amountTo);

            return  (count($this->fromModel->attributes) == 0 || $this->fromModel->load($data)) &&
                    (count($this->toModel->attributes) == 0 || $this->toModel->load($data));
        }

        return false;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if ($this->direction->currencyFrom->isCrypt()) {

            switch ($this->direction->currencyFrom->send) {
                case 'BTC':
                    CryptWalletHelper::createBTCWallet();
                    break;
                case 'ETH':
                    CryptWalletHelper::createETHWallet();
                    break;
                case 'BCH':
                    CryptWalletHelper::createBCHWallet();
                    break;
            }

            //$this->setScenario(self::SCENARIO_CRYPT);
            $this->requisites = \Yii::$app->session->get('__crypt_address');
        }

        return parent::validate()
                && $this->fromModel->validate()
                && $this->toModel->validate();
    }

    /**
     * @return Bids
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function createBid()
    {
        $bid = new Bids();

        if (!\Yii::$app->user->isGuest) {
            $bid->user_id = \Yii::$app->user->id;
        }

        $this->amountTo = ((float)$this->amountFrom * (float)$this->direction->d_out)/(float)$this->direction->d_in;
        if(in_array($this->direction->d_to,[self::CRYPT_BTC,self::CRYPT_BCH,self::CRYPT_ETH])){
            $this->amountTo = number_format($this->amountTo, 8, '.', '');
        }else{
            $this->amountTo = number_format($this->amountTo, 2, '.', '');
        }

        $bid->done = RequestStatus::DRAFT;
        $bid->email = $this->email;
        $bid->sum_pull = $this->amountTo;
        $bid->sum_push = $this->amountFrom;
        $bid->currency_from = $this->from;
        $bid->currency_to = $this->to;
        $bid->exchange_price_dfrom = $this->direction->d_in;
        $bid->exchange_price = $this->direction->d_out;
        $bid->currency_from_wallet = $this->direction->currencyFrom->id_wallet;

        $this->fromModel->map($bid);
        $this->toModel->map($bid);

        if ($this->direction->currencyFrom->isCrypt()) {
            $bid->requisites = $this->requisites;
            \Yii::$app->session->remove('__crypt_address');
        } else {
            // default behavior
            $bid->requisites = $this->direction->currencyFrom->wallet->requisite;

            // rotation enabled
            if (Settings::get()->wallets_rotation) {

                $walletsInRotation = $this->direction->currencyFrom
                    ->getAllAvailableWallets()
                    ->andWhere(['in_rotation' => true])
                    ->all();

                if (count($walletsInRotation)) {

                    $wallets = $this->direction->currencyFrom
                        ->getAllAvailableWallets()
                        ->andWhere(['in_rotation' => true])
                        ->andWhere(new Expression("trans_receive < trans_available"))
                        ->orderBy(['trans_receive' => SORT_ASC, 'id' => SORT_ASC])
                        ->all();

                    if (count($wallets)) {
                        $wallet = $wallets[0];
                        $bid->currency_from_wallet = $wallet->id;
                        $bid->requisites = $wallet->requisite;

                        $wallet->active = true;
                        $wallet->save(false);
                    } else {
                        $bid->currency_from_wallet = null;
                        $bid->requisites = null;
                    }

                }

            }
        }


        if ($bid->save()) {

            $bid->hash_id = md5($bid->email . '_asjhdgg*&hvjb_' . $bid->id);

            // check static wallets
            if ($bid->currency_from == 'BTC') {
                StaticWallets::create()->setWorked($bid->requisites);
            }

            $reserves = Reserves::findOne(['currency' => $bid->currency_to]);
            if ($reserves) {
                $reserves->amount -= $bid->sum_pull;
                $reserves->save(false);
            }

            // bid user
            $user = User::findOne(['username' => $bid->email]);
            if (!$user) {
                $user = $this->createBidUser($bid);
            }
            if (!$bid->user_id && $user && !$user->isNewRecord) {
                $bid->user_id = $user->id;
            }

            // referral
            $referral = ReferralsService::create()->getCurrentReferral();
            if ($referral && $bid->user_id != $referral->user_id) {
                $bid->ref = $referral->id;
                $bid->ref_rate = $referral->rate;
            }


            // wallet transactions
            if ($bid->save()) {
                WalletsService::create()->updateWalletTransactions($bid->id);
            }
        }

        if (count($bid->errors)) {
            throw new \Exception(Json::encode($bid->errors));
        }

        return $bid;
    }

    /**
     * @param Bids $bid
     * @return User
     * @throws \yii\base\Exception
     */
    private function createBidUser($bid)
    {
        $user = new User();
        $user->username = $bid->email;
        $user->email = $bid->email;
        $user->role = Role::END_USER;
        $password = \Yii::$app->security->generateRandomString(10);
        $user->setPassword($password);
        $user->generateAuthKey();
        \Yii::$app->session->set('pass', $password);

        if ($user->save()) {

            \Yii::$app->user->login($user);

            \Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'registration-html', 'text' => 'registration-html'],
                    ['user' => $user, 'pass' => $password]
                )
                ->setFrom([\Yii::$app->params['supportEmail'] => ' ' . \Yii::$app->name])
                ->setTo($bid->email)
                ->setSubject('Регистрация аккаунта - ' . \Yii::$app->name)
                ->send();

        }

        return $user;
    }

    public function renderFields()
    {
        return $this->fromModel->render() . $this->toModel->render();
    }

    public function setDirectionOut($val){
        $this->direction->d_out = $val;
    }
    public function setDirectionIn($val){
        $this->direction->d_in = $val;
    }
}