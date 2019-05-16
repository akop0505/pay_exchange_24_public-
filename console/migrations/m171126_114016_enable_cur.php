<?php

use common\models\Reserves;
use yii\db\Migration;

class m171126_114016_enable_cur extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Reserves::tableName(), 'enable', $this->boolean()->notNull()->defaultValue(true));
    }

    public function safeDown()
    {
        echo "m171126_114016_enable_cur cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171126_114016_enable_cur cannot be reverted.\n";

        return false;
    }
    */
}
