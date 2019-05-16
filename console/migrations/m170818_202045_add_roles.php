<?php

use yii\db\Migration;

class m170818_202045_add_roles extends Migration
{
    public function safeUp()
    {
        $this->execute(
            "INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) 
            VALUES ('operator', '1', NULL, NULL, NULL, '1501665655', '1501665655');
            INSERT INTO `auth_item_child` (`parent`, `child`) VALUES ('admin', 'operator');");
    }

    public function safeDown()
    {
        echo "m170818_202045_add_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170818_202045_add_roles cannot be reverted.\n";

        return false;
    }
    */
}
