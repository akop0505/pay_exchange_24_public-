<?php

use backend\models\AddIncomeForm;
use common\models\Wallets;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

$model = new AddIncomeForm();

$walletsList = ArrayHelper::map(Wallets::find()->orderBy('direction')->all(), 'id', function ($model) {
    return $model->requisite . " ({$model->direction})";
});
?>


<div class="modal fade" data-app-controller="accounting_IncomeForm" data-app-options='<?= Json::encode(['caller' => '.js-income-form-caller'])?>'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content js-body">

            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['add-income']),
                'enableClientValidation' => false,
            ]); ?>

            <div class="modal-header">
                <h4 class="modal-title pull-left">Добавить операцию</h4>
                <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

                <?= $form->field($model, 'comment')->textarea() ?>

                <?= $form->field($model, 'walletFromId')->dropDownList($walletsList, ['prompt' => '']) ?>

                <?= $form->field($model, 'amountFrom')->textInput() ?>

                <?= $form->field($model, 'walletToId')->dropDownList($walletsList, ['prompt' => '']) ?>

                <?= $form->field($model, 'amountTo')->textInput() ?>


                <?= $form->field($model, 'date')->widget(DatePicker::className(), [
                    'dateFormat' => 'php:d.m.Y',
                    'options' => ['class' => 'form-control']
                ]) ?>

                <?= $form->field($model, 'ignoreRotation')->checkbox() ?>
            </div>

            <div class="modal-footer">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-submit'])?>
            </div>

            <?php ActiveForm::end()?>


        </div>
    </div>
</div>