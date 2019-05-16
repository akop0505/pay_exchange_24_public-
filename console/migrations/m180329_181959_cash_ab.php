<?php

use backend\modules\bestchange\models\MonitorBestchange;
use common\models\Directions;
use yii\db\Migration;

class m180329_181959_cash_ab extends Migration
{
    public function safeUp()
    {
        define('CURRENCY_CODE', 'CASHRUB');

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
            'XRP' => 161,
        ];

        /** @var Directions $dModel */
        foreach (Directions::find()->all() as $dModel) {

            if ($dModel->bestchangeDirection) {
                continue;
            }

            $model = new MonitorBestchange();
            $model->direction_id = $dModel->id;

            if ($dModel->d_from == CURRENCY_CODE) {
                $model->monitor_from_id = 91;
                $model->monitor_to_id = $d[$dModel->d_to];
            } else if ($dModel->d_to == CURRENCY_CODE) {
                $model->monitor_from_id = $d[$dModel->d_from];
                $model->monitor_to_id = 91;
            }

            if (!$model->save(false)) {
                dbg($model->errors);
            }

        }
    }

    public function safeDown()
    {
        echo "m180329_181959_cash_ab cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180329_181959_cash_ab cannot be reverted.\n";

        return false;
    }
    */
}
