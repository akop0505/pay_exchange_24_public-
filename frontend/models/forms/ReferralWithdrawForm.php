<?php

namespace frontend\models\forms;


use common\models\Referrals;
use common\models\ReferralsWithdraws;
use yii\base\Model;

/**
 * Class ReferralWithdrawForm
 * @package backend\models\referrals
 */
class ReferralWithdrawForm extends Model
{
    /** @var Referrals */
    protected $model;


    public $amount;

    /**
     * ReferralWithdrawForm constructor.
     * @param Referrals $model
     */
    public function __construct(Referrals $model)
    {
        $this->model = $model;

        parent::__construct([]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['amount'], 'required'],
            [['amount'], 'number', 'min' => 1],
            [['amount'], 'validateAmount', 'clientValidate' => function ($attribute) {
                $stat = $this->model->getStats();

                return <<<JS
                    if (value > $stat->availableToWithdraw) {
                        messages.push('Сумма превышает доступное для вывода значение');
                    }
JS;
            }],
        ];
    }

    public function validateAmount()
    {
        $stat = $this->model->getStats();

        if ($this->amount > $stat->availableToWithdraw) {
            $this->addError('amount', 'Сумма превышает доступное для вывода значение');
        }
    }

    public function makeWithdraw()
    {
        \Yii::$app
            ->mailer
            ->compose(
                ['html' => 'user-withdraw'],
                ['user' => $this->model->user, 'amount' => $this->amount]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => ' ' . \Yii::$app->name])
            ->setTo(\Yii::$app->params['adminEmail'])
            ->setSubject('Вывод средств: ' . $this->model->user->email)
            ->send();
    }
}