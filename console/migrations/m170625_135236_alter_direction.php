<?php

use yii\db\Migration;

class m170625_135236_alter_direction extends Migration
{
    public function up()
    {
        $this->execute("INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('ETH', 'SBERRUB', '50000', '1', '1');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('SBERRUB', 'ETH', '1', '50000', '8');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('ETH', 'QWRUB', '40000', '1', '2');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('QWRUB', 'ETH', '1', '40000', '8');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('ETH', 'ACRUB', '30000', '1', '3');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('ACRUB', 'ETH', '1', '30000', '8');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('ETH', 'YAMRUB', '20000', '1', '4');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('YAMRUB', 'ETH', '1', '20000', '8');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('ETH', 'BTC', '1', '1', '7');
INSERT INTO `directions` (`d_from`, `d_to`, `d_in`, `d_out`, `price_id`) VALUES ('BTC', 'ETH', '1', '1', '8');
");
    }

    public function down()
    {
        echo "m170625_135236_alter_direction cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
