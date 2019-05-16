<?php

namespace common\models;

use common\models\enum\RequestStatus;
use common\services\WalletsService;
use Yii;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property string $email
 * @property float $sum_push
 * @property float $sum_pull
 * @property integer $currency_to_wallet
 * @property integer $currency_from_wallet
 * @property integer $ref
 * @property integer $done
 * @property integer $exchange_price
 * @property integer $exchange_price_dfrom
 * @property integer $is_confirmed
 * @property string $transaction_amount
 * @property string $date_update
 * @property string $send_from
 * @property string $send_to
 * @property string $currency_to
 * @property string $requisites
 * @property string $currency_from
 * @property string $fio_from
 * @property string $fio_to
 * @property string $description
 * @property integer $blockchain_confirmations
 * @property float $blockchain_value
 * @property boolean $btc_send_success
 * @property string $created_at
 * @property string $processed_at
 * @property string $tx_link
 * @property string $ripple_tag
 * @property string $attr_city
 * @property string $attr_phone
 * @property string $attr_name
 * @property string $ref_rate
 *
 * @property Income $income
 * @property Currencies $currencyFrom
 * @property Currencies $currencyTo
 * @property Directions $direction
 * @property Wallets[] $wallets
 * @property Wallets $incomeWallet
 * @property Wallets $outcomeWallet
 * @property Reserves $reserveByIncome
 * @property Reserves $reserveByOutcome
 */
class Request extends \yii\db\ActiveRecord
{
    const SCENARIO_INTERNAL_CHANGES = 'internal_changes';


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
            [['sum_push'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '.', $value);
            }],

            [['ref', 'done', 'currency_to_wallet', 'currency_from_wallet', 'blockchain_confirmations'], 'integer'],
            [['email', 'created_at', 'processed_at', 'performed_at', 'description'], 'string'],
            [['sum_push', 'sum_pull', 'date_update', 'send_from', 'send_to', 'currency_to', 'requisites', 'currency_from', 'fio_from', 'fio_to'], 'string', 'max' => 255],
            [['exchange_price', 'exchange_price_dfrom', 'tx_link', 'ripple_tag', 'attr_city', 'attr_phone', 'attr_name', 'ref_rate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'Count',
            'fio' => 'Fio',
            'email' => 'Email',
            'sum_push' => 'Сумма прихода',
            'sum_pull' => 'Сумма отправки',
            'ref' => 'Ref',
            'done' => 'Done',
            'date_update' => 'Date Update',
            'send_from' => 'Send From',
            'send_to' => 'Send To',
            'currency_to' => 'Currency To',
            'requisites' => 'Requisites',
            'currency_from' => 'Currency From',
            'fio_from' => 'Fio From',
            'fio_to' => 'Fio To',
            'created_at' => 'Дата создания',
            'description' => 'Комментрий',
        ];
    }

    public function isNewCreated()
    {
        return $this->done == RequestStatus::NEW_CREATED;
    }

    public function isCompleted()
    {
        return $this->done == RequestStatus::COMPLETE;
    }

    public function isDeclined()
    {
        return $this->done == RequestStatus::DECLINE;
    }

    public function isDraft()
    {
        return $this->done == RequestStatus::DRAFT;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (isset($changedAttributes['done']) && $this->scenario != self::SCENARIO_INTERNAL_CHANGES) {

            if ($this->done == RequestStatus::COMPLETE) {

                Yii::$app->mailer->compose('requests/complete', ['model' => $this])
                    ->setFrom(\Yii::$app->params['supportEmail'])
                    ->setTo($this->email)
                    ->setSubject('Ваша заявка № '. $this->id .' выполнена. ' . Yii::$app->name)
                    ->send();

            } else if ($this->done == RequestStatus::DECLINE) {

                Yii::$app->mailer->compose('requests/decline', ['model' => $this])
                    ->setFrom(\Yii::$app->params['supportEmail'])
                    ->setTo($this->email)
                    ->setSubject('Ваша заявка № '. $this->id .' отклонена. ' . Yii::$app->name)
                    ->send();

            }

        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function onChangeStatus($prevStatus = null)
    {
        if ($this->direction->currencyFrom->isCrypt()) {
            \common\services\StaticWallets::create()->setFree($this->requisites);
        }

        // wallet transactions stats
        WalletsService::create()->updateWalletTransactions($this->id);
    }

    public function getWorkTimeStr()
    {
        $processedAt = $this->processed_at;
        $performedAt = $this->created_at;

        if (!$processedAt) {
            $processedAt = gmdate('Y-m-d H:i:s');
        }

        if (!$this->created_at) {
            return '';
        }

        if ($this->performed_at) {
            $performedAt = $this->performed_at;
        }

        $dtCreate = \DateTime::createFromFormat('Y-m-d H:i:s', $performedAt);
        $dtProc = \DateTime::createFromFormat('Y-m-d H:i:s', $processedAt);

        $interval = $dtProc->diff($dtCreate);

        return
            trim(($interval->y > 0 ? $interval->y . ' years' : '') . ' ' .
                ($interval->m > 0 ? $interval->m . ' months' : '') . ' ' .
                ($interval->d > 0 ? $interval->d . ' days' : '') . ' ' .
                ($interval->h > 0 ? $interval->h . ' hours' : '') . ' ' .
                ($interval->i > 0 ? $interval->i . ' minutes' : '') . ' ' .
                ($interval->s > 0 ? $interval->s . ' seconds' : ''));
    }


    /** relations */

    public function getIncomeWallet()
    {
        return $this->hasOne(Wallets::className(), ['id' => 'currency_from_wallet']);
    }

    public function getOutcomeWallet()
    {
        return $this->hasOne(Wallets::className(), ['id' => 'currency_to_wallet']);
    }

    public function getReserveByIncome()
    {
        return $this->hasOne(Reserves::className(), ['currency' => 'currency_from']);
    }

    public function getReserveByOutcome()
    {
        return $this->hasOne(Reserves::className(), ['currency' => 'currency_to']);
    }

    public function getIncome()
    {
        return $this->hasOne(Income::className(), ['id_request' => 'id']);
    }

    public function getCurrencyFrom()
    {
        return $this->hasOne(Currencies::className(), ['send' => 'currency_from']);
    }

    public function getCurrencyTo()
    {
        return $this->hasOne(Currencies::className(), ['send' => 'currency_to']);
    }

    public function getDirection()
    {
        return $this->hasOne(Directions::className(), ['d_from' => 'currency_from', 'd_to' => 'currency_to']);
    }

    public function getWallets()
    {
        return $this->hasMany(Wallets::className(), ['direction' => 'currency_to'])
            ->andWhere(['archived' => false]);
    }
}




