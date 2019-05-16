<?php
namespace backend\controllers;


use backend\components\Controller;
use backend\models\CompleteRequestForm;
use backend\models\requests\SendETHForm;
use common\helpers\MailHelper;
use common\models\enum\RequestStatus;
use common\models\Request;
use common\services\AccountingService;
use common\services\CoinbaseService;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;


class RequestsController extends Controller
{
    public function actionIndex()
    {
        $old = Request::find()
            ->andWhere(['done' => RequestStatus::DRAFT])
            ->andWhere(new Expression("UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(created_at) > 900"))
            ->all();

        foreach ($old as $oldModel) {
            AccountingService::create()->declineNewRequest($oldModel);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Request::find()->andWhere(['<>', 'done', RequestStatus::INTERNAL_OPERATIONS])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetGridRow($id)
    {
        return $this->renderPartial('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Request::find()->andWhere(['id' => $id]),
            ]),
        ]);
    }

    public function actionGetGridNewRows($id)
    {
        return $this->renderPartial('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Request::find()
                    ->andWhere(['>', 'id', $id])
                    ->andWhere(['<>', 'done', RequestStatus::INTERNAL_OPERATIONS])
                    ->orderBy('id DESC'),
            ]),
        ]);
    }

    public function actionGetProcTime()
    {
        $response = [];

        $ids = \Yii::$app->request->post('id');

        if ($ids) {
            /** @var Request[] $models */
            $models = Request::find()->andWhere(['id' => $ids])->all();

            foreach ($models as $model) {
                $response[$model->id] = $model->getWorkTimeStr();
            }
        }

        return $this->asJson($response);
    }

    public function actionGetForm($id, $form)
    {
        $model = $this->loadModel($id);

        return $this->renderPartial('forms/' . $form, compact('model'));
    }

    public function actionTake($id)
    {
        $model = $this->loadModel($id);

        $model->done = RequestStatus::NEW_CREATED;
        $model->performed_at = gmdate('Y-m-d H:i:s');
        $model->save(false);

        MailHelper::onBidCreate($model);

        return $this->asJson(['success' => true, 'id' => $id]);
    }

    public function actionComplete($id)
    {
        $model = $this->loadModel($id);

        $form = new CompleteRequestForm($model);
        if ($model->currencyTo->isCrypt()) {
            $form->setScenario(CompleteRequestForm::SCENARIO_CRYPT);
        }

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            AccountingService::create()->completeRequest($model, $form);
        } else {
            return $this->asJson(['error' => Html::errorSummary($form)]);
        }

        return $this->asJson(['success' => true, 'id' => $id]);
    }

    public function actionDecline($id)
    {
        $model = $this->loadModel($id);

        if ($model->done == RequestStatus::NEW_CREATED || $model->done == RequestStatus::DRAFT) {
            AccountingService::create()->declineNewRequest($model);
        } else if ($model->done == RequestStatus::COMPLETE) {
            AccountingService::create()->declineCompleteRequest($model);
        }

        return $this->asJson(['success' => true, 'id' => $id]);
    }

    public function actionSaveComment($id)
    {
        $model = $this->loadModel($id);

        if ($model->load(\Yii::$app->request->post())) {
            $model->save(false, ['description']);
        }

        return $this->asJson(['success' => true, 'id' => $id]);
    }

    public function actionSaveSumPush($id)
    {
        $model = $this->loadModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            AccountingService::create()->recalculatePushPullAmounts($model);
        }

        return $this->asJson(['success' => true, 'id' => $id]);
    }

    public function actionSendBTC($id)
    {
        return $this->asJson(['success' => false, 'error' => 'Service not implements', 'id' => $id]);
    }

    public function actionSendEth($id)
    {
        $result = false;

        $model = $this->loadModel($id);
        $form = new SendETHForm($model);

        /** @var CoinbaseService $srv */
        $srv = \Yii::$app->coinbase;

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $result = $srv->sendETHFunds($form->address, $form->amount, $model->id);
        }

        if ($result) {
            $model->btc_send_success = true;
            $model->save(false);
        }

        return $this->asJson(['success' => $result, 'error' => $srv->getLastError(), 'id' => $model->id]);
    }

    /**
     * @param $id
     * @return Request
     * @throws NotFoundHttpException
     */
    protected function loadModel($id)
    {
        $model = Request::findOne(['id' => $id]);
        if (!$model) {
            throw new NotFoundHttpException('Bad');
        }

        return $model;
    }
}
