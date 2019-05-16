<?php

namespace common\services;



use common\models\enum\StatisticEvent;
use common\models\Statistics;
use frontend\models\stats\Visit;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\View;

class StatisticService
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

    public function checkVisit()
    {
        $visitData = \Yii::$app->session->get('stat_visit', false);
        if ($visitData) {
            \Yii::$app->controller->view->registerJs("StatService.visitData = " . Json::encode($visitData) . ";", View::POS_END);
            \Yii::$app->session->remove('stat_visit');
            return;
        }



        if (\Yii::$app->request->isAjax) {
            return;
        }

        $model = new Visit([
            'utmSrc'    => \Yii::$app->request->get('utm_source'),
            'curFrom'   => \Yii::$app->request->get('cur_from'),
            'curTo'     => \Yii::$app->request->get('cur_to'),
        ]);

        $awayReferrer = strpos(\Yii::$app->request->referrer, \Yii::$app->request->hostName) === false;

        if ($awayReferrer && $model->validate()) {

            \Yii::$app->session->set('stat_visit', $model->attributes);
            \Yii::$app->session->set('stat_visit_permanent', $model->attributes);

            \Yii::$app->controller->redirect(['site/index']);
        }
    }


    public function saveBidCreate()
    {
        $model = new Visit();
        $model->attributes = \Yii::$app->session->get('stat_visit_permanent', false);
        if ($model->validate()) {

            $event = new Statistics([
                'event' => StatisticEvent::BID_CREATE,
                'cur_source' => $model->curFrom,
                'cur_dest' => $model->curTo,
                'data_2' => $model->utmSrc,
            ]);

            return $event->save();
        }
    }

    public function saveVisit(Visit $model)
    {
        $event = new Statistics([
            'event' => StatisticEvent::VISIT,
            'cur_source' => $model->curFrom,
            'cur_dest' => $model->curTo,
            'data_2' => $model->utmSrc,
        ]);

        return $event->save();
    }

    public function saveFormBegin(Visit $model)
    {
        $event = new Statistics([
            'event' => StatisticEvent::FORM_BEGIN,
            'cur_source' => $model->curFrom,
            'cur_dest' => $model->curTo,
            'data_2' => $model->utmSrc,
        ]);

        return $event->save();
    }

    public function saveFormSubmit(Visit $model)
    {
        $event = new Statistics([
            'event' => StatisticEvent::FORM_SUBMIT,
            'cur_source' => $model->curFrom,
            'cur_dest' => $model->curTo,
            'data_2' => $model->utmSrc,
        ]);

        return $event->save();
    }

    public function saveConfirm(Visit $model)
    {
        $event = new Statistics([
            'event' => StatisticEvent::FORM_CONFIRM,
            'cur_source' => $model->curFrom,
            'cur_dest' => $model->curTo,
            'data_2' => $model->utmSrc,
        ]);

        return $event->save();
    }
}