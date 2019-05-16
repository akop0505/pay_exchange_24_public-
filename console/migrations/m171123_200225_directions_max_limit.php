<?php

use common\models\Directions;
use yii\db\Migration;

class m171123_200225_directions_max_limit extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Directions::tableName(), 'exchange_limit_max', $this->string());
    }

    public function safeDown()
    {
        echo "m171123_200225_directions_max_limit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171123_200225_directions_max_limit cannot be reverted.\n";

        return false;
    }
    */
}
