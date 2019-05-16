<?php
namespace frontend\controllers;


use common\models\blockchain\BalanceMonitorResponse;
use common\models\enum\CryptCurrencyBidStatus;
use common\models\Request;
use yii\web\Controller;


class BlockchainInfoController extends Controller
{
    const RESPONSE_OK = '*ok*';

    const RESPONSE_BAD = '*not_ok*';



    public function actionCheckCallback()
    {
        \Yii::info("Callback invoke \r\n" . print_r($_REQUEST, true) . "\r\n", 'btc_monitor_create_callback');
        return;


        $result = self::RESPONSE_BAD;

        $respModel = new BalanceMonitorResponse();

        if ($respModel->load(\Yii::$app->request->get(), '') && $respModel->validate()) {


            $model = Request::findOne(['requisites' => $respModel->address]);

            // не нашли заявку с таким адресом, сразу останавливаем нотификации
            if (!$model) {
                \Yii::info("Model not found \r\n", 'btc_monitor_create_callback');

                return self::RESPONSE_OK;
            }

            if ($respModel->confirmations < 3) {

                $model->is_confirmed = CryptCurrencyBidStatus::WAIT;
                $model->blockchain_confirmations = $respModel->confirmations;

            } else if ($respModel->confirmations >= 3) {

                $model->is_confirmed = CryptCurrencyBidStatus::CONFIRMED;
                $model->blockchain_confirmations = $respModel->confirmations;

                $result = self::RESPONSE_OK;

            }

            $model->blockchain_value = $respModel->value;

            $model->save(false);

        } else {
            \Yii::info("Bad model validate \r\n", 'btc_monitor_create_callback');
        }

        return $result;
    }
}
