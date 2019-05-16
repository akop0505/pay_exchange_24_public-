<?php

use backend\modules\bestchange\models\MonitorDirection;
use backend\modules\bestchange\rates\RatesList;
use common\models\Settings;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $ratesList RatesList */

$this->title = 'Autobalance Bestchange';
$this->params['breadcrumbs'][] = $this->title;

$enabled = Settings::get()->enable_bc_autobalance;
?>

<div class="autobalance-index">

    <div class="autobalance-grid"
         data-app-controller="autobalance_grid"
         data-refresh-url="<?= Url::toRoute(['update-data'])?>"
         data-enable-url="<?= Url::toRoute(['enable'])?>"
         data-ajax-url="<?= Url::toRoute(['ajax'])?>"
    >


        <!--<div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary <?/*= $enabled ? 'active' : ''*/?>">
                <input type="radio" name="enable" value="1" class="js-enable-btn" <?/*= $enabled ? 'checked="checked"' : ''*/?>> Автобаланировка вкл.
            </label>
            <label class="btn btn-primary <?/*= !$enabled ? 'active' : ''*/?>">
                <input type="radio" name="enable" value="0" class="js-enable-btn" <?/*= !$enabled ? 'checked="checked"' : ''*/?>> Автобаланировка выкл.
            </label>
        </div>

        <br>
        <br>-->


        <div class="clearfix">

            <div class="pull-left">
                <?= Html::button('Обновить данные с Bestchange', [
                    'class' => 'btn btn-primary js-refresh',
                    'data-loading-text' => 'Обновляются данные с Bestchange',
                ]) ?>
            </div>

            <div class="btn-group pull-right" data-toggle="buttons">

                <label class="btn btn-primary active">
                    <input type="radio" name="enable" value="1" class="js-enable-ab-btn js-enable-ajax" checked="checked" /> Вкл. ajax
                </label>
                <label class="btn btn-primary">
                    <input type="radio" name="enable" value="0" class="js-enable-ab-btn js-disable-ajax"/> Выкл. ajax
                </label>

            </div>
        </div>



        <br><br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-condensed'],
            'rowOptions' => function ($model) {
                return ['data-direction-id' => $model->direction_id];
            },
            'columns' => [
                [
                    'label' => 'Направление',
                    'value' => function ($model) {
                        /** @var $model MonitorDirection */

                        return $model->direction->d_from . ' -> ' .$model->direction->d_to;
                    }
                ],

                [
                    'label' => 'Курс (max)',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var $model MonitorDirection */

                        return Yii::$app->controller->view->render('_edit_widget', ['model' => $model, 'attribute' => 'limit_max']);
                    }
                ],

                [
                    'label' => 'Курс текущий (monitor)',
                    'format' => 'raw',
                    'contentOptions' => function () {
                        return ['class' => 'js-monitor-course'];
                    },
                    'value' => function ($model) use ($ratesList) {
                        /** @var $model MonitorDirection */

                        $mList = false;
                        foreach ($ratesList as $list) {
                            if ($list->getMonitorDirection()->id == $model->id) {
                                $mList = $list;
                                break;
                            }
                        }

                        return  !empty($mList->exchangerRate) ? $mList->exchangerRate->getRateStr() : '';
                    }
                ],

                [
                    'label' => 'Курс (min)',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var $model MonitorDirection */

                        return Yii::$app->controller->view->render('_edit_widget', ['model' => $model, 'attribute' => 'limit_min']);
                    }
                ],

                [
                    'label' => 'Позиция (Цель)',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var $model MonitorDirection */

                        return Yii::$app->controller->view->render('_edit_widget', ['model' => $model, 'attribute' => 'target_position']);
                    }
                ],

                [
                    'label' => 'Позиция (Текущая)',
                    'contentOptions' => function () {
                        return ['class' => 'js-current-position'];
                    },
                    'value' => function ($model) {
                        /** @var $model MonitorDirection */

                        return (int) $model->current_position;
                    }
                ],

                [
                    'label' => 'Позиция (Всего)',
                    'contentOptions' => function () {
                        return ['class' => 'js-total-positions'];
                    },
                    'value' => function ($model) {
                        /** @var $model MonitorDirection */

                        return (int) $model->total_positions;
                    }
                ],
            ],
        ]); ?>

    </div>

</div>
