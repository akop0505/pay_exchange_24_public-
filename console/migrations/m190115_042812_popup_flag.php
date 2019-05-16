<?php

use common\models\Directions;
use yii\db\Migration;

/**
 * Class m190115_042812_popup_flag
 */
class m190115_042812_popup_flag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Directions::tableName(), 'bank_alert', $this->boolean()->notNull()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190115_042812_popup_flag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190115_042812_popup_flag cannot be reverted.\n";

        return false;
    }
    */
}
