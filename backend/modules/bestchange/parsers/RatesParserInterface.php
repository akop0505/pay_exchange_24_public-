<?php

namespace backend\modules\bestchange\parsers;


use backend\modules\bestchange\rates\RatesList;

interface RatesParserInterface
{
    /**
     * @return RatesList
     */
    public function getRates() : RatesList;
}