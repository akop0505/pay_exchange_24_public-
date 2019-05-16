<?php

use backend\modules\bestchange\models\MonitorBestchange;
use common\models\Currencies;
use common\models\Directions;
use common\models\enum\WalletType;
use common\models\Reserves;
use common\models\Wallets;
use common\services\CurrenciesService;
use yii\db\Migration;

class m171003_000525_tks extends Migration
{
    public function safeUp()
    {
        $model = new Wallets();
        $model->direction = 'TCSBRUB';
        $model->balance = '0';
        $model->type = WalletType::CURRENCY;
        $model->requisite = 'EMPTY';
        if (!$model->save()) {
        }

        $wModel = new Wallets();
        $wModel->direction = 'TCSBRUB';
        $wModel->balance = '0';
        $wModel->type = WalletType::CURRENCY;
        $wModel->requisite = 'EMPTY';
        if (!$wModel->save()) {
        }

        $model = new Currencies();
        $model->send = 'TCSBRUB';
        $model->currency = 'руб';
        $model->pay_link = 'https://www.tinkoff.ru/login/';
        $model->pay_text = 'Номер карты Тинькофф банка';
        $model->id_wallet = $wModel->id;
        if (!$model->save()) {
        }

        $rModel = new Reserves();
        $rModel->currency = 'TCSBRUB';
        $rModel->amount = 0;
        $rModel->description = 'Тинькофф банк';
        if (!$rModel->save()) {
        }


        $added = [];
        /** @var Directions $dModel */
        foreach (Directions::find()->all() as $dModel) {

            if (in_array($dModel->d_to, $added)) {
                continue;
            }

            $model = new Directions();
            $model->d_from = 'TCSBRUB';
            $model->d_to = $dModel->d_to;
            $model->price_id = $dModel->price_id;

            if (!$model->save(false)) {
            }

            $added[] = $dModel->d_to;
        }

        foreach ($added as $curFrom) {
            $model = new Directions();
            $model->d_from = $curFrom;
            $model->d_to = 'TCSBRUB';
            $model->price_id = $rModel->id;

            if (!$model->save(false)) {
            }
        }


    }

    public function safeDown()
    {
        echo "m171003_000525_tks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171003_000525_tks cannot be reverted.\n";

        return false;
    }
    */
}
