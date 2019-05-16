<?php

namespace common\services;




use Blockchain\Wallet\Wallet;
use common\models\Currencies;
use common\models\enum\RequestStatus;
use common\models\Request;
use common\models\Wallets;

class WalletsService
{
    private static  $_instance = null;


    private final function __construct(){}

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
     * @param $models Wallets[]
     * @param bool $cryptToRub
     * @return float
     */
    public function getBalance($models, $cryptToRub = true)
    {
        $balance = 0.0;
        foreach ($models as $model) {
            $amount = $model->balance;

            if ($cryptToRub && $model->isCryptWallet()) {
                $amount *= CryptRateService::create()->get($model->direction);
            }

            $balance += $amount;
        }

        return $balance;
    }

    /**
     * @param Wallets $model
     * @return bool
     */
    public function onActivateWallet($model)
    {
        $currency = Currencies::findOne(['send' => $model->direction]);

        if (!$currency || !$model->active) {
            return false;
        }


        foreach (Wallets::find()->andWhere(['<>', 'id', $model->id])->andWhere(['direction' => $model->direction])->all() as $wModel) {
            $wModel->active = false;
            $wModel->save(false);
        }


        /*$model->scenario = Wallets::SCENARIO_INTERNAL_CHANGES;
        $model->active = true;
        $model->save(false);
        $model->scenario = Wallets::SCENARIO_DEFAULT;*/


        $currency->id_wallet = $model->id;
        $currency->save(false);

        return true;
    }

    /**
     * @param $wallet Wallets
     * @param $value 1 or -1
     */
    public function updateReceiveTransactions($wallet, $value)
    {
        $receive = $wallet->trans_receive;
        $value = $value >= 1 ? 1 : -1;
        $receive += $value;
        if ($receive < 0 ) $receive = 0;
        $wallet->trans_receive = $receive;
        $wallet->save(false);
    }

    /**
     * @param $wallet Wallets
     * @param $value 1 or -1
     */
    public function updateSendsTransactions($wallet, $value)
    {
        $sends = $wallet->trans_sends;
        $value = $value >= 1 ? 1 : -1;
        $sends += $value;
        if ($sends < 0 ) $sends = 0;
        $wallet->trans_sends = $sends;
        $wallet->save(false);
    }


    public function updateWalletTransactions($id, $prevStatus = null)
    {
        $model = Request::findOne(['id' => $id]);

        if (!$model) {
            return;
        }

        /** @var Wallets $walletIncome */
        $walletIncome = $model->incomeWallet;
        if ($walletIncome) {

            if ($model->isDraft() || $prevStatus == RequestStatus::DECLINE && $model->isCompleted()) {
                $walletIncome->trans_receive += 1;
            } else if ($model->isDeclined()) {
                $r = $walletIncome->trans_receive;
                $r -= 1;
                if ($r < 0) $r = 0;
                $walletIncome->trans_receive = $r;
            }

            $walletIncome->save(false);
        }

        /** @var Wallets $walletOutcome */
        $walletOutcome = $model->outcomeWallet;
        if ($walletOutcome) {

            if ($model->isCompleted()) {
                $walletOutcome->trans_sends += 1;
            } else if ($model->isDeclined()) {
                $r = $walletOutcome->trans_sends;
                $r -= 1;
                if ($r < 0) $r = 0;
                $walletOutcome->trans_sends = $r;
            }

            $walletOutcome->save(false);

        }

    }

    public function onNewDay()
    {
        Wallets::updateAll(['trans_receive' => 0, /*'trans_available' => 0,*/ 'trans_sends' => 0 ]);
    }
}