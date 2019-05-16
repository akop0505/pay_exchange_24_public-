<?php

use yii\db\Migration;

class m170507_063457_add_wallets extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE `wallets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `direction` VARCHAR(45) NULL DEFAULT NULL,
  `balance` VARCHAR(45) NULL DEFAULT NULL,
  `requisite` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));");
    }

    public function down()
    {
        $this->dropTable('wallets');
    }
}
