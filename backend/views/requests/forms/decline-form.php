<?php

/** @var Request $model */

use backend\models\CompleteRequestForm;
use common\models\Request;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$completeForm = new CompleteRequestForm($model);
?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['decline', 'id' => $model->id]),
    'enableClientValidation' => false,
]); ?>

    <div class="modal-header">
        <h4 class="modal-title pull-left">Отклонить заявку #<?= $model->id?></h4>
        <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <strong>Вы уверены что хотите отклонить заявку?</strong>
    </div>

    <div class="modal-footer">
        <?= Html::submitButton('Закрыть', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])?>
        <?= Html::submitButton('Отклонить', ['class' => 'btn btn-primary js-submit'])?>
    </div>

<?php ActiveForm::end()?>
