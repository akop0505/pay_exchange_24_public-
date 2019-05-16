<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class BTC_To extends ExchangeCurrency
{
    public $wallet;


    public function rules()
    {
        return [
            [['wallet'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'wallet' => 'Кошелёк для получения'
        ];
    }

    public function render()
    {
        return $this->renderField('wallet', [
            'class' => 'form-control js-required js-btc',
            'placeholder' => 'Пример: 20vhaYuCDpaPXkmi12WZMK',
            'data-maxlength' => 40,
            'maxlength' => 40,
        ]);
    }

    public function map(Bids $bid)
    {
        $bid->send_to = $this->wallet;
    }
}