<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class BTC_From extends ExchangeCurrency
{

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function render()
    {
        return '';
    }

    public function map(Bids $bid)
    {
    }
}