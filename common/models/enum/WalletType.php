<?php

namespace common\models\enum;


use common\components\Enum;

class WalletType extends Enum
{
    const CURRENCY               = 1;

    const CUSTOM                 = 2;


    public static function getNamesList()
    {
        return [
            self::CURRENCY => 'Валютный',
            self::CUSTOM    => 'Произвольный',
        ];
    }

    public static function getList()
    {
        return [
            self::CURRENCY,
            self::CUSTOM,
        ];
    }


}