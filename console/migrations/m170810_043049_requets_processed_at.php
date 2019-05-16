<?php

use common\models\Request;
use yii\db\Migration;

class m170810_043049_requets_processed_at extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Request::tableName(), 'processed_at', $this->dateTime());


        /** @var Request[] $models */
        $models = Request::find()->all();
        foreach ($models as $model) {
            if (!$model->date_update || !$model->created_at) {
                continue;
            }

            if (preg_match('#(\d+\syears)?\s*(\d+\smonths)?\s*(\d+\sdays)?\s*(\d+\shours)?\s*(\d+\sminutes)?\s*(\d+\sseconds)?#is', $model->date_update, $matches)) {

                unset($matches[0]);

                $interval = DateInterval::createFromDateString(trim(join(' + ', $matches), " +"));

                $dt = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
                $dt->add($interval);

                $model->processed_at = $dt->format('Y-m-d H:i:s');

                $model->save(false);
            }
        }
    }

    public function safeDown()
    {
        echo "m170810_043049_requets_processed_at cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170810_043049_requets_processed_at cannot be reverted.\n";

        return false;
    }
    */
}
