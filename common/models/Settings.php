<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property integer $enable_auto_btc
 * @property integer $enable_auto_bestchange
 * @property integer $enable_tech_works
 * @property integer $enable_auto_eth
 * @property integer $target
 * @property string $text_tech_works
 * @property integer $enable_bc_autobalance
 * @property string $tech_works_time [varchar(255)]
 * @property integer $enable_new_year
 * @property integer $enable_btc_static_wallets
 * @property integer $wallets_rotation
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enable_btc_static_wallets', 'enable_auto_btc', 'enable_auto_bestchange', 'enable_tech_works', 'enable_auto_eth', 'target', 'enable_bc_autobalance', 'enable_new_year'], 'integer'],
            [['text_tech_works'], 'string', 'max' => 45],
            [['wallets_rotation'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enable_auto_btc' => 'Enable Auto Btc',
            'enable_auto_bestchange' => 'Enable Auto Bestchange',
            'enable_tech_works' => 'Enable Tech Works',
            'enable_auto_eth' => 'Enable Auto Eth',
            'target' => 'Target',
            'enable_bc_autobalance' => 'Enable Bc Autobalance',
            'text_tech_works' => 'Время тех. работ',
            'enable_btc_static_wallets' => 'Статические кошельки Bitcoin',
        ];
    }

    /**
     * @return Settings
     */
    public static function get()
    {
        return self::findOne(['id' => 1]);
    }
}
