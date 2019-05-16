<?php

namespace backend\helpers;


use common\models\enum\CryptCurrencyBidStatus;
use common\models\Request;
use common\services\CoinbaseService;
use yii\db\Expression;

class BidHelper
{
    public static function updateCryptCurrencyBidsStatus()
    {
        $models = Request::find()
                        ->andWhere([
                            'OR',
                            ['currency_from' => 'ETH'],
                            ['currency_from' => 'BCH']
                        ])
                        ->andWhere(new Expression("is_confirmed IS NULL OR is_confirmed <> " . CryptCurrencyBidStatus::CONFIRMED))
                        ->andWhere(new Expression("UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at) <= 3600*24*3"))
                        ->all();

        /** @var CoinbaseService $coinbaseSrv */
        $coinbaseSrv = \Yii::$app->coinbase;

        foreach ($models as $model) {

            try {
                $trans = $coinbaseSrv->getLastTransaction($model->requisites, $model->currency_from);

                if ($trans) {

                    $model->is_confirmed = $trans->getStatus() == 'completed' ? CryptCurrencyBidStatus::CONFIRMED : CryptCurrencyBidStatus::WAIT;
                    $model->transaction_amount = $trans->getAmount()->getAmount();
                    $model->save(false);
                }

            } catch (\Exception $e) {
                continue;
            }
        }
    }
}