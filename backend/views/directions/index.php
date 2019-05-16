<?php

use backend\models\directions\DirectionExchangeLimitMin;
use common\models\Directions;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Directions');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="directions-index" data-app-controller="directions_grid">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'action' => Url::toRoute(['save']),
        'options' => ['class' => '']
    ])?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-submit'])?>
    <?= Html::button('Отменить', ['class' => 'btn btn-danger js-refresh'])?>

    <br><br>

    <div class="directions-grid">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'columns' => [
                [
                    'label' => 'Alert',
                    'attribute' => 'bank_alert',
                    'format' => 'raw',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeCheckbox($model, "[$i]bank_alert", ['label' => false]);
                    }
                ],
                [
                    'label' => 'Направление',
                    'attribute' => 'd_from',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var $model Directions */

                        return '<span style="white-space: nowrap">' . $model->d_from . ' -> ' .$model->d_to . '</span>';
                    }
                ],
                [
                    'label' => 'Откуда',
                    'format' => 'raw',
                    'attribute' => 'd_in',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeTextInput($model, "[$i]d_in");
                    }
                ],
                [
                    'label' => 'Куда',
                    'format' => 'raw',
                    'attribute' => 'd_out',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeTextInput($model, "[$i]d_out");
                    }
                ],
                [
                    'label' => 'Лимит мин.',
                    'format' => 'raw',
                    'attribute' => 'limit_min',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeTextInput($model, "[$i]limit_min");
                    }
                ],
                [
                    'label' => 'Лимит макс.',
                    'format' => 'raw',
                    'attribute' => 'limit_max',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeTextInput($model, "[$i]limit_max");
                    }
                ],
                [
                    'label' => 'Мин. сумма для обмена',
                    'format' => 'raw',
                    'attribute' => 'exchange_limit_min',
                    'header' =>
                        '<b>Мин. сумма для обмена</b><br>' .
                        Html::button('Обновить', ['class' => 'btn btn-xs btn-success js-submit-exch-limit-min', 'data-url' => Url::toRoute(['save-exch-limit-min'])]),

                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeTextInput($model, "[$i]exchange_limit_min");
                    }
                ],
                [
                    'label' => 'Макс. сумма для обмена',
                    'format' => 'raw',
                    'attribute' => 'exchange_limit_max',
                    'header' =>

                        '<b>Макс. сумма для обмена</b><br>' .
                        Html::button('Обновить', ['class' => 'btn btn-xs btn-success js-submit-exch-limit-max', 'data-url' => Url::toRoute(['save-exch-limit-max'])]),

                    'value' => function ($model, $id, $i) {
                        /** @var $model Directions */

                        return Html::activeTextInput($model, "[$i]exchange_limit_max");
                    }
                ],
            ],
        ]); ?>

    </div>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-submit'])?>
    <?= Html::button('Отменить', ['class' => 'btn btn-danger js-refresh'])?>


    <?php ActiveForm::end()?>

</div>
