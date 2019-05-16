<?php

namespace common\models\enum;


use common\components\Enum;

class StatisticEvent extends Enum
{
    const VISIT             = 'visit';
    const FORM_BEGIN        = 'form_begin';
    const FORM_SUBMIT     =     'form_submit';
    const FORM_CONFIRM        = 'form_confirm';
    const BID_CREATE        = 'bid_create';
    const BID_COMPLETE        = 'bid_complete';
    const BID_DECLINE        = 'bid_decline';


    public static function getNamesList()
    {
        return [
            self::VISIT => '',
            self::FORM_BEGIN => '',
            self::FORM_SUBMIT => '',
            self::FORM_CONFIRM => '',
        ];
    }

    public static function getList()
    {
        return [
            self::VISIT,
            self::FORM_BEGIN,
            self::FORM_SUBMIT,
            self::FORM_CONFIRM,
            self::BID_CREATE,
            self::BID_COMPLETE,
            self::BID_DECLINE,
        ];
    }


}