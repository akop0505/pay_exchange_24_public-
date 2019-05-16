<?php

use yii\db\Migration;

class m170625_134452_alter_currency extends Migration
{
    public function up()
    {
        $this->execute("INSERT INTO `currencies` (`currency`, `send`, `pay_link`, `pay_text`, `pay_number`) VALUES ('ETH', 'ETH', '1. Войти в свою программу-клиент ETH', 'Кошелек', '0xF3E982E6096673a99407B382Dca04Cd12e0eB5f9');
");
    }

    public function down()
    {
        echo "m170625_134452_alter_currency cannot be reverted.\n";

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
