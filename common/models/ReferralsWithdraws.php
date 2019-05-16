<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "referrals_withdraws".
 *
 * @property integer $id
 * @property integer $referral_id
 * @property string $amount
 * @property string $created_at
 */
class ReferralsWithdraws extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referrals_withdraws';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['referral_id', 'amount'], 'required'],
            [['referral_id'], 'integer'],
            [['created_at'], 'safe'],
            [['amount'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referral_id' => 'Referral ID',
            'amount' => 'Сумма',
            'created_at' => 'Дата',
        ];
    }
}
