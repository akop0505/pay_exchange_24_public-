<?php

namespace frontend\helpers;


use common\models\enum\CryptCurrencyBidStatus;
use common\models\enum\RequestStatus;
use common\models\Request;


class LKHelper
{
    public static function getStatusClass(Request $model)
    {
        switch ($model->done) {
            case RequestStatus::COMPLETE:
                return 'complete';
            case RequestStatus::DECLINE:
                return 'decline';
            case RequestStatus::NEW_CREATED:
                /*if ($model->currencyFrom->isCrypt() && $model->is_confirmed != CryptCurrencyBidStatus::CONFIRMED) {
                    return 'wait';
                }*/
                return 'in-work';
        }
    }

    public static function getStatusName(Request $model)
    {


        switch ($model->done) {
            case RequestStatus::COMPLETE:
                return 'ВЫПОЛНЕНА';
            case RequestStatus::DECLINE:
                return 'ОТКЛОНЕНА';
            case RequestStatus::NEW_CREATED:
                /*if ($model->currencyFrom->isCrypt() && $model->is_confirmed != CryptCurrencyBidStatus::CONFIRMED) {
                    return 'ОЖИДАЕТ ПОСТУПЛЕНИЯ СРЕДСТВ';
                }*/
                return 'В ОБРАБОТКЕ';
        }
    }

}