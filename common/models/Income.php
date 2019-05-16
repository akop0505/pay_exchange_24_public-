<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income".
 *
 * @property integer $id
 * @property integer $id_wallet
 * @property integer $id_request
 * @property string $amount
 * @property float $comission
 *
 * @property Request $idRequest
 * @property Request $request
 */
class Income extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_wallet', 'id_request'], 'integer'],
            [['amount', 'comission'], 'string', 'max' => 255],
            [['id_request'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['id_request' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_wallet' => 'Id Wallet',
            'id_request' => 'Id Request',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'id_request'])->inverseOf('incomes');
    }

    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'id_request']);
    }
}
