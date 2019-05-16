<?php

use backend\modules\bestchange\models\MonitorBestchange;
use common\models\Directions;
use yii\db\Migration;

class m171010_071237_tks_a extends Migration
{
    public function safeUp()
    {
        $d = [
            'QWRUB' => 63,
            'SBERRUB' => 42,
            'ACRUB' => 52,
            'YAMRUB' => 6,
            'BTC' => 93,
            'ETH' => 139,
        ];

        /** @var Directions $dModel */
        foreach (Directions::find()->all() as $dModel) {

            if ($dModel->bestchangeDirection) {
                continue;
            }

            $model = new MonitorBestchange();
            $model->direction_id = $dModel->id;

            if ($dModel->d_from == 'TCSBRUB') {
                $model->monitor_from_id = 105;
                $model->monitor_to_id = $d[$dModel->d_to];
            } else if ($dModel->d_to == 'TCSBRUB') {
                $model->monitor_from_id = $d[$dModel->d_from];
                $model->monitor_to_id = 105;
            }

            if (!$model->save(false)) {
                dbg($model->errors);
            }

        }
    }

    public function safeDown()
    {
        echo "m171010_071237_tks_a cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_071237_tks_a cannot be reverted.\n";

        return false;
    }
    */
}
