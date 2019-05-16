<?php

use yii\db\Migration;

class m170722_045642_alter_settings extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE `settings` 
ADD COLUMN `enable_auto_eth` INT NULL AFTER `enable_tech_works`;
");
    }

    public function safeDown()
    {
        echo "m170722_045642_alter_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170722_045642_alter_settings cannot be reverted.\n";

        return false;
    }
    */
}
