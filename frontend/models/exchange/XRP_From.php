<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class XRP_From extends ExchangeCurrency
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
            'wallet' => 'Со счета Ripple',
        ];
    }

    public function render()
    {
        return

            $this->renderField('wallet', [
                'class' => 'form-control js-required js-xrp',
                'placeholder' => 'Пример: r9xHq2NqyU3PRuCat64GSgFYxx95vV1ct9',
                'data-maxlength' => 34,
                'maxlength' => 34,
            ]);
    }

    public function map(Bids $bid)
    {
        $bid->send_from = $this->wallet;
    }
}