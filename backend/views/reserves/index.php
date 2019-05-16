<?php

use common\models\Directions;
use common\models\Reserves;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reserves');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="reserves-index" data-app-controller="reserves_grid">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'action' => Url::toRoute(['save']),
        'options' => ['class' => '']
    ])?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-submit'])?>
    <?= Html::button('Отменить', ['class' => 'btn btn-danger js-refresh'])?>

    <br><br>

    <div class="reserves-grid">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'columns' => [
                [
                    'label' => 'Валюта',
                    'value' => function ($model) {
                        /** @var $model Reserves */

                        return $model->description . " ({$model->currency})";
                    }
                ],
                [
                    'label' => 'Количество',
                    'format' => 'raw',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Reserves */

                        return Html::activeTextInput($model, "[$i]amount");
                    }
                ],
                [
                    'label' => 'Включена',
                    'format' => 'raw',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Reserves */

                        return Html::activeCheckbox($model, "[$i]enable", ['label' => false]);
                    }
                ],
            ],
        ]); ?>

    </div>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-submit'])?>
    <?= Html::button('Отменить', ['class' => 'btn btn-danger js-refresh'])?>


    <?php ActiveForm::end()?>

</div>
