<?php

use yii\db\Migration;

class m170507_022014_alter_income extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE`income` 
ADD COLUMN `display` INT NULL DEFAULT 0 AFTER `amount`;
");
    }

    public function down()
    {
        $this->dropColumn('income', 'display');
    }
}