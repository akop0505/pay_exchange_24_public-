<?php

use yii\db\Migration;

class m170508_111012_alter_currencies extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `currencies` 
ADD COLUMN `id_wallet` INT NULL DEFAULT NULL AFTER `pay_fio`;
");
    }

    public function down()
    {
        $this->dropColumn("currencies", "id_wallet");
    }
}
