<?php

use common\models\Request;
use yii\db\Migration;

class m180108_101211_req_tx_link extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'tx_link', $this->text());
    }

    public function safeDown()
    {
        echo "m180108_101211_req_tx_link cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180108_101211_req_tx_link cannot be reverted.\n";

        return false;
    }
    */
}
