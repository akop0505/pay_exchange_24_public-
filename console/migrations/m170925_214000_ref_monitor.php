<?php

use common\models\Referrals;
use common\models\User;
use yii\db\Migration;

class m170925_214000_ref_monitor extends Migration
{
    public function up()
    {
        $this->addColumn('referrers', 'user_id', $this->integer());
        $this->addColumn('referrers', 'rate', $this->string(10)->notNull()->defaultValue('0.3'));

        $user = User::findOne(['username' => 'bestchange']);

        $ref = Referrals::findOne(['id' => 7]);

        $ref->user_id = $user->id;
        $ref->rate = '0.8';
        $ref->save(false);
    }

    public function safeDown()
    {
        echo "m170925_214000_ref_monitor cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170925_214000_ref_monitor cannot be reverted.\n";

        return false;
    }
    */
}
