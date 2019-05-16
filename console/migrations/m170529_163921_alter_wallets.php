<?php

use yii\db\Migration;

class m170529_163921_alter_wallets extends Migration
{
    public function up()
    {
        $this->addColumn('income', 'comission', $this->string()->null()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('income', 'comission');
    }
}
