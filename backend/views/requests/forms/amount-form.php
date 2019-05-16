<?php

/** @var Request $model */

use common\models\Request;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['save-sum-push', 'id' => $model->id]),
    'enableClientValidation' => false,
]); ?>

    <div class="modal-header">
        <h4 class="modal-title pull-left">Редактировать сумму заявки #<?= $model->id?></h4>
        <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">

        <?= $form->field($model, 'sum_push')->textInput()?>

    </div>

    <div class="modal-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-submit'])?>
    </div>

<?php ActiveForm::end()?>
