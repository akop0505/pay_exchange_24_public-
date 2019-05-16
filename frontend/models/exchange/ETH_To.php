<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class ETH_To extends ExchangeCurrency
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
            'class' => 'form-control js-required js-eth',
            'placeholder' => 'Пример: 0xF9E982E6096673a99407B382Dca04Cd12e0e0000',
            'data-maxlength' => 42,
            'maxlength' => 42,
        ]);
    }

    public function map(Bids $bid)
    {
        $bid->send_to = $this->wallet;
    }
}