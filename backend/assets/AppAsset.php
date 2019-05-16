<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/src/';
    public $baseUrl = '@web';
    public $css = [
        'css/styles.css',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css'
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',

        'js/vendor/can.custom.js',
        'js/vendor/md5.min.js',
        'js/vendor/filter_input.js',
        'js/app.main.js',
        'js/app.common.js',
        'js/app.directions.js',
        'js/app.stats.js',
        'js/app.requests.js',
        'js/app.accounting.js',
        'js/app.reserves.js',
        'js/app.autobalance.js',
        'js/app.config.js',
        'js/app.wallets.js',
        'js/app.referrals.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        /*parent::init();

        foreach ($this->js as & $item) {
            $ts = filemtime(\Yii::getAlias($this->sourcePath . '/' . $item));

            $item .= '?no=' . $ts;
        }

        foreach ($this->css as & $item) {
            $ts = filemtime(\Yii::getAlias($this->sourcePath . '/' . $item));

            $item .= '?no=' . $ts;
        }*/
    }
}
