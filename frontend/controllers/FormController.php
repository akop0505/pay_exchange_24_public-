<?php

namespace frontend\controllers;

use common\helpers\MailHelper;
use common\models\Directions;
use common\models\enum\RequestStatus;
use common\models\Request;
use common\models\Reserves;
use common\services\AccountingService;
use frontend\models\Bids;
use frontend\models\exchange\ExchangeMain;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FormController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'check' || $action->id == 'create') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionGetExchangeLimit($from, $to)
    {
        $model = Directions::findOne(['d_from' => $from, 'd_to' => $to]);

        if ($model) {
            return $this->asJson([
                'success' => true,
                'minLimit' => $model->exchange_limit_min,
                'maxLimit' => $model->exchange_limit_max,
                'currency' => $model->currencyFrom->currency,

                'in' => !$model->currencyFrom->isCrypt() ? intval(($model->d_in*100))/100 : $model->d_in,
                'out' => !$model->currencyTo->isCrypt() ? intval(($model->d_out*100))/100 : $model->d_out,
                'reserve' => $model->reserve->amount,

                'inCurrency' => $model->currencyFrom->isCrypt() ? $model->currencyFrom->currency : 'RUB',
                'outCurrency' => $model->currencyTo->isCrypt() ? $model->currencyTo->currency : 'RUB',
            ]);
        }

        return $this->asJson(['success' => false]);
    }

    public function actionCheck()
    {
        $result = ArrayHelper::map(Reserves::find()->all(), 'currency', function ($m) {
            /** @var Reserves $m */
            return [
                'enable' => (bool) $m->enable,
                'reserve' => $m->getFormatAmount(),
            ];
        });

        return $this->asJson($result);
    }

    public function actionIsDraft($id)
    {
        $model = Bids::findOne(['id' => $id]);
        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        return $this->asJson(['draft' => $model->done == RequestStatus::DRAFT]);
    }

    public function actionGetFields()
    {
        $allForms = '<div id="allForms">';
        foreach(Directions::find()->all() as $direction) {
            /** @var \common\models\Directions $direction */
            $model = new ExchangeMain();
            $model->setDirection($direction);
            $allForms .= "<div id='$direction->d_from||$direction->d_to'>";
            $allForms .= $model->renderFields();
            $allForms .= "</div>";
        }
        $allForms .= '</div>';
        return $allForms;
    }




    public function actionCreate()
    {
        $model = new ExchangeMain();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $direction = new Directions();
            if($direction->load(\Yii::$app->request->post())){
                $model->setDirectionOut($direction->d_out);
                $model->setDirectionIn($direction->d_in);
            }

            $bid = $model->createBid();

            return $this->redirect(['confirm', 'hash' => $bid->hash_id]);

        }

        return $this->goHome();
    }

    public function actionConfirm($hash)
    {
        $model = Request::findOne(['hash_id' => $hash]);
        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        if ($model->done == RequestStatus::DRAFT) {
            return $this->render('create', compact('model'));
        } else if ($model->done == RequestStatus::DECLINE) {
            return $this->redirect(['form/cancel-message', 'id' => $model->id]);
        }

        return $this->redirect(['form/detail', 'hash' => $hash]);
    }

    public function actionPaid($hash)
    {
        $model = Bids::findOne(['hash_id' => $hash, 'done' => RequestStatus::DRAFT]);
        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        $model->done = RequestStatus::NEW_CREATED;
        $model->performed_at = gmdate('Y-m-d H:i:s');
        $model->save(false);

        MailHelper::onBidCreate($model);

        return $this->redirect(['detail', 'hash' => $model->hash_id]);
    }

    public function actionDetail($hash)
    {
        $model = Request::find()
            ->andWhere(['hash_id' => $hash])
            ->andWhere(new Expression("UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(created_at) < 7 * 24 * 3600"))->one();

        if (!$model) {
            return $this->goHome();
        }

        $dp = new ArrayDataProvider([
            'models' => [$model]
        ]);

        return $this->render('detail', [
            'dataProvider' => $dp,
            'model' => $model
        ]);
    }

    public function actionCancel($hash)
    {
        $model = Request::findOne(['hash_id' => $hash, 'done' => RequestStatus::DRAFT]);
        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        AccountingService::create()->declineNewRequest($model);

        if (\Yii::$app->request->isAjax) {
            return $this->asJson(['success' => true]);
        }

        return $this->redirect(['cancel-message', 'id' => $model->id]);
    }

    public function actionCancelMessage($id)
    {
        $model = Request::findOne(['id' => $id, 'done' => RequestStatus::DECLINE]);
        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        return $this->render('cancel-message', [
            'model' => $model
        ]);
    }

    public function actionGetStatus($id)
    {
        $model = Request::findOne(['id' => $id]);
        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        return $this->asJson(['status' => $model->done]);
    }

    /**
     * @param $from
     * @param $to
     * @return Directions
     * @throws NotFoundHttpException
     */
    protected function findModel($from, $to)
    {
        $model = Directions::findOne(['d_from' => $from, 'd_to' => $to]);

        if (!$model) {
            throw new NotFoundHttpException('404');
        }

        return $model;
    }
}




















