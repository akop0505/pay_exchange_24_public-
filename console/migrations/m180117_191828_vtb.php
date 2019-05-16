<?php

use backend\modules\bestchange\models\MonitorBestchange;
use common\models\Currencies;
use common\models\Directions;
use common\models\enum\WalletType;
use common\models\Reserves;
use common\models\Wallets;
use yii\db\Migration;

class m180117_191828_vtb extends Migration
{
    public function safeUp()
    {
        define('CURRENCY_CODE', 'VTB24');


        $wModel = new Wallets();
        $wModel->direction = CURRENCY_CODE;
        $wModel->balance = '0';
        $wModel->type = WalletType::CURRENCY;
        $wModel->requisite = 'EMPTY';
        if (!$wModel->save()) {
            dbg($wModel->errors);
        }

        $model = new Currencies();
        $model->send = CURRENCY_CODE;
        $model->currency = 'руб';
        $model->pay_link = 'https://online.vtb.ru/content/v/ru/login.html';
        $model->pay_text = 'Номер карты ВТБ24';
        $model->view_code = 'VTB24 RUB';
        $model->view_name = 'ВТБ24';
        $model->id_wallet = $wModel->id;
        if (!$model->save()) {
            dbg($model->errors);
        }

        $rModel = new Reserves();
        $rModel->currency = CURRENCY_CODE;
        $rModel->amount = 0;
        $rModel->description = 'ВТБ24';
        if (!$rModel->save()) {
            dbg($rModel->errors);
        }


        $added = [];
        /** @var Directions $dModel */
        foreach (Directions::find()->all() as $dModel) {

            if (in_array($dModel->d_to, $added)) {
                continue;
            }

            $model = new Directions();
            $model->d_from = CURRENCY_CODE;
            $model->d_to = $dModel->d_to;
            $model->price_id = $dModel->price_id;

            if (!$model->save(false)) {
                dbg($model->errors);
            }

            $added[] = $dModel->d_to;
        }

        foreach ($added as $curFrom) {
            $model = new Directions();
            $model->d_from = $curFrom;
            $model->d_to = CURRENCY_CODE;
            $model->price_id = $rModel->id;

            if (!$model->save(false)) {
                dbg($model->errors);
            }
        }





        $d = [
            'QWRUB' => 63,
            'SBERRUB' => 42,
            'ACRUB' => 52,
            'YAMRUB' => 6,
            'TCSBRUB' => 105,
            'BTC' => 93,
            'ETH' => 139,
            'BCH' => 172,
        ];

        /** @var Directions $dModel */
        foreach (Directions::find()->all() as $dModel) {

            if ($dModel->bestchangeDirection) {
                continue;
            }

            $model = new MonitorBestchange();
            $model->direction_id = $dModel->id;

            if ($dModel->d_from == CURRENCY_CODE) {
                $model->monitor_from_id = 51;
                $model->monitor_to_id = $d[$dModel->d_to];
            } else if ($dModel->d_to == CURRENCY_CODE) {
                $model->monitor_from_id = $d[$dModel->d_from];
                $model->monitor_to_id = 51;
            }

            if (!$model->save(false)) {
                dbg($model->errors);
            }

        }



    }

    public function safeDown()
    {
        echo "m180117_191828_vtb cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180117_191828_vtb cannot be reverted.\n";

        return false;
    }
    */
}
