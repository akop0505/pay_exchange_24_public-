<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $id
 * @property string $currency
 * @property string $send
 * @property string $pay_link
 * @property string $pay_text
 * @property string $id_wallet
 * @property string $first_step_text
 * @property string $view_code
 * @property string $view_name
 *
 * @property Wallets $wallet
 * @property Wallets[] $allAvailableWallets
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['send'], 'required'],
            [['id_wallet'], 'integer'],
            [['currency', 'send', 'pay_link', 'pay_text', 'view_code', 'view_name'], 'string', 'max' => 255],
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
            'send' => 'Send',
            'pay_link' => 'Pay Link',
            'pay_text' => 'Pay Text',
        ];
    }

    public function isCrypt()
    {
        return $this->isBTC() || $this->isETH() || $this->isBCH() || $this->isXRP();
    }

    public function isBTC()
    {
        return $this->send == 'BTC';
    }

    public function isETH()
    {
        return $this->send == 'ETH';
    }

    public function isBCH()
    {
        return $this->send == 'BCH';
    }

    public function isXRP()
    {
        return $this->send == 'XRP';
    }

    public function isQIWI()
    {
        return $this->send == 'QWRUB';
    }

    public function isYA()
    {
        return $this->send == 'YAMRUB';
    }

    public function isSBER()
    {
        return $this->send == 'SBERRUB';
    }

    public function isBank()
    {
        return !$this->isCrypt() && !$this->isQIWI() && !$this->isYA();
    }



    public function getWallet()
    {
        return $this->hasOne(Wallets::className(), ['id' => 'id_wallet']);
    }

    public function getAllAvailableWallets()
    {
        return $this->hasMany(Wallets::className(), ['direction' => 'send']);
    }
}
