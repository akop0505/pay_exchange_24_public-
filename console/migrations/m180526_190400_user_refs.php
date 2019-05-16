<?php

use common\models\enum\Role;
use common\models\Referrals;
use common\models\User;
use frontend\models\Bids;
use yii\db\Migration;

/**
 * Class m180526_190400_user_refs
 */
class m180526_190400_user_refs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('ref_ref', Referrals::tableName(), 'referrer', true);
        $this->addColumn(Bids::tableName(), 'ref_rate', $this->string());


        $models = User::findAll(['role' => Role::END_USER]);

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
        echo "m180526_190400_user_refs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180526_190400_user_refs cannot be reverted.\n";

        return false;
    }
    */
}
