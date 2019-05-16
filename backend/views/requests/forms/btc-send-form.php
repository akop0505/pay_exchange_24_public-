<?php

/** @var Request $model */

use backend\models\requests\SendBTCForm;
use common\models\Request;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$sendForm = new SendBTCForm($model);

?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['send-b-t-c', 'id' => $model->id]),
    'enableClientValidation' => false,
]); ?>

    <div class="modal-header">
        <h4 class="modal-title pull-left">Отправить BTC на адрес <b><?= $model->send_to?></b></h4>
        <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">

        <div class="alert alert-error js-error" style="display: none"></div>


        <?= $form->field($sendForm, 'amount')->hiddenInput()->label(false) ?>
        <?= $form->field($sendForm, 'amount')->textInput(['disabled' => true])?>

        <?= $form->field($sendForm, 'commission')->textInput()?>

        <?= $form->field($sendForm, 'password')->passwordInput()?>

    </div>

    <div class="modal-footer">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary js-submit'])?>
    </div>

<?php ActiveForm::end()?>
