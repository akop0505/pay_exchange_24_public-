<?php

use common\models\Request;
use yii\db\Migration;

class m180324_135709_cash_attr extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'attr_city', $this->string());
        $this->addColumn(Request::tableName(), 'attr_phone', $this->string(20));
        $this->addColumn(Request::tableName(), 'attr_name', $this->string(30));
    }

    public function safeDown()
    {
        echo "m180324_135709_cash_attr cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180324_135709_cash_attr cannot be reverted.\n";

        return false;
    }
    */
}
