<?php

use backend\modules\bestchange\models\MonitorBestchange;
use common\models\Currencies;
use common\models\Directions;
use common\models\enum\WalletType;
use common\models\Reserves;
use common\models\Wallets;
use yii\db\Migration;

class m180109_023724_new_bth extends Migration
{
    public function safeUp()
    {
        define('BCH', 'BCH');
        
        
        $wModel = new Wallets();
        $wModel->direction = BCH;
        $wModel->balance = '0';
        $wModel->type = WalletType::CURRENCY;
        $wModel->requisite = 'EMPTY';
        if (!$wModel->save()) {
            dbg($wModel->errors);
        }

        $model = new Currencies();
        $model->send = BCH;
        $model->currency = 'BCH';
        $model->pay_link = '1. Войти в свою программу-клиент Bitcoin Cash';
        $model->pay_text = 'Кошелек';
        $model->view_code = 'BCH';
        $model->view_name = 'Bitcoin Cash';
        $model->id_wallet = $wModel->id;
        if (!$model->save()) {
            dbg($model->errors);
        }

        $rModel = new Reserves();
        $rModel->currency = BCH;
        $rModel->amount = 0;
        $rModel->description = 'Bitcoin Cash';
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
            $model->d_from = BCH;
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
            $model->d_to = BCH;
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
            'BTC' => 93,
            'ETH' => 139,
            'TCSBRUB' => 105,
        ];

        /** @var Directions $dModel */
        foreach (Directions::find()->all() as $dModel) {

            if ($dModel->bestchangeDirection) {
                continue;
            }

            $model = new MonitorBestchange();
            $model->direction_id = $dModel->id;

            if ($dModel->d_from == BCH) {
                $model->monitor_from_id = 172;
                $model->monitor_to_id = $d[$dModel->d_to];
            } else if ($dModel->d_to == BCH) {
                $model->monitor_from_id = $d[$dModel->d_from];
                $model->monitor_to_id = 172;
            }

            if (!$model->save(false)) {
                dbg($model->errors);
            }

        }



    }

    public function safeDown()
    {
        echo "m180109_023724_new_bth cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180109_023724_new_bth cannot be reverted.\n";

        return false;
    }
    */
}
