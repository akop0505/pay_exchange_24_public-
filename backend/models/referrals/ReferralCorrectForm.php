<?php

namespace backend\models\referrals;


use common\models\Referrals;
use common\models\ReferralsWithdraws;
use yii\base\Model;

/**
 * Class ReferralCorrectForm
 * @package backend\models\referrals
 */
class ReferralCorrectForm extends Model
{
    /** @var Referrals */
    protected $model;


    public $additional;

    public $exchange_amount;


    /**
     * ReferralWithdrawForm constructor.
     * @param Referrals $model
     */
    public function __construct(Referrals $model)
    {
        $this->model = $model;

        parent::__construct([]);

        $this->additional = $this->model->additional;
        $this->exchange_amount = $this->model->exchange_amount;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['exchange_amount', 'additional'], 'number'],
        ];
    }

    public function makeCorrect()
    {
        $this->model->additional = $this->additional;
        $this->model->exchange_amount = $this->exchange_amount;
        $this->model->save(false);
    }
}