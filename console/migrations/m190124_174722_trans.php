<?php

use common\models\Request;
use common\models\Wallets;
use yii\db\Migration;

/**
 * Class m190124_174722_trans
 */
class m190124_174722_trans extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Wallets::tableName(), 'trans_receive', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn(Wallets::tableName(), 'trans_available', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn(Wallets::tableName(), 'trans_sends', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_174722_trans cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190124_174722_trans cannot be reverted.\n";

        return false;
    }
    */
}
