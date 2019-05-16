<?php

use yii\db\Migration;

/**
 * Class m190219_150156_add_withdraw_percent_to_users_table
 */
class m190219_150156_add_withdraw_percent_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\User::tableName(), 'withdraw_percent', $this->double(4)->null()->defaultValue(0)->after('role'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\User::tableName(), 'withdraw_percent');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_150156_add_withdraw_percent_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
