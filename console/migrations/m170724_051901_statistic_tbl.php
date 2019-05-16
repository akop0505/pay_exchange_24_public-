<?php

use yii\db\Migration;

class m170724_051901_statistic_tbl extends Migration
{
    public function safeUp()
    {
        $this->createTable('exg_statistics', [
            'id' => $this->primaryKey(),
            'event' => $this->string()->notNull(),
            'cur_source' => $this->string(10)->notNull(),
            'cur_dest' => $this->string(10)->notNull(),

            'data_1' => $this->integer(),
            'data_2' => $this->string(),

            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        echo "m170724_051901_statistic_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170724_051901_statistic_tbl cannot be reverted.\n";

        return false;
    }
    */
}
