<?php

namespace common\models\enum;


use common\components\Enum;

class Role extends Enum
{   
    const OPERATOR     = 'operator';
    const ADMIN        = 'admin';
    const MONITOR     = 'monitor';
    const END_USER     = 'end_user';


    public static function getNamesList()
    {
        return [
            self::OPERATOR => \Yii::t('app', 'Operator'),
            self::ADMIN    => \Yii::t('app', 'Admin'),
            self::MONITOR    => \Yii::t('app', 'Monitor'),
            self::END_USER => \Yii::t('app', 'End User'),
        ];
    }

    public static function getList()
    {
        return [
            self::ADMIN,
            self::OPERATOR,
            self::END_USER,
            self::MONITOR,
        ];
    }


}