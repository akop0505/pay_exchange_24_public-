<?php

use common\models\enum\RequestStatus;
use common\models\Request;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = $this->title;

$this->params['bodyClass'] = 'fixed-header-page';
?>

<div class="requests-index" style="overflow: scroll;">

    <div class="requests-grid"
         data-app-controller="requests_grid"
         data-app-options='<?= Json::encode([
             'getRowUrl' => Url::toRoute(['get-grid-row']),
             'getNewRowsUrl' => Url::toRoute(['get-grid-new-rows']),
             'getProcTimeUrl' => Url::toRoute(['get-proc-time']),
         ])?>'
    >


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',

            'tableOptions' => ['class' => 'table --table-striped table-bordered table-hover table-condensed'],

            'rowOptions' => function ($model, $key, $index, $grid) {
                /** @var $model Request */

                $statusClass = 'js-item ';
                switch ($model->done) {
                    case RequestStatus::NEW_CREATED:
                        $statusClass .= 'warning';
                        break;
                    case RequestStatus::COMPLETE:
                        $statusClass .= 'success';
                        break;
                    case RequestStatus::DECLINE:
                        $statusClass .= 'danger';
                        break;
                }
                return ['class' => $statusClass, 'data-id' => $model->id];
            },

            'columns' => [
                'id',
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => function ($model, $id, $i) {
                        /** @var $model Request */

                        return DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at)->format('d.m.Y H:i:s');
                    }
                ],
                [
                    'label' => 'Время вып.',
                    'attribute' => 'processed_at',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'process-time-cell js-process-time-cell'],
                    'value' => function ($model, $id, $i) {
                        /** @var $model Request */

                        return $model->getWorkTimeStr();
                    }
                ],
                [
                    'label' => 'Клиент',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'comment-cell'],
                    'value' => function ($model, $id, $i) {
                        return Yii::$app->controller->view->render('_cell_comment', compact('model'));
                    }
                ],
                [
                    'label' => 'Откуда',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'from-cell'],
                    'value' => function ($model, $id, $i) {
                        return Yii::$app->controller->view->render('_cell_from', compact('model'));
                    }
                ],
                [
                    'label' => 'Куда',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'to-cell'],
                    'value' => function ($model, $id, $i) {
                        return Yii::$app->controller->view->render('_cell_to', compact('model'));
                    }
                ],
                [
                    'label' => 'Действия',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'action-cell'],
                    'value' => function ($model, $id, $i) {
                        return Yii::$app->controller->view->render('_cell_action', compact('model'));
                    }
                ],
            ],
        ]); ?>

    </div>


</div>

<!-- comment popup -->
<div class="modal fade" data-app-controller="requests_CommentForm" data-app-options='<?= Json::encode(['caller' => '.js-comment-form-caller'])?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

        </div>
    </div>
</div>

<!-- amount popup -->
<div class="modal fade" data-app-controller="requests_AmountForm" data-app-options='<?= Json::encode(['caller' => '.js-amount-form-caller'])?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

        </div>
    </div>
</div>

<!-- send funds popup -->
<div class="modal fade" data-app-controller="requests_SendFunds" data-app-options='<?= Json::encode(['caller' => '.js-send-funds-caller'])?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

        </div>
    </div>
</div>

<!-- complete request popup -->
<div class="modal fade" data-app-controller="requests_CompleteForm" data-app-options='<?= Json::encode(['caller' => '.js-complete-form-caller'])?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

        </div>
    </div>
</div>

<!-- decline request popup -->
<div class="modal fade" data-app-controller="requests_DeclineForm" data-app-options='<?= Json::encode(['caller' => '.js-decline-form-caller'])?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

        </div>
    </div>
</div>