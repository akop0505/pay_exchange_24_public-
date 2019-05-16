<?php

use yii\db\Migration;

class m170308_114750_alter_request_change_btc extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE `request` 
CHANGE COLUMN `current_course_btc` `exchange_price` VARCHAR(45) CHARACTER SET \'utf8\' NULL DEFAULT NULL ;
');
    }

    public function down()
    {
        $this->execute('ALTER TABLE `request` 
CHANGE COLUMN `exchange_price` `current_course_btc` VARCHAR(45) CHARACTER SET \'utf8\' NULL DEFAULT NULL');
    }
}
