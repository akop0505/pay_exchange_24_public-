<?php

use common\models\Currencies;
use common\models\Wallets;
use yii\db\Migration;

class m180205_235716_active_wallet extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Wallets::tableName(), 'active', $this->boolean()->notNull()->defaultValue(false));

        /** @var Currencies[] $cModels */
        $cModels = Currencies::find()->all();

        foreach ($cModels as $cModel) {
            $wallet = Wallets::findOne(['id' => $cModel->id_wallet]);
            if ($wallet) {
                $wallet->active = true;
                $wallet->save(false);
            }
        }
    }

    public function safeDown()
    {
        echo "m180205_235716_active_wallet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180205_235716_active_wallet cannot be reverted.\n";

        return false;
    }
    */
}
