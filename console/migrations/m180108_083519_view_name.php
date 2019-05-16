<?php

use common\models\Currencies;
use yii\db\Migration;

class m180108_083519_view_name extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Currencies::tableName(), 'view_name', $this->string(20));

        foreach (Currencies::find()->all() as $model) {

            if ($model->send == 'QWRUB') {
                $model->view_name = 'QIWI';
            }

            if ($model->send == 'SBERRUB') {
                $model->view_name = 'Сбербанк';
            }

            if ($model->send == 'BTC') {
                $model->view_name = 'Bitcoin';
            }

            if ($model->send == 'ETH') {
                $model->view_name = 'Ethereum';
            }

            if ($model->send == 'YAMRUB') {
                $model->view_name = 'Яндекс деньги';
            }

            if ($model->send == 'ACRUB') {
                $model->view_name = 'Альфа банк';
            }

            if ($model->send == 'TCSBRUB') {
                $model->view_name = 'Тинькофф';
            }

            $model->save(false);

        }
    }

    public function safeDown()
    {
        echo "m180108_083519_view_name cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180108_083519_view_name cannot be reverted.\n";

        return false;
    }
    */
}
