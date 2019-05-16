<?php

namespace common\services;


use backend\models\AccountingFilter;
use backend\models\CompleteRequestForm;
use common\models\enum\RequestStatus;
use common\models\Income;
use common\models\Request;
use yii\db\Expression;


class AccountingService
{
    private static  $_instance = null;


    private final function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function create()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $filter AccountingFilter
     * @return array
     */
    public function getWalletsMoneyFlow($filter)
    {
        $sql = "
            SELECT
              w.id,
              sum(if(w.id = r.currency_from_wallet, abs(r.sum_push), 0)) +
              sum(if(w.id = r.currency_to_wallet, abs(r.sum_pull) + i.comission, 0)) flow
            FROM wallets w
              LEFT JOIN request r ON w.id = r.currency_from_wallet OR w.id = r.currency_to_wallet
              LEFT JOIN income i ON r.id = i.id_request";

        $predicate = ' WHERE i.id IS NOT NULL';
        $values = [];

        if ($filter->dateFrom) {
            $predicate .= " AND r.created_at >= :date_from";
            $values[':date_from'] = $filter->dateFrom;
        }

        if ($filter->dateTo) {
            $predicate .= " AND r.created_at <= :date_to";
            $values[':date_to'] = $filter->dateTo;
        }

        $sql .= $predicate . " GROUP BY w.id";

        $result = \Yii::$app->db->createCommand($sql)->bindValues($values)->queryAll();

        return $result;
    }

    /**
     * @param $filter AccountingFilter
     * @return false|null|string
     */
    public function getTotalProfit($filter)
    {
        $command = \Yii::$app->db->createCommand();

        $sql = "SELECT
                  sum(i.amount) profit
                FROM income i
                  LEFT JOIN request r ON i.id_request = r.id";

        $predicate = ' WHERE 1=1';
        $values = [];

        if ($filter->dateFrom) {
            $predicate .= " AND r.created_at >= :date_from";
            $values[':date_from'] = $filter->dateFrom;
        }

        if ($filter->dateTo) {
            $predicate .= " AND r.created_at <= :date_to";
            $values[':date_to'] = $filter->dateTo;
        }

        return $command->setSql($sql . $predicate)
                        ->bindValues($values)
                        ->queryScalar();
    }
    

    public function declineCompleteRequest(Request $model)
    {
        // update reserves
        $model->reserveByIncome->amount -= $model->sum_push;
        $model->reserveByIncome->save(false);
        $model->reserveByOutcome->amount += $model->sum_pull;
        $model->reserveByOutcome->save(false);

        // increase our outcome wallet
        $model->outcomeWallet && $model->outcomeWallet->inc($model->sum_pull - $model->income->comission);

        // decrease our income wallet
        $model->incomeWallet && $model->incomeWallet->dec($model->sum_push);

        // delete income operation
        $model->income->delete();

        // update due time
        if ($model->done == RequestStatus::NEW_CREATED) {
            $model->processed_at = new Expression('NOW()');
        }

        $prevStatus = $model->done;
        $model->done = RequestStatus::DECLINE;
        $model->save(false);

        $model->onChangeStatus($prevStatus);
    }

    public function declineNewRequest(Request $model)
    {
        // add outcome amount to our reserves
        $model->reserveByOutcome->amount += $model->sum_pull;
        $model->reserveByOutcome->save(false);

        if ($model->income) {
            $model->income->delete();
        }

        // update due time
        if ($model->done == RequestStatus::NEW_CREATED) {
            $model->processed_at = new Expression('NOW()');
        }

        $prevStatus = $model->done;
        $model->done = RequestStatus::DECLINE;
        $model->save(false);

        $model->onChangeStatus($prevStatus);
    }

    public function completeRequest(Request $model, CompleteRequestForm $form)
    {
        if (!in_array($model->done, [RequestStatus::NEW_CREATED, RequestStatus::DECLINE])) {
            return;
        }

        // rotation case: wallet = null
        if (!$model->incomeWallet) {
            return false;
        }

        // vars
        $cryptRates = CryptRateService::create();
        $sumPush = $model->sum_push;
        $sumPull = $model->sum_pull = $form->amount;
        $commission = $form->commission;

        // set wallet
        $model->currency_to_wallet = $form->wallet_id;

        // update due time
        if ($model->done == RequestStatus::NEW_CREATED) {
            $model->processed_at = new Expression('NOW()');
        }

        // update reserves
        $model->reserveByIncome->amount += $model->sum_push;
        $model->reserveByIncome->save(false);

        if ($model->done == RequestStatus::DECLINE) {

            $model->reserveByOutcome->amount -= $model->sum_pull;
            $model->reserveByOutcome->save(false);
        }

        // calculate income sum and create income operation
        $incomeAmount = $sumPush - $sumPull - $commission;

        if ($model->currencyFrom->isCrypt()) {
            $rate = $cryptRates->get($model->currency_from);
            $incomeAmount = ($sumPush * $rate) - $sumPull - $commission;
        }
        if ($model->currencyTo->isCrypt()) {
            $rate = $cryptRates->get($model->currency_to);
            $incomeAmount = $sumPush - ($sumPull * $rate) - ($commission * $rate);
        }
        if ($model->currencyFrom->isCrypt() && $model->currencyTo->isCrypt()) {
            $rateFrom = $cryptRates->get($model->currency_from);
            $rateTo = $cryptRates->get($model->currency_to);
            $incomeAmount = ($sumPush * $rateFrom) - ($sumPull * $rateTo) - ($commission * $rateTo);
        }


        $incomeModel = new Income();
        $incomeModel->id_request = $model->id;
        $incomeModel->id_wallet = $model->incomeWallet->id;
        $incomeModel->amount = $incomeAmount;
        $incomeModel->comission = $commission;
        $incomeModel->save(false);


        // increase our income wallet
        $model->incomeWallet->inc($model->sum_push);

        // decrease our outcome wallet
        $model->outcomeWallet->dec($model->sum_pull);
        $model->outcomeWallet->dec($commission);

        // transaction link
        if ($form->txId) {
            $model->tx_link = $form->txId;
        }

        // set status
        $prevStatus = $model->done;
        $model->done = RequestStatus::COMPLETE;
        $model->save(false);

        $model->onChangeStatus($prevStatus);
    }
    
    /**
     * @param $model Request
     */
    public function recalculatePushPullAmounts($model)
    {
        if ($model->currencyTo->isCrypt()) {

            $pullAmount = round($model->sum_push * $model->direction->d_out / $model->exchange_price_dfrom, 7);

        } else if ($model->currencyFrom->isCrypt()) {

            $pullAmount = round($model->sum_push * $model->exchange_price / $model->direction->d_in, 2);

        } else {

            $pullAmount = round($model->sum_push * $model->direction->d_out / $model->direction->d_in, 2);
        }


        $model->sum_pull = $pullAmount;

        $model->save(false, ['sum_push', 'sum_pull']);
    }
}