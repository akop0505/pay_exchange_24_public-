<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class TCSBRUB_From extends ExchangeCurrency
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
                'placeholder' => 'ФИО отправителя полностью',
            ]) .

            $this->renderField('card_number', [
                'class' => 'form-control js-required js-number js-tks',
                'placeholder' => 'Карта тинькофф, 16 цифр',
                'data-maxlength' => 16,
                'maxlength' => 16,
            ]);

    }

    public function map(Bids $bid)
    {
        $bid->send_from = $this->card_number;
        $bid->fio_from = $this->full_name;
    }
}