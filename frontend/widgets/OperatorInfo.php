<?php

namespace frontend\widgets;


use common\models\Shedule;
use yii\base\Widget;

class OperatorInfo extends Widget
{
    public $from = '10:00';

    public $to = '22:00';


    public function run()
    {
        $date = date('Y-m-d');
        $from = new \DateTime($date . ' ' . $this->from . ':00');
        $to = new \DateTime($date . ' ' . $this->to . ':00');
        $now = new \DateTime();

        $fromDiff = $now->diff($from);// $from->diff($now);
        $toDiff = $now->diff($to);// $to->diff($now);

        $mode  = Shedule::findOne(['enabled' => 1])->mode;



        $isEnable =
            $mode == 'online'
                ? true
                : ($mode == 'offline'
                    ? false
                    : ($fromDiff && !$fromDiff->invert) && ($toDiff && $toDiff->invert));


        return $this->render('operator-info', [
            'isEnable' => $isEnable,
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }
}