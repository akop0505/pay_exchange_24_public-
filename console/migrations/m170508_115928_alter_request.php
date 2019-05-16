<?php

use yii\db\Migration;

class m170508_115928_alter_request extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `request` 
ADD COLUMN `currency_to_wallet` INT NULL DEFAULT NULL AFTER `transaction_amount`;
");
    }

    public function down()
    {
        $this->dropColumn("request", "currency_to_wallet");
    }
}
