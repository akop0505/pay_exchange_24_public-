<?php

use backend\modules\bestchange\models\MonitorBestchange;
use common\models\CryptRates;
use common\models\Currencies;
use common\models\Directions;
use common\models\enum\WalletType;
use common\models\Reserves;
use common\models\Wallets;
use yii\db\Migration;

class m180324_125836_currency_cash extends Migration
{
    public function safeUp()
    {
        define('CURRENCY_CODE', 'CASHRUB');


        $wModel = new Wallets();
        $wModel->active = true;
        $wModel->direction = CURRENCY_CODE;
        $wModel->balance = '0';
        $wModel->type = WalletType::CURRENCY;
        $wModel->requisite = 'EMPTY';
        if (!$wModel->save()) {
            dbg($wModel->errors);
        }

        $model = new Currencies();
        $model->send = CURRENCY_CODE;
        $model->currency = 'RUB';
        $model->pay_link = '';
        $model->pay_text = '';
        $model->view_code = CURRENCY_CODE;
        $model->view_name = 'Наличные RUB';
        $model->id_wallet = $wModel->id;
        if (!$model->save()) {
            dbg($model->errors);
        }

        $rModel = new Reserves();
        $rModel->currency = CURRENCY_CODE;
        $rModel->amount = 0;
        $rModel->description = 'Наличные RUB';
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
            'VTB24' => 51,
        ];

        /** @var Directions $dModel */
        /*foreach (Directions::find()->all() as $dModel) {

            if ($dModel->bestchangeDirection) {
                continue;
            }

            $model = new MonitorBestchange();
            $model->direction_id = $dModel->id;

            if ($dModel->d_from == CURRENCY_CODE) {
                $model->monitor_from_id = 161;
                $model->monitor_to_id = $d[$dModel->d_to];
            } else if ($dModel->d_to == CURRENCY_CODE) {
                $model->monitor_from_id = $d[$dModel->d_from];
                $model->monitor_to_id = 161;
            }

            if (!$model->save(false)) {
                dbg($model->errors);
            }

        }*/

    }

    public function safeDown()
    {
        echo "m180324_125836_currency_cash cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180324_125836_currency_cash cannot be reverted.\n";

        return false;
    }
    */
}
