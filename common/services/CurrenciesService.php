<?php

namespace common\services;



use common\models\Currencies;
use yii\helpers\ArrayHelper;

class CurrenciesService
{
    private static  $_instance = null;

    protected $curList;



    private final function __construct(){}

    /**
     * @return $this
     */
    public static function create()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $currency
     * @return string
     */
    public function getCurrencyPublicCode($currency)
    {
        $list = ArrayHelper::map($this->getCurrencies(), 'send', 'currency');

        if (isset($list[$currency])) {

            switch ($list[$currency]) {
                case 'руб':
                    return 'RUB';

                default:
                    return $list[$currency];
            }

        }

        return '';
    }

    public function getCurrencies()
    {
        if ($this->curList === null) {
            $this->curList = Currencies::find()->orderBy('send')->all();
        }

        return $this->curList;
    }

    public function getCurrenciesSIDs()
    {
        return array_values(ArrayHelper::map($this->getCurrencies(), 'id', 'send'));
    }

    public function getCurrenciesList()
    {
        return ArrayHelper::map($this->getCurrencies(), 'id', 'send');
    }
    public function getCurrenciesListBySID()
    {
        return ArrayHelper::map($this->getCurrencies(), 'send', 'send');
    }
}