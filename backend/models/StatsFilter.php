<?php

namespace backend\models;

use app\modules\payments\models\MachinePayment;
use app\modules\payments\models\PaymentMethod;
use common\services\CurrenciesService;
use Faker\Provider\cs_CZ\DateTime;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use app\modules\algorithm\models\AlgorithmGroups;

class StatsFilter extends Model
{
    const IN_DAY  = 1;
    const IN_WEEK  = 2;
    const IN_MONTH  = 3;

    public $curFrom;

    public $curTo;

    public $dateFrom;

    public $dateTo;

    public $allDirections = true;

    public $dateInterval = self::IN_MONTH;


    protected $setFromDateInterval = false;





    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateInterval'], 'default', 'value' => 2],

            [['dateFrom'], 'filter', 'filter' => function ($value) {
                $date = \DateTime::createFromFormat('d.m.Y', $value);
                if ($date) {
                    return $date->format('Y-m-d 00:00:00');
                }
                return $value;
            }],

            [['dateTo'], 'filter', 'filter' => function ($value) {
                $date = \DateTime::createFromFormat('d.m.Y', $value);
                if ($date) {
                    return $date->format('Y-m-d 23:59:59');
                }
                return $value;
            }],

            [['curFrom', 'curTo'], 'in', 'range' => ArrayHelper::map(CurrenciesService::create()->getCurrencies(), 'id', 'send')],
            [['curFrom', 'curTo'], 'required', 'when' => function ($model) {
                return !$model->allDirections;
            }],

            [['dateFrom', 'dateTo', 'dateInterval', 'allDirections'], 'safe'],
        ];
    }

    public function init()
    {
        parent::init();

        $this->load(Yii::$app->request->post());
        $this->validate();
        $this->clearErrors();
    }

    public function prepareForView()
    {
        if ($this->setFromDateInterval) {
            $this->dateFrom = null;
            $this->dateTo = null;
        } else {
            $this->dateInterval = null;
        }

        if ($this->allDirections) {
            $this->curFrom = null;
            $this->curTo = null;
        }

        return $this;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $result = parent::validate($attributeNames, $clearErrors);


        if ($this->dateFrom && $this->dateTo) {
            return $result;
        }

        $this->setFromDateInterval = true;

        if ($this->dateInterval == StatsFilter::IN_DAY) {

            $dtTo = new \DateTime();

            $this->dateTo = $dtTo->format('Y-m-d 23:59:59');
            $this->dateFrom = $dtTo->format('Y-m-d 00:00:00');

        } else if ($this->dateInterval == StatsFilter::IN_WEEK) {

            $dtTo = new \DateTime();

            $this->dateTo = $dtTo->format('Y-m-d 23:59:59');
            $this->dateFrom = $dtTo->sub(new \DateInterval('P6D'))->format('Y-m-d 00:00:00');

        } else if ($this->dateInterval == StatsFilter::IN_MONTH) {

            $dtTo = new \DateTime();

            $this->dateTo = $dtTo->format('Y-m-d 23:59:59');
            $this->dateFrom = $dtTo->sub(new \DateInterval('P1M'))->add(new \DateInterval('P1D'))->format('Y-m-d 00:00:00');

        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allDirections' => 'Все направления',
        ];
    }

    /**
     * @param $query ActiveQuery
     * @return ActiveQuery
     */
    public function getQuery($query)
    {


        return $query;
    }
}
