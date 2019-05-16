<?php

namespace common\helpers;


use common\models\Request;
use frontend\models\Bids;

class MailHelper
{

    /**
     * @param Request|Bids $model
     */
    public static function onBidCreate($model)
    {
        \Yii::$app->mailer
            ->compose('requests/new-for-user', ['model' => $model])
            ->setSubject("Состояние заявки № {$model->id} на сайте " . \Yii::$app->name)
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo($model->email)
            ->send();


        \Yii::$app->mailer
            ->compose('requests/new-for-moder', ['model' => $model])
            ->setSubject("Новая заявка № {$model->id}")
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo(\Yii::$app->params['supportEmail'])
            ->send();
    }
}