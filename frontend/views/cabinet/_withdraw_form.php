<?php



?>

<?php use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
        'action' => Url::toRoute(['cabinet/withdraw']),
    'options' => [
        'class' => 'form' . ($model->hasErrors() ? ' error' : ''),
        'autocomplete' => 'off'
    ]
]) ?>

<div class="modal-header">
    <div class="modal-action modal-close"></div>
</div>

<div class="modal-content">

    <div class="lk-request-modal__caption">
        Введите сумму (руб), которую хотите вывести
    </div>


    <?= Html::activeTextInput($model, 'amount', ['autocomplete' => 'off']) ?>

    <div class="lk-request-modal__error">
        <div class="text">Недостаточно средств</div>
    </div>

</div>

<div class="modal-footer">
    <button class="js-submit lk-submit-btn waves-effect waves-light">Вывести средства</button>
</div>

<?php ActiveForm::end(); ?>
