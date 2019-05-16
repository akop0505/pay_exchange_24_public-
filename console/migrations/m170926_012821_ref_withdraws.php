<?php

use yii\db\Migration;

class m170926_012821_ref_withdraws extends Migration
{
    public function safeUp()
    {
        $this->createTable('referrals_withdraws', [
            'id' => $this->primaryKey(),
            'referral_id' => $this->integer()->notNull(),
            'amount' => $this->string(30)->notNull(),
            'created_at' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP',
        ]);
    }

    public function safeDown()
    {
        echo "m170926_012821_ref_withdraws cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170926_012821_ref_withdraws cannot be reverted.\n";

        return false;
    }
    */
}
