<?php

use yii\db\Migration;

class m170906_191926_monitor_fill extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('monitor_bc_to_directions_ref', 'monitor_bestchange');

        $this->execute("
        INSERT INTO `monitor_bestchange` (`direction_id`, `limit_min`, `limit_max`, `current_position`, `target_position`, `total_positions`, `monitor_from_id`, `monitor_to_id`, `monitor_direction_url`, `updated_at`, `id`) VALUES
(1, '0', '0', NULL, 1, 0, 63, 42, 'qiwi-to-sberbank.html', NULL, 1),
(2, '0', '0', NULL, 1, 0, 42, 63, 'sberbank-to-qiwi.html', NULL, 2),
(3, '0', '0', NULL, 1, 0, 63, 52, 'qiwi-to-alfaclick.html', NULL, 3),
(4, '0', '0', NULL, 1, 0, 52, 63, 'alfaclick-to-qiwi.html', NULL, 4),
(5, '0', '0', NULL, 1, 0, 42, 52, 'sberbank-to-alfaclick.html', NULL, 5),
(6, '0', '0', NULL, 1, 0, 52, 42, 'alfaclick-to-sberbank.html', NULL, 6),
(7, '0', '0', NULL, 1, 0, 42, 6, 'sberbank-to-yandex-money.html', NULL, 7),
(8, '0', '0', NULL, 1, 0, 52, 6, 'alfaclick-to-yandex-money.html', NULL, 8),
(9, '0', '0', NULL, 1, 0, 63, 6, 'qiwi-to-yandex-money.html', NULL, 9),
(22, '0', '0', NULL, 1, 0, 42, 93, 'sberbank-to-bitcoin.html', NULL, 10),
(23, '0', '0', NULL, 1, 0, 93, 63, 'bitcoin-to-qiwi.html', NULL, 11),
(24, '0', '0', NULL, 1, 0, 63, 93, 'qiwi-to-bitcoin.html', NULL, 12),
(25, '0', '0', NULL, 1, 0, 93, 52, 'bitcoin-to-alfaclick.html', NULL, 13),
(26, '0', '0', NULL, 1, 0, 52, 93, 'alfaclick-to-bitcoin.html', NULL, 14),
(30, '0', '0', NULL, 1, 0, 93, 6, 'bitcoin-to-yandex-money.html', NULL, 15),
(31, '0', '0', NULL, 1, 0, 93, 42, 'bitcoin-to-sberbank.html', NULL, 16),
(32, '0', '0', NULL, 1, 0, 139, 42, 'ethereum-to-sberbank.html', NULL, 17),
(33, '0', '0', NULL, 1, 0, 42, 139, 'sberbank-to-ethereum.html', NULL, 18),
(34, '0', '0', NULL, 1, 0, 139, 63, 'ethereum-to-qiwi.html', NULL, 19),
(35, '0', '0', NULL, 1, 0, 63, 139, 'qiwi-to-ethereum.html', NULL, 20),
(36, '0', '0', NULL, 1, 0, 139, 52, 'ethereum-to-alfaclick.html', NULL, 21),
(37, '0', '0', NULL, 1, 0, 52, 139, 'alfaclick-to-ethereum.html', NULL, 22),
(38, '0', '0', NULL, 1, 0, 139, 6, 'ethereum-to-yandex-money.html', NULL, 23),
(40, '0', '0', NULL, 1, 0, 139, 93, 'ethereum-to-bitcoin.html', NULL, 24),
(41, '0', '0', NULL, 1, 0, 93, 139, 'bitcoin-to-ethereum.html', NULL, 25),
(10, '0', '0', NULL, 1, NULL, 6, 42, NULL, NULL, 26),
(11, '0', '0', NULL, 1, NULL, 6, 52, NULL, NULL, 27),
(12, '0', '0', NULL, 1, NULL, 6, 63, NULL, NULL, 28),
(28, '0', '0', NULL, 1, NULL, 6, 93, NULL, NULL, 29),
(39, '0', '0', NULL, 1, NULL, 6, 139, NULL, NULL, 30);
        ");
    }

    public function safeDown()
    {
        echo "m170906_191926_monitor_fill cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170906_191926_monitor_fill cannot be reverted.\n";

        return false;
    }
    */
}
