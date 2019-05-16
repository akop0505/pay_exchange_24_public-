<?php

use common\models\CryptRates;
use yii\db\Migration;

class m180112_084938_tbl_rates extends Migration
{
    public function safeUp()
    {
        $this->createTable('crypt_rates', [
            'id' => $this->primaryKey(),
            'currency_sid' => $this->string(10)->notNull(),
            'rate' => $this->string(30)->notNull()->defaultValue('0.0'),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        (new CryptRates([
            'currency_sid' => 'BTC',
            'rate' => 782476.14445,
        ]))->save(false);

        (new CryptRates([
            'currency_sid' => 'ETH',
            'rate' => 68855.27649,
        ]))->save(false);

        (new CryptRates([
            'currency_sid' => 'BCH',
            'rate' => 142449.422115,
        ]))->save(false);
    }

    public function safeDown()
    {
        echo "m180112_084938_tbl_rates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180112_084938_tbl_rates cannot be reverted.\n";

        return false;
    }
    */
}
