<?php

namespace frontend\helpers;


use common\models\Request;

class BidHelper
{
    /**
     * @param Request $bid
     * @return string
     */
    public static function getViewRate($bid)
    {
        return ($bid->currencyFrom->isCrypt() ? $bid->exchange_price_dfrom : round($bid->exchange_price_dfrom, 2)) . " " . $bid->currencyFrom->view_code . " = " . $bid->exchange_price . " " . $bid->currencyTo->view_code;
    }
}