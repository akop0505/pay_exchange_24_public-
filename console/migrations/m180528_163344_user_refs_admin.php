<?php

use common\models\enum\Role;
use common\models\Referrals;
use common\models\User;
use yii\db\Migration;

/**
 * Class m180528_163344_user_refs_admin
 */
class m180528_163344_user_refs_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $models = User::findAll(['role' => Role::ADMIN]);

        foreach ($models as $user) {
            $model = new Referrals();
            $model->user_id = $user->id;
            $model->rate = Referrals::DEFAULT_RATE;
            $model->referrer = $user->generateRefLink();

            if (!$model->save()) {
                dbg($model->errors);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180528_163344_user_refs_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180528_163344_user_refs_admin cannot be reverted.\n";

        return false;
    }
    */
}
