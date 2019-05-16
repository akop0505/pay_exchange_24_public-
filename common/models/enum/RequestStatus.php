<?php

namespace common\models\enum;


use common\components\Enum;

class RequestStatus extends Enum
{
    const DRAFT                     = 6;
    const NEW_CREATED               = 0;
    const COMPLETE                  = 1;
    const DECLINE                   = 2;
    const INTERNAL_OPERATIONS       = 5;


    public static function getNamesList()
    {
        return [
            self::DRAFT    => 'Draft',
            self::NEW_CREATED    => \Yii::t('app', ''),
            self::COMPLETE    => \Yii::t('app', ''),
            self::DECLINE    => \Yii::t('app', ''),
            self::INTERNAL_OPERATIONS    => \Yii::t('app', ''),
        ];
    }

    public static function getList()
    {
        return [
            self::DRAFT,
            self::NEW_CREATED,
            self::COMPLETE,
            self::DECLINE,
            self::INTERNAL_OPERATIONS,
        ];
    }


}