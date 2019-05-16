<?php

use common\models\Request;
use yii\db\Migration;

/**
 * Class m181213_102902_bid_hash
 */
class m181213_102902_bid_hash extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'hash_id', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181213_102902_bid_hash cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181213_102902_bid_hash cannot be reverted.\n";

        return false;
    }
    */
}
