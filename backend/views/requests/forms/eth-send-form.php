<?php

/** @var Request $model */

use backend\models\requests\SendETHForm;
use common\models\Request;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$sendForm = new SendETHForm($model);

?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['send-eth', 'id' => $model->id]),
    'enableClientValidation' => false,
]); ?>

    <div class="modal-header">
        <h4 class="modal-title pull-left">Отправить ETH на адрес <b><?= $model->send_to?></b></h4>
        <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">

        <div class="alert alert-error js-error" style="display: none"></div>

        <?= $form->field($sendForm, 'amount')->textInput()?>

    </div>

    <div class="modal-footer">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary js-submit'])?>
    </div>

<?php ActiveForm::end()?>
