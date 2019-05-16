<?php

use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

$this->title = Yii::t('app', 'Sms');
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        	['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Имя',
                'attribute' => 'name',
            ],
            [
                'label' => 'Номер',
                'attribute' => 'number',
            ],
            [
                'label' => 'Смс',
                'attribute' => 'body',
            ],
            [
            	'label' => 'Дата',
                'attribute'           => 'createTimeRange',
                'value'               => function ($model, $index, $widget) {
                    return date('Y-m-d h:i:s', strtotime($model->date));
                },
                // 'format'              => 'date',
                'filter'			  => DateRangePicker::widget([
				    'model'=> $searchModel,
				    'attribute'=>'createTimeRange',
				    'convertFormat'=>true,
				    'pluginOptions'=>[
				        'timePicker'=>true,
				        'timePickerIncrement'=>30,
				        'locale'=>[
				            'format'=>'Y-m-d h:i:s'
				        ]
				    ]
				]),
                
            ]

        ],
    ]); 
