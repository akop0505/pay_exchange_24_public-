<?php

use common\models\Request;
use yii\db\Migration;

class m170824_143812_bc_conf_count extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'blockchain_confirmations', $this->integer());
    }

    public function safeDown()
    {
        echo "m170824_143812_bc_conf_count cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170824_143812_bc_conf_count cannot be reverted.\n";

        return false;
    }
    */
}
