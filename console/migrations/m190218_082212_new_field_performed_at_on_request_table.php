<?php

use yii\db\Migration;

/**
 * Class m190218_082212_new_field_performed_at_on_request_table
 */
class m190218_082212_new_field_performed_at_on_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Request::tableName(), 'performed_at', $this->dateTime()->null()->defaultValue(NULL)->after('processed_at'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190218_082212_new_field_performed_at_on_request_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190218_082212_new_field_performed_at_on_request_table cannot be reverted.\n";

        return false;
    }
    */
}
