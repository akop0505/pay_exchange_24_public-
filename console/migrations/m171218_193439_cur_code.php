<?php

use common\models\Currencies;
use yii\db\Migration;

class m171218_193439_cur_code extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Currencies::tableName(), 'view_code', $this->string(20));

        foreach (Currencies::find()->all() as $model) {

            if ($model->send == 'QWRUB') {
                $model->view_code = 'QIWI RUB';
            }
            if ($model->send == 'SBERRUB') {
                $model->view_code = 'SBER RUB';
            }

            if ($model->send == 'BTC') {
                $model->view_code = 'BTC';
            }

            if ($model->send == 'ETH') {
                $model->view_code = 'ETH';
            }

            if ($model->send == 'YAMRUB') {
                $model->view_code = 'YAND RUB';
            }

            if ($model->send == 'ACRUB') {
                $model->view_code = 'ALPHA RUB';
            }
            if ($model->send == 'TCSBRUB') {
                $model->view_code = 'TKS RUB';
            }

            $model->save(false);
            
        }
    }

    public function safeDown()
    {
        //$model->view_code = "m171218_193439_cur_code cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        $model->view_code = "m171218_193439_cur_code cannot be reverted.\n";

        return false;
    }
    */
}
