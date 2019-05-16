<?php

use common\models\Directions;
use yii\db\Migration;

class m171004_225644_directions_min_exch extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Directions::tableName(), 'exchange_limit_min', $this->string());
    }

    public function safeDown()
    {
        echo "m171004_225644_directions_min_exch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171004_225644_directions_min_exch cannot be reverted.\n";

        return false;
    }
    */
}
