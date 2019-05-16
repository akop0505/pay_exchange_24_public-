<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property integer $id
 * @property float $amount
 * @property string $currency
 * @property string $description
 * @property boolean $enable
 * @property int $sort_order
 *
 * @property Currencies $currencyModel
 */
class Reserves extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['description'], 'string'],
            [['currency'], 'string', 'max' => 255],
            [['enable'], 'boolean'],
            [['sort_order'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'description' => 'Description',
            'sort_order' => 'Sort',
        ];
    }

    public function getCurrencyModel()
    {
        return $this->hasOne(Currencies::class, ['send' => 'currency']);
    }

    public function getFormatAmount()
    {
        switch ($this->currency) {
            case 'BTC':
            case 'ETH':
            case 'BCH':
            case 'XRP':
                $amount = round($this->amount, 8);
                if (fmod($amount, 1) == 0) {
                    $amount .= '.00';
                }
                break;

            default:
                $amount = number_format(round($this->amount, 0), 0, '.', '');
        }

        return $amount;
    }
}
