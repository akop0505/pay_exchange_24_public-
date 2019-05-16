<?php

use yii\db\Migration;

class m170715_110503_alter_request extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE `request` 
ADD COLUMN `exchange_price_dfrom` VARCHAR(45) NULL DEFAULT NULL AFTER `fio_to`;
");
    }

    public function safeDown()
    {
        echo "m170715_110503_alter_request cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170715_110503_alter_request cannot be reverted.\n";

        return false;
    }
    */
}
