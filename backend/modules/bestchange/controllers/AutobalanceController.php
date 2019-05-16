<?php

namespace backend\modules\bestchange\controllers;


use backend\components\Controller;
use backend\modules\bestchange\models\enum\AutobalancePosition;
use backend\modules\bestchange\models\MonitorDirection;
use backend\modules\bestchange\parsers\RatesParserInterface;
use common\models\Settings;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class AutobalanceController
 * @package backend\modules\bestchange
 */
class AutobalanceController extends Controller
{
    private $ratesProvider;


    public function __construct($id, $module, RatesParserInterface $ratesProvider, $config = [])
    {
        $this->ratesProvider = $ratesProvider;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $query = MonitorDirection::find()
            ->joinWith('direction')
            /*->andWhere([
                'OR',
                ['directions.d_from' => 'QWRUB', 'directions.d_to' => 'BTC'],
                ['directions.d_from' => 'BTC', 'directions.d_to' => 'QWRUB']
            ])*/
            ->orderBy('d_from, d_to');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 500,
            ],
            'sort' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'ratesList' => $this->ratesProvider->getRates(),
        ]);
    }

    public function actionSaveAttribute($id)
    {
        $updateImmediate = false;

        $model = $this->findDirection($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            if ($model->getOldAttribute('target_position') != $model->target_position) {
                $updateImmediate = true;
            }

            $model->save(false);
        }

        if ($updateImmediate) {
            \Yii::$container->get('autobalancer')->balance();
        }

        return $this->asJson(compact('model', 'updateImmediate'));
    }

    public function actionUpdateData()
    {
        $data = [];

        foreach ($this->ratesProvider->getRates() as $list) {
            if (!$list->isExchangerPresents()) {
                continue;
            }

            $data[$list->getMonitorDirection()->direction_id] = [
                'currentPosition' => $list->exchangerPosition,
                'currentPositionStatus' => AutobalancePosition::getGridStatusClass()[$list->getExchangerPositionStatus()],
                'totalPositions' =>  $list->totalPositions,
                'courseStr' => $list->exchangerRate->getRateStr(),
            ];
        }

        return $this->asJson($data);
    }

    public function actionEnable($enable)
    {
        $settings = Settings::get();

        $settings->enable_bc_autobalance = (bool) $enable;
        $settings->save(false);

        return $this->asJson(['success' => true]);
    }

    public function actionAjax()
    {
        try {
            \Yii::$container->get('autobalancer')->balance();
        } catch (\Exception $e) {
            \Yii::$app->response->setStatusCode(500);
            return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
        }

        return $this->asJson(['success' => true]);
    }

    /**
     * @param $id
     * @return MonitorDirection
     * @throws NotFoundHttpException
     */
    protected function findDirection($id)
    {
        $model = MonitorDirection::findOne(['id' => $id]);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
