<?php

use backend\modules\bestchange\services\Autobalancer;
use common\models\Directions;
use yii\db\Migration;

class m170912_234811_direction_types extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(Directions::tableName(), 'd_in', $this->string());
        $this->alterColumn(Directions::tableName(), 'd_out', $this->string());
    }

    public function safeDown()
    {
        echo "m170912_234811_direction_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170912_234811_direction_types cannot be reverted.\n";

        return false;
    }
    */
}
