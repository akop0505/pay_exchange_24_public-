<?php

namespace common\models;

use backend\models\directions\DirectionExchangeLimitMin;
use backend\modules\bestchange\models\MonitorBestchange;
use Yii;

/**
 * This is the model class for table "directions".
 *
 * @property integer $id
 * @property string $d_from
 * @property string $d_to
 * @property double $d_in
 * @property double $d_out
 * @property double $limit_min
 * @property double $limit_max
 * @property string $description
 * @property integer $price_id
 * @property integer $target
 * @property double $exchange_limit_min
 * @property double $exchange_limit_max
 * @property boolean $bank_alert
 *
 * @property Currencies $currencyFrom
 * @property Currencies $currencyTo
 * @property Reserves $reserve
 * @property MonitorBestchange $bestchangeDirection
 */
class Directions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'directions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['d_in', 'd_out', 'limit_min', 'limit_max', 'exchange_limit_min', 'exchange_limit_max'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '.', $value);
            }],
            [['d_in', 'd_out', 'limit_min', 'limit_max', 'exchange_limit_min', 'exchange_limit_max'], 'number'],
            [['description'], 'string'],
            [['price_id', 'target', 'bank_alert'], 'integer'],
            [['d_from', 'd_to'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'd_from' => 'D From',
            'd_to' => 'D To',
            'd_in' => 'D In',
            'd_out' => 'D Out',
            'limit_min' => 'Limit Min',
            'limit_max' => 'Limit Max',
            'description' => 'Description',
            'price_id' => 'Price ID',
            'target' => 'Target',
            'bank_alert' => 'Bank Alert',
        ];
    }

    public function getExchangeLimitMinModel()
    {
        return new DirectionExchangeLimitMin([
            'model' => $this,
            'limit' => $this->exchange_limit_min,
        ]);
    }




    /** relations */

    public function getCurrencyFrom()
    {
        return $this->hasOne(Currencies::className(), ['send' => 'd_from']);
    }

    public function getCurrencyTo()
    {
        return $this->hasOne(Currencies::className(), ['send' => 'd_to']);
    }

    public function getReserve()
    {
        return $this->hasOne(Reserves::className(), ['id' => 'price_id']);
    }

    public function getBestchangeDirection()
    {
        return $this->hasOne(MonitorBestchange::className(), ['direction_id' => 'id']);
    }
}
