<?php

use common\models\Reserves;
use yii\db\Migration;

/**
 * Class m181224_163956_alter_price
 */
class m181224_163956_alter_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(Reserves::tableName(), 'amount', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181224_163956_alter_price cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181224_163956_alter_price cannot be reverted.\n";

        return false;
    }
    */
}
