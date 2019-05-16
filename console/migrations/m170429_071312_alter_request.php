<?php

use yii\db\Migration;

class m170429_071312_alter_request extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `request` 
ADD COLUMN `is_confirmed` INT(1) NULL AFTER `exchange_price`;
");
    }

    public function down()
    {
        $this->dropColumn('request', 'is_confirmed');
    }
}
