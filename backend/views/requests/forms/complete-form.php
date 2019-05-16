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
    'action' => Url::toRoute(['complete', 'id' => $model->id]),
    'enableClientValidation' => false,
]); ?>

    <div class="modal-header">
        <h4 class="modal-title pull-left">Выполнить заявку #<?= $model->id?></h4>
        <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">

        <div class="alert alert-error js-error" style="display: none"></div>

        <?= $form->field($completeForm, 'wallet_id')->dropDownList(ArrayHelper::map($model->wallets, 'id', 'requisite'))?>

        <?= $form->field($completeForm, 'amount')->textInput()?>

        <?= $form->field($completeForm, 'commission')->textInput()?>

        <?php if ($model->currencyTo->isCrypt()) {

            echo $form->field($completeForm, 'txId')->textInput();

        } ?>

    </div>

    <div class="modal-footer">
        <?= Html::submitButton('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])?>
        <?= Html::submitButton('Выполнить', ['class' => 'btn btn-primary js-submit'])?>
    </div>

<?php ActiveForm::end()?>
