<?php

namespace backend\modules\bestchange\rates;


/**
 * Class RatesList
 * @package backend\modules\bestchange
 */
class RatesList implements \Iterator
{
    /**
     * @var DirectionRatesList[]
     */
    public $list = [];

    /**
     * @var int
     */
    private $position = 0;


    public function __construct()
    {
        $this->position = 0;
    }

    public function addRates(DirectionRatesList $list)
    {
        $this->list[] = $list;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->list[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->list[$this->position]);
    }
}