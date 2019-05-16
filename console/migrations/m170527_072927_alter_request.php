<?php

use yii\db\Migration;

class m170527_072927_alter_request extends Migration
{
    public function up()
    {
        $this->addColumn('request', 'description', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn('request', 'description');
    }
}
