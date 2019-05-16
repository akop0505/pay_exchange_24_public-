<?php

namespace common\services;



use common\models\Referrals;

class ReferralsService
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

    /**
     * @return Referrals|false
     */
    public function getCurrentReferral()
    {
        $currRef = \Yii::$app->request->cookies['utm_source'];

        if  (isset(\Yii::$app->request->cookies['utm_source'])) {

            $referral = Referrals::find()->andWhere('referrer = :ref', [':ref' => $currRef])->one();

            if ($referral && $referral->user) {
                return $referral;
            }
        }

        return false;
    }
}
