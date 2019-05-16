<?php

use yii\db\Migration;

class m170819_111420_alter_user extends Migration
{
    public function safeUp()
    {
            $this->execute("ALTER TABLE `users` ADD `comment` VARCHAR(1024) NULL DEFAULT NULL AFTER `role`;");
    }

    public function safeDown()
    {
        echo "m170819_111420_alter_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170819_111420_alter_user cannot be reverted.\n";

        return false;
    }
    */
}
