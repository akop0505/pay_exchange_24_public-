<?php

use common\models\Currencies;
use common\models\enum\WalletType;
use common\models\Wallets;
use common\services\CurrenciesService;
use yii\db\Migration;

class m170922_231523_wallets extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Wallets::tableName(), 'archived', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn(Wallets::tableName(), 'type', $this->smallInteger());

        $curList = CurrenciesService::create()->getCurrenciesSIDs();

        $models = Wallets::find()->all();

        foreach ($models as $model) {
            $model->type = in_array($model->direction, $curList) ? WalletType::CURRENCY : WalletType::CUSTOM;
            $model->save(false);
        }
    }

    public function safeDown()
    {
        echo "m170922_231523_wallets cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170922_231523_wallets cannot be reverted.\n";

        return false;
    }
    */
}
