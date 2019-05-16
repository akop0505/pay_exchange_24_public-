<?php

use common\models\Settings;
use yii\db\Migration;

class m171222_032948_ny_settings extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Settings::tableName(), 'enable_new_year', $this->boolean()->notNull()->defaultValue(false));
    }

    public function safeDown()
    {
        echo "m171222_032948_ny_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171222_032948_ny_settings cannot be reverted.\n";

        return false;
    }
    */
}
