<?php

namespace common\components;

use yii\base\Exception;

interface IEnum
{
    public static function getList();

    public static function getNamesList();

    public static function getName($value);
}

class Enum implements IEnum
{
    /**
     * @return array
     * @throws Exception
     */
    public static function getList()
    {
        throw new Exception('No realisation of method');
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getNamesList()
    {
        throw new Exception('No realisation of method');
    }

    public static function getName($value)
    {
        $list = self::getNamesList();
        return isset($list[$value]) ? $list[$value] : '';
    }
}