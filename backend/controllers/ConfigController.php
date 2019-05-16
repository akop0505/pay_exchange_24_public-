<?php

namespace backend\controllers;

use backend\components\Controller;
use backend\models\Shedule;
use common\models\Settings;
use Yii;

class ConfigController extends Controller
{
    public function actionShedule()
    {
    	$model = new Shedule();

    	if (isset($_POST['mode'])) {
    		$model->setMode($_POST['mode']);

    		return $this->redirect(['index']);
    	}

    	return $this->render('index');
    }

    public function actionIndex()
    {
        $model = Settings::get();

        return $this->render('index', compact('model'));
    }

    public function actionEnableWorks($enable)
    {
        $model = Settings::get();
        $model->enable_tech_works = intval((bool) $enable);
        $model->save(false);
    }

    public function actionEnableNewYear($enable)
    {
        $model = Settings::get();
        $model->enable_new_year = intval((bool) $enable);
        $model->save(false);

        return $this->asJson(['enable' => $model->enable_new_year]);
    }

    public function actionSave()
    {
        $model = Settings::get();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
        }

        return $this->redirect(['index']);
    }
}
