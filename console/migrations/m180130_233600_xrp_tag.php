<?php

use common\models\Request;
use yii\db\Migration;

class m180130_233600_xrp_tag extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'ripple_tag', $this->string(20));
    }

    public function safeDown()
    {
        echo "m180130_233600_xrp_tag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180130_233600_xrp_tag cannot be reverted.\n";

        return false;
    }
    */
}
