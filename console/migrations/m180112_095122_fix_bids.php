<?php

use backend\models\CompleteRequestForm;
use common\models\Request;
use common\services\AccountingService;
use yii\db\Migration;

class m180112_095122_fix_bids extends Migration
{
    public function safeUp()
    {
        $ids = [13776, 13764, 13762, 13706];

        foreach ($ids as $id) {
            $model = Request::findOne(['id' => $id]);

            if ($model && $model->income) {

                $form = new CompleteRequestForm($model);
                $form->wallet_id = $model->currency_to_wallet;
                $form->amount = $model->sum_pull;
                $form->commission = $model->income->comission;

                $model->setScenario(Request::SCENARIO_INTERNAL_CHANGES);

                AccountingService::create()->declineCompleteRequest($model);
                AccountingService::create()->completeRequest($model, $form);
            }
        }
    }

    public function safeDown()
    {
        echo "m180112_095122_fix_bids cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180112_095122_fix_bids cannot be reverted.\n";

        return false;
    }
    */
}
