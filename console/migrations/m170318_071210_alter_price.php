<?php

use yii\db\Migration;

class m170318_071210_alter_price extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `price` 
CHANGE COLUMN `amount` `amount` DECIMAL(15,7) NULL DEFAULT NULL ;
");
    }

    public function down()
    {
        echo "m170318_071210_alter_price cannot be reverted.\n";

        return false;
    }
}
