<?php

namespace backend\modules\bestchange\models\enum;


use common\components\Enum;

/**
 * Class AutobalancePosition
 * @package backend\modules\bestchange
 */
class AutobalancePosition extends Enum
{
    const POS_STATUS_SUCCESS        = 1;

    const POS_STATUS_ON_THE_WAY     = 2;

    const POS_STATUS_NOT_ACHIEVE    = 3;


    public static function getNamesList()
    {
        return [
            self::POS_STATUS_SUCCESS => '',
            self::POS_STATUS_ON_THE_WAY => '',
            self::POS_STATUS_NOT_ACHIEVE => '',
        ];
    }

    public static function getList()
    {
        return [
            self::POS_STATUS_SUCCESS,
            self::POS_STATUS_ON_THE_WAY,
            self::POS_STATUS_NOT_ACHIEVE,
        ];
    }

    public static function getGridStatusClass()
    {
        return [
            self::POS_STATUS_SUCCESS => 'bg-success',
            self::POS_STATUS_ON_THE_WAY => 'bg-warning',
            self::POS_STATUS_NOT_ACHIEVE => 'bg-danger',
        ];
    }
}