<?php

use yii\db\Migration;

class m170618_034411_add_referrers extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE `referrers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `referrer` VARCHAR(255) NULL DEFAULT NULL,
  `additional` FLOAT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));
");
    }

    public function down()
    {
        echo "m170618_034411_add_referrers cannot be reverted.\n";

        return false;
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
