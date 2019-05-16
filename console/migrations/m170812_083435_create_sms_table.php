<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sms`.
 */
class m170812_083435_create_sms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sms_log', [
            'id' => $this->primaryKey(),
            'number' => $this->string(255)->notNull(),
            'name' => $this->string(255),
            'body' => $this->text(),
            'date' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sms_log');
    }
}
