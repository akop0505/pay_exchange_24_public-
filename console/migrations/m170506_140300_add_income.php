<?php

use yii\db\Migration;

class m170506_140300_add_income extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE `income` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_wallet` INT NULL DEFAULT NULL,
  `id_request` INT NULL DEFAULT NULL,
  `amount` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_request_idx` (`id_request` ASC),
  CONSTRAINT `id_request`
    FOREIGN KEY (`id_request`)
    REFERENCES `request` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
");
    }

    public function down()
    {
        $this->dropTable('income');
    }
}
