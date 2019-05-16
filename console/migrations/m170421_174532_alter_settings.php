<?php

use yii\db\Migration;

class m170421_174532_alter_settings extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `settings` 
ADD COLUMN `enable_tech_works` INT(1) NULL DEFAULT NULL AFTER `enable_auto_btc`,
ADD COLUMN `text_tech_works` VARCHAR(45) NULL AFTER `enable_tech_works`;
");

        $this->execute("UPDATE `settings` SET `enable_tech_works`='0', `text_tech_works`='23.04.17 10:00' WHERE `id`='1';
");
    }

    public function down()
    {
        echo "m170421_174532_alter_settings cannot be reverted.\n";

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
