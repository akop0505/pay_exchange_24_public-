<?php

namespace frontend\models;

use common\models\Currencies;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $currency_to
 * @property string $currency_from
 * @property string $sum_push
 * @property string $sum_pull
 * @property string $send_to
 * @property string $send_from
 * @property string $requisites
 * @property integer $done
 * @property string $email
 * @property integer $ref
 * @property string $date_update
 * @property string $fio_from
 * @property string $fio_to
 * @property string $exchange_price_dfrom
 * @property string $exchange_price
 * @property integer $is_confirmed
 * @property string $transaction_amount
 * @property integer $currency_from_wallet
 * @property integer $currency_to_wallet
 * @property string $description
 * @property string $created_at
 * @property string $processed_at
 * @property integer $blockchain_confirmations
 * @property string $blockchain_value
 * @property integer $btc_send_success
 * @property string $tx_link
 * @property string $ripple_tag
 * @property string $attr_city
 * @property string $attr_phone
 * @property string $attr_name
 * @property string $ref_rate
 * @property string $hash_id
 *
 * @property Currencies $currencyFrom
 * @property Currencies $currencyTo
 */
class Bids extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'done', 'ref', 'is_confirmed', 'currency_from_wallet', 'currency_to_wallet', 'blockchain_confirmations', 'btc_send_success'], 'integer'],
            [['email', 'tx_link', 'hash_id'], 'string'],
            [['created_at', 'processed_at', 'ref_rate'], 'safe'],
            [['currency_to', 'currency_from', 'sum_push', 'sum_pull', 'send_to', 'send_from', 'requisites', 'date_update', 'fio_from', 'fio_to', 'transaction_amount', 'description', 'attr_city'], 'string', 'max' => 255],
            [['exchange_price_dfrom', 'exchange_price'], 'string', 'max' => 45],
            [['blockchain_value', 'ripple_tag', 'attr_phone'], 'string', 'max' => 20],
            [['attr_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'currency_to' => 'Currency To',
            'currency_from' => 'Currency From',
            'sum_push' => 'Sum Push',
            'sum_pull' => 'Sum Pull',
            'send_to' => 'Send To',
            'send_from' => 'Send From',
            'requisites' => 'Requisites',
            'done' => 'Done',
            'email' => 'Email',
            'ref' => 'Ref',
            'date_update' => 'Date Update',
            'fio_from' => 'Fio From',
            'fio_to' => 'Fio To',
            'exchange_price_dfrom' => 'Exchange Price Dfrom',
            'exchange_price' => 'Exchange Price',
            'is_confirmed' => 'Is Confirmed',
            'transaction_amount' => 'Transaction Amount',
            'currency_from_wallet' => 'Currency From Wallet',
            'currency_to_wallet' => 'Currency To Wallet',
            'description' => 'Description',
            'created_at' => 'Created At',
            'processed_at' => 'Processed At',
            'blockchain_confirmations' => 'Blockchain Confirmations',
            'blockchain_value' => 'Blockchain Value',
            'btc_send_success' => 'Btc Send Success',
            'tx_link' => 'Tx Link',
            'ripple_tag' => 'Ripple Tag',
            'attr_city' => 'Attr City',
            'attr_phone' => 'Attr Phone',
            'attr_name' => 'Attr Name',
        ];
    }

    public function getCurrencyFrom()
    {
        return $this->hasOne(Currencies::className(), ['send' => 'currency_from']);
    }

    public function getCurrencyTo()
    {
        return $this->hasOne(Currencies::className(), ['send' => 'currency_to']);
    }
}
