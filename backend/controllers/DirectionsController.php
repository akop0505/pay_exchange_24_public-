<?php
namespace backend\controllers;


use backend\components\Controller;
use common\models\Directions;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class DirectionsController
 * @package backend\controllers
 */
class DirectionsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getGridModelQuery(),
            'pagination' => false,
            'sort' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSave()
    {
        $models = $this->getGridModelQuery()->all();

        if (Model::loadMultiple($models, \Yii::$app->request->post())) {

            foreach ($models as $i => $model) {
                $model->save();
            }
        }

        return $this->redirect(['index']);
    }

    public function actionSaveExchLimitMin()
    {
        $models = [];

        foreach ($this->getGridModelQuery()->all() as $m) {
            $models[] = $m->getExchangeLimitMinModel();
        }


        if (Model::loadMultiple($models, \Yii::$app->request->post())) {

            foreach ($models as $model) {
                $model->save();
            }
        }

        return $this->asJson([]);
    }

    public function actionSaveExchLimitMax()
    {
        $models = $this->getGridModelQuery()->all();

        if (Model::loadMultiple($models, \Yii::$app->request->post())) {

            foreach ($models as $model) {
                $model->save(true, ['exchange_limit_max']);
            }
        }

        return $this->asJson([]);
    }

    /**
     * @return ActiveQuery
     */
    protected function getGridModelQuery()
    {
        return Directions::find()->orderBy('d_from, d_to');
    }
}
