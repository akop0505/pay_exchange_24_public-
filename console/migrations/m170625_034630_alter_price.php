<?php

use yii\db\Migration;

class m170625_034630_alter_price extends Migration
{
    public function up()
    {
        $this->execute("INSERT INTO `price` (`amount`, `currency`, `description`) VALUES ('0.9000000', 'ETH', 'Ethereum');");
    }

    public function down()
    {
        echo "m170625_034630_alter_price cannot be reverted.\n";

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
