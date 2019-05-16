<?php

use yii\db\Migration;

/**
 * Class m190208_065220_edit_wallets_balance_type_to_decimal
 */
class m190208_065220_edit_wallets_balance_type_to_decimal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('wallets','balance','decimal(20,10)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190208_065220_edit_wallets_balance_type_to_decimal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190208_065220_edit_wallets_balance_type_to_decimal cannot be reverted.\n";

        return false;
    }
    */
}
