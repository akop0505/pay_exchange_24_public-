<?php

use yii\db\Migration;

class m170509_052232_alter_request_currenc extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `request` 
ADD COLUMN `currency_from_wallet` INT NULL DEFAULT NULL AFTER `transaction_amount`;
");
    }

    public function down()
    {
        $this->dropColumn("request", "currency_from_wallet");
    }
}
