<?php

namespace common\services;


use yii\db\Expression;

class StaticWallets
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

    public function getFreeWallet($currency = 'BTC')
    {
        $result = \Yii::$app->db->createCommand('
            SELECT
              sw.id,
              sw.wallet
            FROM static_wallets sw
              LEFT JOIN request r ON r.requisites = sw.wallet AND r.done = 0
            
            WHERE TIMESTAMPDIFF(MINUTE, sw.updated_at, NOW()) > 10  AND r.id IS NULL 
            ORDER BY sw.updated_at ASC 
        ')->queryOne();

        if ($result && count($result) && $result['wallet']) {
            $this->setWorked($result['wallet']);
            return $result['wallet'];
        }

        return '';
    }

    public function setWorked($wallet)
    {
        $model = \common\models\StaticWallets::findOne(['wallet' => $wallet]);
        if ($model) {
            $model->updated_at = new Expression('NOW()');
            $model->save(false);
        }
    }

    public function setFree($wallet)
    {
        $model = \common\models\StaticWallets::findOne(['wallet' => $wallet]);
        if ($model) {
            $model->updated_at = new Expression('DATE_SUB(NOW(), INTERVAL 11 MINUTE)');
            $model->save(false);
        }
    }
}