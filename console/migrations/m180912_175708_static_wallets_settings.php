<?php

use common\models\Settings;
use yii\db\Migration;

/**
 * Class m180912_175708_static_wallets_settings
 */
class m180912_175708_static_wallets_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Settings::tableName(), 'enable_btc_static_wallets', $this->boolean()->notNull()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180912_175708_static_wallets_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180912_175708_static_wallets_settings cannot be reverted.\n";

        return false;
    }
    */
}
