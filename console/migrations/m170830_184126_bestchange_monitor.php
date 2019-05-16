<?php

use yii\db\Migration;

class m170830_184126_bestchange_monitor extends Migration
{
    public function safeUp()
    {
        $this->createTable('monitor_bestchange', [
            'id' => $this->primaryKey(),
            'direction_id' => $this->integer()->notNull(),

            'limit_min' => $this->string()->defaultValue(0),
            'limit_max' => $this->string()->defaultValue(0),

            'current_position' => $this->integer()->defaultValue(0),
            'target_position' => $this->integer()->defaultValue(0),
            'total_positions' => $this->integer()->defaultValue(0),

            'monitor_from_id' => $this->integer()->notNull(),
            'monitor_to_id' => $this->integer()->notNull(),
            'monitor_direction_url' => $this->string(),

            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('monitor_bc_to_directions_ref', 'monitor_bestchange', 'direction_id', 'directions', 'id');
    }

    public function safeDown()
    {
        echo "m170830_184126_bestchange_monitor cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170830_184126_bestchange_monitor cannot be reverted.\n";

        return false;
    }
    */
}
