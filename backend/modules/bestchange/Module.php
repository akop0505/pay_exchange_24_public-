<?php

namespace backend\modules\bestchange;


use backend\modules\bestchange\parsers\ApiRatesParser;
use backend\modules\bestchange\services\Autobalancer;

/**
 * bestchange module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\bestchange\controllers';

    /** @var int */
    public $selfExchangerId;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $container = \Yii::$container;

        $container->set('autobalancer', Autobalancer::class);

        $container->set('backend\modules\bestchange\parsers\RatesParserInterface', [
            'class' => ApiRatesParser::class
        ]);
    }
}
