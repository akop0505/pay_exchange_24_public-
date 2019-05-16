<?php


use common\models\Referrals;
use yii\widgets\DetailView;


/* @var $model Referrals */

$attributes = [];

$usePercent = true;

if(!isset($page) || $page !== "room"){
    $usePercent = false;
    $attributes[] = 'requestCount';
}

$attributes += [
    'exchangesCount',
    [
        'attribute' => 'exchangesSum',
        'format' => ['decimal', 2]
    ],
    [
        'attribute' => 'earnings',
        'format' => ['decimal', 2]
    ],
    [
        'attribute' => 'availableToWithdraw',
        'format' => ['decimal', 2]
    ],
];

echo DetailView::widget([
    'model' => $model->getStats($usePercent),
    'attributes' => $attributes
]);