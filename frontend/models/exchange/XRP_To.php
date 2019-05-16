<?php

namespace frontend\models\exchange;



use frontend\models\Bids;

class XRP_To extends ExchangeCurrency
{
    public $wallet;

    public $tag;


    public function rules()
    {
        return [
            [['wallet'], 'required'],
            [['tag'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'wallet' => 'Кошелёк для получения',
            'tag' => 'Destination Tag',
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
            ]) .

            $this->renderField('tag', [
                'class' => 'form-control js-xrp-tag',
                'placeholder' => '',
                'data-maxlength' => 10,
                'maxlength' => 10,
            ]);
    }

    public function map(Bids $bid)
    {
        $bid->send_to = $this->wallet;
        $bid->ripple_tag = $this->tag;
    }
}