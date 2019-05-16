<?php

use common\models\Settings;
use yii\db\Migration;

/**
 * Class m190125_120349_config_rotation
 */
class m190125_120349_config_rotation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Settings::tableName(), 'wallets_rotation', $this->boolean()->notNull()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190125_120349_config_rotation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190125_120349_config_rotation cannot be reverted.\n";

        return false;
    }
    */
}
