<?php

namespace backend\models\requests;


use common\models\Request;
use yii\base\Model;


class SendETHForm extends Model
{
    public $address;

    public $amount;

    public $commission;

    /** @var Request */
    protected $model;


    public function __construct(Request $model)
    {
        $this->model = $model;

        $this->address = $model->send_to;

        $this->amount = $model->sum_pull;

        $this->commission = 0.0001;

        parent::__construct([]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commission'], 'default', 'value' => 0.0001],

            [['amount', 'address'], 'required'],
            [['commission', 'amount'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'amount' => 'Сумма',
            'commission' => 'Комиссия сети',
        ];
    }
}