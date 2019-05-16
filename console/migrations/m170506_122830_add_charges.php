<?php

use yii\db\Migration;

class m170506_122830_add_charges extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE `charges` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `request_id` INT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `amount` VARCHAR(255) NULL DEFAULT NULL,
  `currency` VARCHAR(45) NULL DEFAULT NULL,
  `date` DATETIME NULL,
  PRIMARY KEY (`id`));
");
    }

    public function down()
    {
        $this->dropTable('charges');
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
