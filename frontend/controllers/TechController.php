<?php

namespace frontend\controllers;

use common\models\Settings;
use frontend\components\Controller;


/**
 * Class TechController
 * @package frontend\controllers
 */
class TechController extends Controller
{
    public function actionWorks()
    {
        return $this->render('works', [
            'settings' => Settings::findOne(['id' => 1])
        ]);
    }

    public function actionNewYear()
    {
        return $this->render('new-year');
    }
}
