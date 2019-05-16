<?php

namespace common\models;

use common\models\enum\WalletType;
use common\services\WalletsService;
use Yii;

/**
 * This is the model class for table "wallets".
 *
 * @property integer $id
 * @property string $direction
 * @property float $balance
 * @property string $requisite
 * @property boolean $archived
 * @property integer $type
 * @property integer $active
 * @property integer $requisite_full_name
 * @property integer $trans_receive
 * @property integer $trans_available
 * @property integer $trans_sends
 * @property boolean $in_rotation
 */
class Wallets extends \yii\db\ActiveRecord
{
    const SCENARIO_INTERNAL_CHANGES = 'internal_changes';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wallets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction', 'balance'], 'required'],
            [['direction', 'balance'], 'string', 'max' => 45],
            [['balance', 'trans_available', 'trans_receive', 'trans_sends'], 'number'],
            [['requisite', 'requisite_full_name'], 'string', 'max' => 255],
            [['archived', 'active', 'in_rotation'], 'safe'],
            [['type'], 'in', 'range' => WalletType::getList()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'direction' => 'Валюта',
            'balance' => 'Баланс',
            'requisite' => 'Реквизиты',
            'active' => 'Активный',
            'requisite_full_name' => 'ФИО',
            'in_rotation' => 'В ротации',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->active) {
            WalletsService::create()->onActivateWallet($this);
        }
    }

    public function isBTC()
    {
        return $this->direction == 'BTC';
    }

    public function isETH()
    {
        return $this->direction == 'ETH';
    }

    public function isBCH()
    {
        return $this->direction == 'BCH';
    }

    public function isXRP()
    {
        return $this->direction == 'XRP';
    }

    public function isCryptWallet()
    {
        return $this->isBTC() || $this->isETH() || $this->isBCH() || $this->isXRP();
    }

    public function inc($amount)
    {
        $balance = (float) $this->balance;
        $balance += (float) $amount;
        $this->balance = $balance;
        $this->save(false, ['balance']);
    }

    public function dec($amount)
    {
        $balance = (float) $this->balance;
        $balance -= (float) $amount;
        $this->balance = $balance;
        $this->save(false, ['balance']);
    }
}
