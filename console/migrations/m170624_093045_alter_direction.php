<?php

use yii\db\Migration;

class m170624_093045_alter_direction extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `directions` 
ADD COLUMN `target` INT NULL DEFAULT NULL AFTER `price_id`;
");
    }

    public function down()
    {
        echo "m170624_093045_alter_direction cannot be reverted.\n";

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
