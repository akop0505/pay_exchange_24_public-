<?php

use yii\db\Migration;

class m170308_033923_alter_request_add_user_id extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `request` 
ADD COLUMN `user_id` INT NULL AFTER `id`;");
    }

    public function down()
    {
        $this->dropColumn('request', 'user_id');
    }
}
