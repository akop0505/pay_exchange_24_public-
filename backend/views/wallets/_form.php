<?php

use common\models\enum\WalletType;
use common\services\CurrenciesService;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Wallets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallets-form" data-app-controller="wallets_form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList(WalletType::getNamesList(), ['class' => 'form-control js-type']) ?>

    <?= $form->field($model, 'direction')->dropDownList(CurrenciesService::create()->getCurrenciesListBySID(), ['class' => 'form-control js-curr-name js-curr-select']) ?>

    <?= $form->field($model, 'direction')->textInput(['class' => 'form-control js-curr-name js-curr-input'])->label('Название') ?>

    <?= $form->field($model, 'balance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requisite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requisite_full_name')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
