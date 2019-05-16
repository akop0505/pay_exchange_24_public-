<?php

namespace frontend\controllers;


class CoinbaseController extends \yii\web\Controller
{
    public function actionCheckCallback()
    {
        \Yii::info("Callback invoke \r\n", 'coinbase_create_wallet');

        return '';
    }

    public function actionGlobalCallback()
    {
        \Yii::info("Callback invoke \r\n", 'coinbase_global');

        return '';
    }
}
