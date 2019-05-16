<?php

use common\models\Wallets;
use yii\db\Migration;

/**
 * Class m190125_114359_wallet_rotation
 */
class m190125_114359_wallet_rotation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Wallets::tableName(), 'in_rotation', $this->boolean()->notNull()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190125_114359_wallet_rotation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190125_114359_wallet_rotation cannot be reverted.\n";

        return false;
    }
    */
}
