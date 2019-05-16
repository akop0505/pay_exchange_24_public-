<?php

namespace backend\modules\bestchange\rates;


use common\models\Directions;

/**
 * Class Rate
 * @package backend\modules\bestchange
 */
class Rate
{
    /**
     * @var Directions
     */
    public $direction;

    /**
     * @var float
     */
    public $rate;

    /**
     * @var float|int
     */
    public $leftValue;

    /**
     * @var float|int
     */
    public $rightValue;


    /**
     * Rate constructor.
     *
     * @param Directions $direction
     * @param $rate
     */
    public function __construct($direction, $rate)
    {
        $this->direction = $direction;
        $this->rate = $rate;
        $this->leftValue = $this->rate < 1 ? 1 : $this->rate;
        $this->rightValue = $this->rate < 1 ? 1 / $this->rate : 1;
    }

    /**
     * @return string
     */
    public function getRateStr()
    {
        return "<span class='rate-str-val'>{$this->leftValue}</span> <span class='rate-str-currency'>{$this->direction->d_from}</span> на <span class='rate-str-val'>{$this->rightValue}</span> <span class='rate-str-currency'>{$this->direction->d_to}</span>";
    }
}