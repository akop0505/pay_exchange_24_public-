<?php

namespace common\models;

use backend\models\referrals\ReferralStat;
use common\models\enum\RequestStatus;
use Yii;

/**
 * This is the model class for table "referrers".
 *
 * @property integer $id
 * @property string $referrer
 * @property double $additional
 * @property double $exchange_amount
 * @property integer $user_id
 * @property float $rate
 *
 * @property User $user
 * @property Request[] $requests
 * @property Request[] $doneRequests
 * @property ReferralsWithdraws[] $withdraws
 */
class Referrals extends \yii\db\ActiveRecord
{
    const DEFAULT_RATE = 0.3;

    protected $stats;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referrers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['additional', 'exchange_amount', 'rate'], 'number'],
            [['user_id'], 'integer'],
            [['referrer'], 'unique'],
            [['referrer'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referrer' => 'Referrer',
            'additional' => 'Additional',
            'exchange_amount' => 'Exchange Amount',
            'user_id' => 'User ID',
        ];
    }

    public function getWithdrawsSum()
    {
        $sum = 0.0;
        foreach ($this->withdraws as $withdraw) {
            $sum += (float) $withdraw->amount;
        }

        return $sum;
    }

    /**
     * @param boolean $userPercent
     * @return ReferralStat
     */
    public function getStats($userPercent = false)
    {
        if ($this->stats === null) {
            $this->stats = new ReferralStat($this,$userPercent);
        }

        return $this->stats;
    }

    /** relations */

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['ref' => 'id']);
    }

    public function getDoneRequests()
    {
        return $this->hasMany(Request::className(), ['ref' => 'id'])->andWhere(['done' => RequestStatus::COMPLETE]);
    }

    public function getWithdraws()
    {
        return $this->hasMany(ReferralsWithdraws::className(), ['referral_id' => 'id']);
    }
}
