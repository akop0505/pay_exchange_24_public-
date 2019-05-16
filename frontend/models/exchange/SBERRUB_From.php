<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class SBERRUB_From extends ExchangeCurrency
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
            'full_name' => 'ФИО отправителя',
            'card_number' => 'Номер карты отправителя',
        ];
    }

    public function render()
    {
        return

            $this->renderField('full_name', [
                'class' => 'form-control js-required js-fio-alpha-send',
                'placeholder' => 'ФИО, владельца счета, полностью',
            ]) .

            $this->renderField('card_number', [
                'class' => 'form-control js-required js-sber js-number',
                'placeholder' => 'Карта сбербанк, 16-18 цифр',
                'data-maxlength' => 18,
                'maxlength' => 18,
            ]);

    }

    public function map(Bids $bid)
    {
        $bid->send_from = $this->card_number;
        $bid->fio_from = $this->full_name;
    }
}