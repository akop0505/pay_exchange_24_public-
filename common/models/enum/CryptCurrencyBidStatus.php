<?php

namespace common\models\enum;


use common\components\Enum;

class CryptCurrencyBidStatus extends Enum
{
    const WAIT                      = 2;

    const CONFIRMED                 = 3;


    public static function getNamesList()
    {
        return [
            self::WAIT => \Yii::t('app', ''),
            self::CONFIRMED    => \Yii::t('app', ''),
        ];
    }

    public static function getList()
    {
        return [
            self::WAIT,
            self::CONFIRMED,
        ];
    }


}