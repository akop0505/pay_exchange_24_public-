<?php

namespace backend\modules\bestchange\rates;

use backend\modules\bestchange\models\enum\AutobalancePosition;
use backend\modules\bestchange\models\MonitorDirection;
use backend\modules\bestchange\Module;
use yii\base\BaseObject;

/**
 * Class DirectionRatesList
 * @package backend\modules\bestchange
 *
 * @property string $limitAttribute
 * @property mixed $limitValue
 * @property int $totalPositions
 * @property null|string|int $exchangerOffset
 * @property int $targetPosition
 * @property int $exchangerPosition
 * @property int $exchangerPositionStatus
 * @property \backend\modules\bestchange\rates\Rate $exchangerRate
 */
class DirectionRatesList extends BaseObject implements \Iterator
{
    /** @var MonitorDirection */
    private $monitorDirection;

    /** @var Rate[] */
    public $data = [];

    /** @var int */
    private $iteratorPosition;


    /**
     * DirectionList constructor.
     *
     * @param MonitorDirection $direction
     */
    public function __construct(MonitorDirection $direction)
    {
        parent::__construct([]);

        $this->iteratorPosition = 0;
        $this->monitorDirection = $direction;
    }

    /**
     * @param $exchangerId
     * @param Rate $rate
     */
    public function addExchangerRate($exchangerId, Rate $rate)
    {
        $this->data[] = [$exchangerId, $rate];
    }

    /**
     * @return MonitorDirection
     */
    public function getMonitorDirection(): MonitorDirection
    {
        return $this->monitorDirection;
    }

    /**
     * Attribute to change
     *
     * @return string
     */
    protected function getLimitAttribute()
    {
        return $this->monitorDirection->direction->d_in > 1 ? 'limit_max' : 'limit_min';
    }

    /**
     * @return mixed
     */
    public function getLimitValue()
    {
        return $this->monitorDirection->{$this->getLimitAttribute()};
    }

    /**
     * @return int
     */
    public function getTotalPositions()
    {
        return count($this->data);
    }

    /**
     * @return int
     */
    public function getTargetPosition()
    {
        return $this->monitorDirection->target_position;
    }

    /**
     * @return Rate
     */
    public function getExchangerRate()
    {
        $offset = $this->getExchangerOffset();

        return $offset !== null ? $this->data[$offset][1] : null;
    }


    /** Helper methods */


    /**
     * @return bool
     */
    public function isExchangerPresents()
    {
        return $this->getExchangerOffset() !== null;
    }

    /**
     * @return int
     */
    public function getExchangerPosition()
    {
        $offset = $this->getExchangerOffset();

        return $offset !== null ? ++$offset : null;
    }

    /**
     * @return int
     */
    public function getExchangerPositionStatus()
    {
        $currentPosition = $this->getExchangerPosition();
        $targetPosition = $this->getTargetPosition();
        $limitValue = $this->getLimitValue();

        if ($currentPosition <= $targetPosition) {
            return AutobalancePosition::POS_STATUS_SUCCESS;
        }

        $status = AutobalancePosition::POS_STATUS_NOT_ACHIEVE;
        $position = 0;

        /**
         * @var Rate $rate
         */
        foreach ($this->data as $info) {
            $rate = $info[1];

            $position++;

            if ($rate->direction->d_in > 1) {

                $diff = $rate->leftValue - $limitValue;

                // установленный лимит не позволяет соперничать
                if ($diff < 0) {
                    $status = AutobalancePosition::POS_STATUS_NOT_ACHIEVE;
                    continue;
                }

                if ($currentPosition > $position) {
                    $status = AutobalancePosition::POS_STATUS_ON_THE_WAY;
                }

            } else {

                $diff = $rate->rightValue - $limitValue;

                // установленный лимит не позволяет соперничать
                if ($diff > 0) {
                    $status = AutobalancePosition::POS_STATUS_NOT_ACHIEVE;
                    continue;
                }

                if ($currentPosition > $position) {
                    $status = AutobalancePosition::POS_STATUS_ON_THE_WAY;
                }
            }
        }

        return $status;
    }

    /**
     * @return int|null|string
     */
    protected function getExchangerOffset()
    {
        foreach ($this->data as $k => $data) {
            if ($data[0] == Module::getInstance()->selfExchangerId) {
                return $k;
            }
        }

        return null;
    }


    /** Implements Iterator methods */

    public function current()
    {
        return $this->data[$this->iteratorPosition][1];
    }

    public function next()
    {
        return $this->data[++$this->iteratorPosition][1];
    }

    public function key()
    {
        return $this->data[$this->iteratorPosition][0];
    }

    public function valid()
    {
        return isset($this->data[$this->iteratorPosition]);
    }

    public function rewind()
    {
        $this->iteratorPosition = 0;
    }
}










