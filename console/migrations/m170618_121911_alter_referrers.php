<?php

use yii\db\Migration;

class m170618_121911_alter_referrers extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `referrers` 
ADD COLUMN `exchange_amount` FLOAT NULL DEFAULT NULL AFTER `additional`;
");
    }

    public function down()
    {
        echo "m170618_121911_alter_referrers cannot be reverted.\n";

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
