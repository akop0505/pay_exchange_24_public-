<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class CASHRUB_From extends ExchangeCurrency
{
    public $city;

    public $phone;

    public $name;


    public function rules()
    {
        return [
            [['city', 'phone', 'name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city' => 'Ваш город',
            'phone' => 'Номер телефона',
            'name' => 'ФИО',
        ];
    }

    public function render()
    {
        return

            $this->renderField('city', [
                'class' => 'form-control js-required js-city',
                'placeholder' => 'Москва',
            ]) .

            $this->renderField('phone', [
                'class' => 'form-control js-required js-phone',
                'placeholder' => '+79139139911',
            ]) .

            $this->renderField('name', [
                'class' => 'form-control js-required js-fio-alpha-send',
                'placeholder' => 'ФИО, полностью',
            ]);

    }

    public function map(Bids $bid)
    {
        $bid->attr_city = $this->city;
        $bid->attr_phone = $this->phone;
        $bid->attr_name = $this->name;
    }
}