<?php

namespace common\services;



use backend\models\StatsFilter;
use common\models\Directions;
use common\models\Request;
use yii\db\Expression;
use yii\db\Query;

class StatDataService
{
    private static $_instance = null;


    private final function __construct()
    {
    }

    public static function create()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $filter StatsFilter
     * @return array
     */
    public function getResult($filter)
    {
        $result = [];

        $filter = clone $filter;

        if (!$filter->allDirections) {
            $result[] = array_merge(['direction' => $filter->curFrom . '-' . $filter->curTo], $this->getData($filter));
        } else {

            $models = Directions::find()->all();
            foreach ($models as $model) {
                $filter->curFrom = $model->d_from;
                $filter->curTo = $model->d_to;

                $result[] = array_merge(['direction' => $filter->curFrom . '-' . $filter->curTo], $this->getData($filter));
            }

        }

        return $result;
    }

    protected function getData($filter)
    {
        $result = $this->getStats($filter);
        $result['c1'] = $this->getResultC1($filter);
        $result['c2'] = $this->getResultC2($filter);
        $result['c3'] = $this->getResultC3($filter);
        $result['c4'] = $this->getResultC4($filter);
        $result['c5'] = $this->getResultC5($filter);

        return $result;
    }

    protected function getStats($filter)
    {

        $sql = "
            SELECT
              sum(if(event = 'visit', 1, 0)) visit,
              sum(if(event = 'form_begin', 1, 0)) begin,
              sum(if(event = 'form_submit', 1, 0)) submit,
              sum(if(event = 'form_confirm', 1, 0)) confirm
            FROM exg_statistics
            
            WHERE cur_source = '{$filter->curFrom}' AND 
                  cur_dest = '{$filter->curTo}' AND 
                  created_at BETWEEN UNIX_TIMESTAMP('{$filter->dateFrom}') AND UNIX_TIMESTAMP('{$filter->dateTo}')
            
            GROUP BY cur_source, cur_dest;";


        $result = (new Query())->createCommand()->setSql($sql)->queryOne();
        if (!$result) {
            $result = [
                'visit' => 0,
                'begin' => 0,
                'submit' => 0,
                'confirm' => 0,
            ];
        }

        return $result;
    }

    /**
     * Create bid
     *
     * @param $filter StatsFilter
     * @return string
     */
    public function getResultC1($filter)
    {
        $command = (new Query())->createCommand();

        $sql = "
            SELECT
              sum(if(event = 'visit', 1, 0)) all_v,
              sum(if(event = 'bid_create', 1, 0)) bid
            from exg_statistics
            where 
              (event = 'bid_create' OR event = 'visit') AND  
              cur_source = '{$filter->curFrom}' AND cur_dest = '{$filter->curTo}' AND
              created_at BETWEEN UNIX_TIMESTAMP('{$filter->dateFrom}') AND UNIX_TIMESTAMP('{$filter->dateTo}')";

        $result = $command->setSql($sql)->queryOne();

        if ($result && $result['all_v'] > 0) {
            return $result['bid'] / $result['all_v'];
        }

        return 0;
    }

    /**
     * Create bid
     *
     * @param $filter StatsFilter
     * @return string
     */
    public function _getResultC1($filter)
    {
        $command = (new Query())->createCommand();

        $sql = "
            SELECT
              count(*) cnt_all,
              sum(if(currency_from = '@from' AND currency_to = '@to', 1, 0)) direction
            from request
              WHERE 
              created_at BETWEEN '{$filter->dateFrom}' AND '{$filter->dateTo}'";

        $sql = str_replace(['@from', '@to'], [$filter->curFrom, $filter->curTo], $sql);

        $result = $command->setSql($sql)->queryOne();
        if ($result) {
            return $result['cnt_all'] > 0 ? round($result['direction'] / $result['cnt_all'], 3) : 0;
        }

        return 0;
    }

    /**
     * Complete bid
     *
     * @param $filter StatsFilter
     * @return string
     */
    public function getResultC2($filter)
    {
        $command = (new Query())->createCommand();

        $sql = "
            SELECT
              count(*) cnt_all,
              sum(if(done = 1, 1, 0)) deriction
            from request
              WHERE 
              currency_from = '@from' AND currency_to = '@to' AND 
              created_at BETWEEN '{$filter->dateFrom}' AND '{$filter->dateTo}'";

        $sql = str_replace(['@from', '@to'], [$filter->curFrom, $filter->curTo], $sql);

        $result = $command->setSql($sql)->queryOne();
        if ($result) {
            return $result['cnt_all'] > 0 ? round($result['deriction'] / $result['cnt_all'], 3) : 0;
        }

        return 0;
    }

    /**
     * Decline bid
     *
     * @param $filter StatsFilter
     * @return string
     */
    public function getResultC3($filter)
    {
        $command = (new Query())->createCommand();

        $sql = "
            SELECT
              count(*) cnt_all,
              sum(if(done > 1, 1, 0)) deriction
            from request
              WHERE 
              currency_from = '@from' AND currency_to = '@to' AND 
              created_at BETWEEN '{$filter->dateFrom}' AND '{$filter->dateTo}'";

        $sql = str_replace(['@from', '@to'], [$filter->curFrom, $filter->curTo], $sql);

        $result = $command->setSql($sql)->queryOne();
        if ($result) {
            return $result['cnt_all'] > 0 ? round($result['deriction'] / $result['cnt_all'], 3) : 0;
        }

        return 0;
    }

    /**
     * Average bill
     *
     * @param $filter StatsFilter
     * @return string
     */
    public static function getResultC4($filter)
    {
        $models = Request::find()
                        ->andWhere(['done' => 1])
                        ->andWhere(['currency_from' => $filter->curFrom])
                        ->andWhere(['currency_to' => $filter->curTo])
                        ->andWhere(new Expression("created_at BETWEEN '{$filter->dateFrom}' AND '{$filter->dateTo}'"))->all();

        $sum = 0;

        /**
         * @var $model Request
         */
        foreach ($models as $model) {



            if ($model->currency_from == 'BTC' || $model->currency_from == 'ETH') {

                $rateSrv = CryptRateService::create();

                $sum += (float) $model->sum_push * ($model->currency_from == 'BTC' ? $rateSrv->getBTC() : $rateSrv->getETH());

            } else {
                $sum += (float) $model->sum_push;
            }

        }

        if (count($models) == 0) {
            return 0;
        }

        return round($sum/count($models), 2);
    }

    /**
     * Average income
     *
     * @param $filter StatsFilter
     * @return string
     */
    public static function getResultC5($filter)
    {
        $models = Request::find()
            ->with('income')
            ->andWhere(['currency_from' => $filter->curFrom])
            ->andWhere(['currency_to' => $filter->curTo])
            ->andWhere(new Expression("created_at BETWEEN '{$filter->dateFrom}' AND '{$filter->dateTo}'"))->all();

        if (count($models) == 0) {
            return 0;
        }

        $cnt = 0;
        $sum = 0.0;

        /** @var Request $model */
        foreach ($models as $model) {
            if (!$model->income) {
                continue;
            }

            $cnt++;

            $sum += (float) $model->income->amount;
        }

        return $cnt > 0 ? round($sum/$cnt, 2) : 0.0;
    }
}