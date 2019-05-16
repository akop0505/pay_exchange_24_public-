<?php

use yii\db\Migration;

class m170530_161354_alter_direction extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `directions` 
ADD COLUMN `limit_min` FLOAT NULL DEFAULT NULL AFTER `d_out`,
ADD COLUMN `limit_max` FLOAT NULL DEFAULT NULL AFTER `limit_min`;
");
    }

    public function down()
    {
            echo "m170530_161354_alter_direction cannot be reverted.\n";

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
