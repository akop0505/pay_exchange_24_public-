<?php

use yii\db\Migration;

class m170618_034703_add_data_referrers extends Migration
{
    public function up()
    {
        $this->execute("
        INSERT INTO `referrers` (`referrer`) VALUES ('cinfo');
INSERT INTO `referrers` (`referrer`) VALUES ('cmon2');
INSERT INTO `referrers` (`referrer`) VALUES ('cmon3');
INSERT INTO `referrers` (`referrer`) VALUES ('cmon4');
INSERT INTO `referrers` (`referrer`) VALUES ('cmon5');
INSERT INTO `referrers` (`referrer`) VALUES ('cmon6');
INSERT INTO `referrers` (`referrer`) VALUES ('bestchange');
INSERT INTO `referrers` (`referrer`) VALUES ('xrates');
INSERT INTO `referrers` (`referrer`) VALUES ('obmenvse');
INSERT INTO `referrers` (`referrer`) VALUES ('glazok');
INSERT INTO `referrers` (`id`, `referrer`) VALUES ('12', 'cmon12');
INSERT INTO `referrers` (`id`, `referrer`) VALUES ('13', 'cmon13');
INSERT INTO `referrers` (`id`, `referrer`) VALUES ('14', 'cmon14');
INSERT INTO `referrers` (`id`, `referrer`) VALUES ('15', 'cmon15');
INSERT INTO `referrers` (`id`, `referrer`) VALUES ('16', 'cmon16');
        ");
    }

    public function down()
    {
        echo "m170618_034703_add_data_referrers cannot be reverted.\n";

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
