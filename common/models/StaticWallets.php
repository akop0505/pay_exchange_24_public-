<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "static_wallets".
 *
 * @property int $id
 * @property string $currency
 * @property string $wallet
 * @property string $updated_at
 * @property string $created_at
 */
class StaticWallets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_wallets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wallet'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
            [['currency'], 'string', 'max' => 10],
            [['wallet'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency' => 'Currency',
            'wallet' => 'Wallet',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
