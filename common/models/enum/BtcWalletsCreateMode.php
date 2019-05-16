<?php

namespace common\models\enum;


use common\components\Enum;

class BtcWalletsCreateMode extends Enum
{
    const STATIC                = 0;
    const COINBASE              = 1;
    const BLOCKCHAIN_INFO       = 2;


    public static function getNamesList()
    {
        return [
            self::STATIC => 'Статичные',
            self::COINBASE => 'Coinbase',
            self::BLOCKCHAIN_INFO => 'BlockchainInfo',
        ];
    }

    public static function getList()
    {
        return [
            self::STATIC,
            self::COINBASE,
            self::BLOCKCHAIN_INFO,
        ];
    }


}