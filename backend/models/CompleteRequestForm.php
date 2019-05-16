<?php

namespace backend\models;

use common\models\Request;
use Yii;
use yii\base\Model;

class CompleteRequestForm extends Model
{
    const SCENARIO_CRYPT = 'crypt';


    public $wallet_id;

    public $amount;

    public $commission;

    public $txId;

    /** @var Request */
    protected $model;


    public function __construct(Request $model)
    {
        $this->model = $model;

        parent::__construct([]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txId'], 'required', 'on' => self::SCENARIO_CRYPT],

            [['commission'], 'default', 'value' => 0],

            [['wallet_id', 'amount'], 'required'],
            [['commission', 'amount'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'wallet_id' => 'Wallet',
            'txId' => 'Transaction',
        ];
    }

    public function init()
    {
        $this->amount = $this->model->sum_pull;

        if ($this->model->currencyTo->isSBER()) {
            $this->commission = round($this->model->sum_pull / 100, 2);
        }
    }
}
