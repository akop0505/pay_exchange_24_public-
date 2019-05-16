<?php

namespace frontend\helpers;


use common\models\enum\BtcWalletsCreateMode;
use common\models\Settings;
use common\services\StaticWallets;

class CryptWalletHelper
{
    /**
     * @return string
     */
    public static function createBTCWallet()
    {
        $mode = Settings::get()->enable_btc_static_wallets;

        switch ($mode) {
            case BtcWalletsCreateMode::STATIC:
                $address = StaticWallets::create()->getFreeWallet();
                break;
            case BtcWalletsCreateMode::COINBASE:
                $address = \Yii::$app->coinbase->createBTCAddress();
                break;
            case BtcWalletsCreateMode::BLOCKCHAIN_INFO:
                $address = \Yii::$app->blockchainInfo->createBTCAddress();
                break;
        }

        \Yii::$app->session->set('__crypt_address', $address);

        return $address;
    }

    /**
     * @return mixed
     */
    public static function createETHWallet()
    {
        $address = \Yii::$app->coinbase->createETHAddress();
        \Yii::$app->session->set('__crypt_address', $address);

        return $address;
    }

    /**
     * @return mixed
     */
    public static function createBCHWallet()
    {
        $address = \Yii::$app->coinbase->createBCHAddress();
        \Yii::$app->session->set('__crypt_address', $address);

        return $address;
    }
}