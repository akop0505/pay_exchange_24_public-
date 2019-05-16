<?php

use common\models\Currencies;
use yii\db\Migration;

class m171116_090020_step1_text extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Currencies::tableName(), 'first_step_text', $this->text());
    }

    public function safeDown()
    {
        echo "m171116_090020_step1_text cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171116_090020_step1_text cannot be reverted.\n";

        return false;
    }
    */
}
