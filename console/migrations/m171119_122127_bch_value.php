<?php

use common\models\Request;
use yii\db\Migration;

class m171119_122127_bch_value extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'blockchain_value', $this->string(20));
    }

    public function safeDown()
    {
        echo "m171119_122127_bch_value cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171119_122127_bch_value cannot be reverted.\n";

        return false;
    }
    */
}
