<?php

use yii\db\Migration;

/**
 * Class m180912_173309_static_wallets
 */
class m180912_173309_static_wallets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('static_wallets', [
            'id' => $this->primaryKey(),
            'currency' => $this->string(10)->notNull()->defaultValue('BTC'),
            'wallet' => $this->string()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),

        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180912_173309_static_wallets cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180912_173309_static_wallets cannot be reverted.\n";

        return false;
    }
    */
}
