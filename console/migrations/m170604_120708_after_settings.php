<?php

use yii\db\Migration;

class m170604_120708_after_settings extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `settings` 
ADD COLUMN `enable_auto_bestchange` INT NULL DEFAULT NULL AFTER `enable_auto_btc`;
");

        $this->execute("ALTER TABLE `settings` 
ADD COLUMN `target` INT NULL AFTER `enable_tech_works`;
");
    }

    public function down()
    {
        echo "m170604_120708_after_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
