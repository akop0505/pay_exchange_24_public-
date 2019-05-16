<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class SBERRUB_To extends ExchangeCurrency
{
    public $card_number;

    public $full_name;


    public function rules()
    {
        return [
            [['card_number', 'full_name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'card_number' => 'Номер карты получателя',
            'full_name' => 'ФИО получателя',
        ];
    }

    public function render()
    {
        return

            $this->renderField('full_name', [
                'class' => 'form-control js-required js-fio-alpha',
                'placeholder' => 'ФИО получателя полностью',
            ]) .

            $this->renderField('card_number', [
                'class' => 'form-control js-required js-number js-sber',
                'placeholder' => 'Карта сбербанк, 16-18 цифр',
                'data-maxlength' => 18,
                'maxlength' => 18,
            ]);
    }

    public function map(Bids $bid)
    {
        $bid->send_to = $this->card_number;
        $bid->fio_to = $this->full_name;
    }
}