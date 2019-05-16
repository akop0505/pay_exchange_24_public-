<?php

use yii\helpers\Html;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use common\models\enum\Role;

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
<?= Html::a( "Добавить", "create") ?>
</div>

<div id="user-grid">
<?php
$data = Role::getList();
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'responsive'=>true,
        'hover'=>true,
        'export' => false,
        'options' => ['style'=>'padding: 20px;'],
        'columns' => [
            [
                'class' => 'kartik\grid\EditableColumn',
                'label' => 'Comment',
                'attribute' => 'comment',
                'vAlign' => GridView::ALIGN_TOP,
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'placement' => PopoverX::ALIGN_RIGHT_BOTTOM,
                        'header' => '&nbsp;',
                        'size' => 'md',
                    ];
                }
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'role',
                'vAlign' => GridView::ALIGN_TOP,
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'options'=>['id'=>$model->id],
                        'placement' => PopoverX::ALIGN_LEFT_BOTTOM,
                        'data' => array_combine(Role::getList(), Role::getList()),
                        'header' => '&nbsp;',
                        'size' => 'md',
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    ];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
            	'template' => '{delete}' ,
            	'buttons' => [
                	'myButton' => function($url, $model, $key) {     
	                    return Html::a('<span class="fa fa-search"></span>Delete', "delete", 
                        [ 
					        'title' => Yii::t('app', 'delete'),
					        'class' =>'btn btn-primary btn-xs', 
					   ]) ;
                	}
            	]
            ]

        ]
]);
?>
</div>
