<?php

use common\models\Currencies;
use common\models\Wallets;
use yii\db\Migration;

class m180208_023841_wallet_cr extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Wallets::tableName(), 'requisite_full_name', $this->string());

        $this->db->schema->refreshTableSchema(Wallets::tableName());

        /** @var Currencies[] $cModels */
        $cModels = Currencies::find()->all();

        try {

            foreach ($cModels as $model) {

                $wallet = $model->wallet;

                if ($wallet) {

                    $wallet->scenario = Wallets::SCENARIO_INTERNAL_CHANGES;

                    $wallet->requisite_full_name = $model->pay_fio;

                    if (!$wallet->save(false)) {
                        dbg($wallet);
                    }


                }
            }

        } catch (Exception $e) {
            dbg($e);
        }

        $this->dropColumn(Currencies::tableName(), 'pay_number');
        $this->dropColumn(Currencies::tableName(), 'pay_fio');
    }

    public function safeDown()
    {
        echo "m180208_023841_wallet_cr cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180208_023841_wallet_cr cannot be reverted.\n";

        return false;
    }
    */
}
