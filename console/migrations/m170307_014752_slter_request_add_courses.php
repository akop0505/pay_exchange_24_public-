<?php

use yii\db\Migration;

class m170307_014752_slter_request_add_courses extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE `request` 
ADD COLUMN `current_course_btc` VARCHAR(45) NULL AFTER `fio_to`;
');
    }

    public function down()
    {
        $this->dropColumn('request', 'current_course_btc');
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
