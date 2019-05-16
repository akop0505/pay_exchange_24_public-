<?php

use yii\db\Migration;

class m170429_122627_alter_request_add_transaction_amount extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `request` 
ADD COLUMN `transaction_amount` VARCHAR(255) NULL AFTER `is_confirmed`;
");
    }

    public function down()
    {
        $this->dropColumn('request', 'transaction_amount');
    }
}
