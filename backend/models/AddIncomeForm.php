<?php

namespace backend\models;

use common\models\enum\RequestStatus;
use common\models\Income;
use common\models\Request;
use common\services\WalletsService;
use Yii;
use yii\base\Model;

class AddIncomeForm extends Model
{
    public $comment;

    public $walletFromId;

    public $walletToId;

    public $amountFrom;

    public $amountTo;

    public $date;

    public $ignoreRotation;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'filter', 'filter' => function ($value) {
                $date = \DateTime::createFromFormat('d.m.Y', $value);
                if ($date) {
                    return $date->format('Y-m-d H:i:s');
                }
                return $value;
            }],

            [['comment', 'date'], 'required'],

            [['walletFromId'], 'required', 'when' => function ($model) {
                return !$model->walletToId;
            }],
            [['walletToId'], 'required', 'when' => function ($model) {
                return !$model->walletFromId;
            }],

            [['amountFrom'], 'required', 'when' => function ($model) {
                return $model->walletFromId > 0;
            }],
            [['amountTo'], 'required', 'when' => function ($model) {
                return $model->walletToId > 0;
            }],

            [['walletFromId', 'walletToId'], 'integer'],
            [['amountFrom', 'amountTo'], 'number'],
            [['ignoreRotation'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
            'walletFromId' => 'С какого кошелка',
            'walletToId' => 'На какой кошелек',
            'amountFrom' => 'Сумма',
            'amountTo' => 'Сумма',
            'date' => 'Дата',
            'ignoreRotation' => 'Не учитывать в ротации',
        ];
    }

    public function init()
    {
        parent::init();

        $this->date = date('Y-m-d');
    }

    public function addIncome()
    {
        $request = new Request();
        $request->email = $this->comment;
        $request->currency_from_wallet = $this->walletToId;
        $request->currency_to_wallet = $this->walletFromId;
        $request->sum_pull = $this->amountFrom;
        $request->sum_push = $this->amountTo;
        $request->created_at = $this->date;
        $request->done = RequestStatus::INTERNAL_OPERATIONS;

        if ($request->save(false)) {

            if ($request->incomeWallet && $request->sum_push) {
                $request->incomeWallet->inc($request->sum_push);

                if (!$this->ignoreRotation && $request->incomeWallet->in_rotation) {
                    WalletsService::create()->updateReceiveTransactions($request->incomeWallet, 1);
                }
            }

            if ($request->outcomeWallet && $request->sum_pull) {
                $request->outcomeWallet->dec($request->sum_pull);

                if (!$this->ignoreRotation && $request->outcomeWallet->in_rotation) {
                    WalletsService::create()->updateSendsTransactions($request->outcomeWallet, 1);
                }
            }

            $income = new Income();
            $income->id_request = $request->id;
            $income->id_wallet = $request->incomeWallet ? $request->incomeWallet->id : $request->outcomeWallet->id;
            $income->save(false);

        }
    }
}
