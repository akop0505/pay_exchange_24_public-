<?php

use frontend\models\forms\ChangePasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var ChangePasswordForm $model */

?>

<div class="main-content boxed">

    <div class="registration">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form' . ($model->hasErrors() ? ' error' : ''),
                'autocomplete' => 'off'
            ]
        ]) ?>

        <div class="form__caption">
            Смена пароля
        </div>

        <?php if ($model->hasErrors()) {?>
            <div class="form__errors">
                <?php foreach ($model->errors as $error) {
                    echo join('; ', $error) . '<br>';
                } ?>
            </div>
        <?php } ?>


        <div class="form__inputs">

            <div class="input-field col s12">
                <?= Html::activePasswordInput($model, 'oldPassword', ['autocomplete' => 'off']) ?>
                <?= Html::activeLabel($model, 'oldPassword') ?>
            </div>

            <div class="input-field col s12">
                <?= Html::activePasswordInput($model, 'newPassword', ['autocomplete' => 'off']) ?>
                <?= Html::activeLabel($model, 'newPassword') ?>
            </div>

            <div class="input-field col s12">
                <?= Html::activePasswordInput($model, 'newPasswordConfirm', ['autocomplete' => 'off']) ?>
                <?= Html::activeLabel($model, 'newPasswordConfirm') ?>
            </div>

        </div>

        <div class="form__buttons">
            <button type="submit" class="btn waves-effect waves-light">Изменить</button>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

