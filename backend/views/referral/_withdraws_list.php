<?php

use common\models\Referrals;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model Referrals */

?>
<div class="withdraws-list">

    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getWithdraws(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['id' => 'DESC']
            ]
        ]),

        'layout' => '{items}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'amount',
                'format' => ['decimal', 2]
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y H:i']
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete-withdraw}',
                'buttons' => [
                    'delete-withdraw' => function ($url, $modelWD, $key) use ($model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete-withdraw', 'id' => $modelWD->id, 'referralId' => $model->id]), [
                            'data-method' => 'post',
                            'title' => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить запись?',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'delete-withdraw' => Yii::$app->user->can('admin'),
                ]
            ],
        ],
    ]);
    Pjax::end();
    ?>

</div>
