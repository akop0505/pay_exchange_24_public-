<?php

namespace backend\modules\bestchange\services;


use backend\modules\bestchange\Module;
use backend\modules\bestchange\rates\DirectionRatesList;
use backend\modules\bestchange\rates\Rate;
use backend\modules\bestchange\parsers\RatesParserInterface;

/**
 * Class Autobalancer
 * @package backend\modules\bestchange
 */
class Autobalancer
{
    /** @var RatesParserInterface */
    private $ratesProvider;


    public function __construct(RatesParserInterface $ratesProvider)
    {
        $this->ratesProvider = $ratesProvider;
    }

    /**
     * Perform balance directions rates
     */
    public function balance()
    {
        $lists = $this->ratesProvider->getRates();

        foreach ($lists as $list) {

            //if ($list->getMonitorDirection()->direction_id !== 24) continue; // qiwi -> btc
            //if ($list->getMonitorDirection()->direction_id !== 23) continue; // btc -> qiwi

            $this->processList($list);
        }
    }

    /**
     * @param $list DirectionRatesList
     * @return bool|void
     */
    protected function processList($list)
    {
        $targetPosition = $list->targetPosition;
        $currentPosition = $list->exchangerPosition;
        $limitValue = $list->limitValue;
        $selfExchangerId = Module::getInstance()->selfExchangerId;

        if ($limitValue <= 0) {
            return;
        }

        /*$tmp = [];
        foreach ($list->data as $i => $info) {
            //$tmp[$info[0] . '-' . ($i+1)] = $info[1]->leftValue;
            $tmp[$info[0] . '-' . ($i+1)] = $info[1]->rightValue;
        }
        dbg($tmp);*/


        /**
         * @var Rate $rate
         */
        foreach ($list->data as $position => $info) {

            $exchangeId = $info[0];
            $rate = $info[1];

            $position++;

            $direction = $rate->direction;

            if ($exchangeId == $selfExchangerId) {
                continue;
            }

            // для котировок в левом столбце
            if ($direction->d_in > 1) {

                // установленный лимит позволяет соперничать || валюта с шагом 1 руб
                $diff = $rate->leftValue - $limitValue;
                if ($diff < 0 || ($diff < 1 && !$direction->currencyFrom->isCrypt())) {
                    continue;
                }


                // достигли или превысили целевую позицию
                if ($targetPosition <= $position || $currentPosition > $position) {

                    if (!$direction->currencyFrom->isCrypt()) {
                        $direction->d_in = $rate->leftValue - 1; // 1 RUB
                    } else {
                        $direction->d_in = $rate->leftValue - $this->getMicroValue($rate->leftValue);
                    }

                    /*dbg([
                        $direction->d_in,
                        [
                            $info[0],
                            $info[1]->rate,
                        ]
                    ]);*/

                    return $direction->save(false);
                }

            // для котировок в правом столбце
            } else {


                // установленный лимит позволяет соперничать || валюта с шагом 1 руб
                $diff = $rate->rightValue - $limitValue;
                if ($diff > 0 || ($diff > -1 && $diff < 0 && !$direction->currencyTo->isCrypt())) {
                    continue;
                }

                // достигли или превысили целевую позицию
                if ($targetPosition <= $position || $currentPosition > $position) {

                    if (!$direction->currencyTo->isCrypt()) {
                        $direction->d_out = $rate->rightValue + 1; // 1 RUB
                    } else {
                        $direction->d_out = $rate->rightValue + $this->getMicroValue($rate->rightValue);
                    }

                    /*dbg([
                        $direction->d_out,
                        [
                            $info[0],
                            $info[1]->rightValue,
                        ]
                    ]);*/

                    return $direction->save(false);
                }

            }
        }
    }

    /**
     * @param $value
     * @return float|int
     */
    private function getMicroValue($value)
    {
        $value = (string) $value;
        $dotPos = strpos($value, '.');

        if ($dotPos === false) {

            return 1; // 1 rub

        } else {

            $afterDotValue = strlen(substr($value, $dotPos+1));

            return floatval('0.' . str_repeat('0', $afterDotValue-1) . '1');
        }
    }
}