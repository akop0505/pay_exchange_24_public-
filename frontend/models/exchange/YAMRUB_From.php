<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class YAMRUB_From extends ExchangeCurrency
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
            'wallet' => 'С кошелька'
        ];
    }

    public function render()
    {
        return $this->renderField('wallet', [
            'class' => 'form-control js-required js-yandex js-number',
            'placeholder' => 'Например: 20201554642992',
            'data-maxlength' => 16,
            'maxlength' => 16,
        ]);
    }

    public function map(Bids $bid)
    {
        $bid->send_from = $this->wallet;
    }
}