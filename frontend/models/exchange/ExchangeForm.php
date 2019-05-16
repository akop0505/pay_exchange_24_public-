<?php

namespace frontend\models\exchange;


use common\models\Directions;
use yii\base\Model;


class ExchangeForm extends Model
{
    public $amountFrom;

    public $amountTo;

    public $email;

    public $from;

    public $to;


    public function rules()
    {
        return [
            [['amountFrom', 'amountTo', 'email', 'from', 'to'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Ваш E-mail'
        ];
    }
}