<?php

use common\models\Settings;
use yii\db\Migration;

class m170908_125848_set_autobalnce extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Settings::tableName(), 'enable_bc_autobalance', $this->boolean()->notNull()->defaultValue(false));
    }

    public function safeDown()
    {
        echo "m170908_125848_set_autobalnce cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170908_125848_set_autobalnce cannot be reverted.\n";

        return false;
    }
    */
}
