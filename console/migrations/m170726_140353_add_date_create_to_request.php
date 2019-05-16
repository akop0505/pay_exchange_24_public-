<?php

use common\models\Request;
use yii\db\Migration;

class m170726_140353_add_date_create_to_request extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'created_at', $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP');


        $models = Request::find()->all();
        foreach ($models as $model) {
            if (!$model->date_start) {
                continue;
            }

            $date = DateTime::createFromFormat('d.m.Y H:i:s', $model->date_start);
            if ($date) {
                $model->created_at = $date->format('Y-m-d H:i:s');
                $model->save(false);
            }
        }
    }

    public function safeDown()
    {
        echo "m170726_140353_add_date_create_to_request cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170726_140353_add_date_create_to_request cannot be reverted.\n";

        return false;
    }
    */
}
