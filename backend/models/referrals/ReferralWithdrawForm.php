<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26.09.17
 * Time: 4:54
 */

namespace backend\models\referrals;


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
            [['amount'], 'number'],
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
        $model = new ReferralsWithdraws();
        $model->referral_id = $this->model->id;
        $model->amount = $this->amount;
        $model->save(false);
    }
}