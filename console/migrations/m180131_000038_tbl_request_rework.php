<?php

use common\models\Request;
use yii\db\Migration;

class m180131_000038_tbl_request_rework extends Migration
{
    public function safeUp()
    {
        $this->renameColumn(Request::tableName(), 'comment', 'email');
        $this->dropColumn(Request::tableName(), 'fio');
        $this->dropColumn(Request::tableName(), 'count');
        $this->dropColumn(Request::tableName(), 'date_start');
    }

    public function safeDown()
    {
        echo "m180131_000038_tbl_request_rework cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180131_000038_tbl_request_rework cannot be reverted.\n";

        return false;
    }
    */
}
