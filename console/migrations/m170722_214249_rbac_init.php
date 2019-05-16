<?php

use common\models\enum\Role;
use common\models\User;
use yii\db\Migration;

class m170722_214249_rbac_init extends Migration
{
    public function safeUp()
    {
        $this->addColumn(User::tableName(), 'role', $this->string(10)->notNull()->defaultValue(Role::END_USER));

        $migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
        $migration->runAction('up', ['migrationPath' => '@yii/rbac/migrations', 'interactive' => false]);



        $auth = Yii::$app->authManager;

        $role = $auth->createRole(Role::ADMIN);
        $auth->add($role);

        $role = $auth->createRole(Role::END_USER);
        $auth->add($role);

        $model = new User();
        $model->email = 'admin@example.com';
        $model->username = 'godblessedthissite';
        $model->password = '1XQzCq@kzNY?P}AN6#hl*';
        $model->role = Role::ADMIN;
        $model->save();
    }

    public function safeDown()
    {
        echo "m170722_214249_rbac_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170722_214249_rbac_init cannot be reverted.\n";

        return false;
    }
    */
}
