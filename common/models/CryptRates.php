<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "crypt_rates".
 *
 * @property integer $id
 * @property string $currency_sid
 * @property string $rate
 * @property integer $created_at
 * @property integer $updated_at
 */
class CryptRates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crypt_rates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_sid', 'rate'], 'required'],
            [['currency_sid'], 'string', 'max' => 10],
            [['rate'], 'number'],
        ];
    }

    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_sid' => 'Currency Sid',
            'rate' => 'Rate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param $currency
     * @return CryptRates
     */
    public static function get($currency)
    {
        return self::findOne(['currency_sid' => $currency]);
    }
}
