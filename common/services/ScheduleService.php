<?php

namespace common\services;


use backend\models\Shedule;

class ScheduleService
{
    private static  $_instance = null;


    private final function __construct(){}

    /**
     * @return $this
     */
    public static function create()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getCheckedItem()
    {
        $model = new Shedule();

        $record = $model->getCurrent();

        return $record ? $record->id : 1;
    }
}
