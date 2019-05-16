<?php

namespace frontend\components;

use common\models\Settings;
use Yii;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->request->pathInfo == 'pay.xml') {

            return true;

        } else {

            if (Settings::get()->enable_new_year && $action->id != 'new-year') {

                $this->redirect(['tech/new-year'])->send();

            } else if (!Settings::get()->enable_new_year && Settings::get()->enable_tech_works && $action->id != 'works') {

                $this->redirect(['tech/works'])->send();

            }

            return parent::beforeAction($action);
        }
    }
}