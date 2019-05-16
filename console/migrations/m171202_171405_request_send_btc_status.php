<?php

use common\models\Request;
use yii\db\Migration;

class m171202_171405_request_send_btc_status extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'btc_send_success', $this->boolean()->notNull()->defaultValue(false));
    }

    public function safeDown()
    {
        echo "m171202_171405_request_send_btc_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171202_171405_request_send_btc_status cannot be reverted.\n";

        return false;
    }
    */
}
