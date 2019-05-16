<?php
namespace backend\controllers;


use backend\components\Controller;
use common\models\Reserves;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReservesController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getGridModelQuery(),
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

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

    protected function getGridModelQuery()
    {
        return Reserves::find()->orderBy('currency');
    }
}
