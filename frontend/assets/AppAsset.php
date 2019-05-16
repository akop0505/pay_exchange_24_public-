<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    //public $sourcePath = '@frontend/frontend/build';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css'
    ];
    public $js = [
        'js/main.js?v3',
        'https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\web\JqueryAsset'
    ];
    public $jsOptions = array(
        //'position' => View::POS_HEAD
    );

    public function init()
    {
        parent::init();

        /*foreach ($this->js as & $item) {
            $ts = filemtime(\Yii::getAlias($this->basePath . '/' . $item));

            $item .= '?no=' . $ts;
        }

        foreach ($this->css as & $item) {
            $ts = filemtime(\Yii::getAlias($this->basePath . '/' . $item));

            $item .= '?no=' . $ts;
        }*/
    }
}
