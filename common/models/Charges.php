<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "charges".
 *
 * @property integer $id
 * @property integer $request_id
 * @property string $email
 * @property string $amount
 * @property string $currency
 * @property string $date
 */
class Charges extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charges';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id'], 'integer'],
            [['date'], 'safe'],
            [['email', 'amount'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'email' => 'Email',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'date' => 'Date',
        ];
    }
}
