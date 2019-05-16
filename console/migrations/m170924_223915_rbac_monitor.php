<?php

use common\models\enum\Role;
use common\models\User;
use yii\db\Migration;

class m170924_223915_rbac_monitor extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $role = $auth->createRole(Role::MONITOR);
        $auth->add($role);

        $auth->addChild($auth->getRole(Role::ADMIN), $role);


        $monitors = [
            ['bestchange','WEfCAScV','bestchange'],
            ['monitor8','a8&Xbc)9xut#%P9','XRATES'],
            ['monitor3','%F1Qv4Gq','monitor3'],
            ['monitor2','ac%LkMZJ','info@kurs.expert'],
            ['monitor5','TMrUiU$J','bestexchangers'],
            ['monitor4','Ba$Pdm02','Kurses.com.ua'],
            ['monitor','Ae#QsT{5mWOH','Changeinfo'],
        ];

        foreach ($monitors as $monitor) {
            $model = new User();
            $model->role = Role::MONITOR;
            $model->username = $monitor[0];
            $model->email = $monitor[0];
            $model->password = $monitor[1];
            $model->comment = $monitor[2];
            $model->save();
        }

    }

    public function safeDown()
    {
        echo "m170924_223915_rbac_monitor cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170924_223915_rbac_monitor cannot be reverted.\n";

        return false;
    }
    */
}
