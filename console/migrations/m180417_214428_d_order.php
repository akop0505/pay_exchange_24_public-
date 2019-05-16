<?php

use common\models\Reserves;
use function foo\func;
use frontend\models\Bids;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

class m180417_214428_d_order extends Migration
{
    public function safeUp()
    {
        $this->addColumn(Reserves::tableName(), 'sort_order', $this->integer()->defaultValue(500));

        $order = [
            'BTC',
            'BCH',
            'ETH',
            'XRP',
            'QWRUB',
            'YAMRUB',
            'SBERRUB',
            'VTB24',
            'ACRUB',
            'TCSBRUB',
            'CASHRUB',
        ];

        $r = ArrayHelper::map(Reserves::find()->all(), 'currency', function($m){return $m;});

        foreach ($order as $i => $code) {

            /** @var Reserves $model */
            $model = $r[$code];
            $model->sort_order = ++$i + ($i * 10);

            if (!$model->save()) {
                dbg($model->errors);
            }

        }
    }

    public function safeDown()
    {
        echo "m180417_214428_d_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180417_214428_d_order cannot be reverted.\n";

        return false;
    }
    */
}
