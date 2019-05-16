<?php

namespace backend\models\referrals;

use common\models\Income;
use common\models\Referrals;
use common\models\Request;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * Class ReferralStat
 * @package backend\models\referrals
 */
class ReferralStat extends Model
{
    /** @var Referrals */
    protected $model;

    public $requestCount;

    public $exchangesCount;

    public $exchangesSum;

    public $earnings;

    public $availableToWithdraw;

    /**
     * @var bool
     */
    private $userPercent;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestCount', 'exchangesCount', 'exchangesSum', 'earnings', 'availableToWithdraw'], 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'requestCount' => 'Всего заявок',
            'exchangesCount' => 'Всего обменов',
            'exchangesSum' => 'Сумма обменов',
            'earnings' => 'Заработано',
            'availableToWithdraw' => 'Доступно для вывода',
        ];
    }

    /**
     * ReferralStat constructor.
     * @param Referrals $model
     * @param boolean $userPercent
     */
    public function __construct(Referrals $model,$userPercent = false)
    {
        $this->model = $model;
        $this->userPercent = $userPercent;

        parent::__construct([]);

        $this->validate();

        $this->getStat();
    }

    protected function getStat()
    {
        $ref = $this->model;

        $this->requestCount = count($ref->requests);

        $this->exchangesCount = count($ref->doneRequests);

        foreach ($ref->doneRequests as $request) {

            if (!$request->currency_from || (!$request->ref_rate && !$this->userPercent)) {
                continue;
            }

            $requestSum = 0;
            if ($request->currencyFrom->isCrypt() && $request->exchange_price) {
                $requestSum += (float)$request->sum_push * (float)$request->exchange_price;
            } else {
                $requestSum += $request->sum_push;
            }

            $this->exchangesSum += $requestSum;

            if($this->userPercent){
                $withdraw_percent = $this->model->user->withdraw_percent ?: 0;
                $this->earnings += $requestSum * ((float) $withdraw_percent / 100);
            }else{
                $this->earnings += $requestSum * ((float) $request->ref_rate / 100);
            }
        }
        if(!$this->userPercent){
            $this->earnings += $ref->additional;
        }

        // костыль
        $this->exchangesSum += $ref->exchange_amount;

        $this->availableToWithdraw = $this->earnings - $this->model->getWithdrawsSum();
    }
}
