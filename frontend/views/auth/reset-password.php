<?php

/** @var ResetPasswordForm $model */

use frontend\models\forms\ResetPasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Восстановление пароля';
?>

<div class="main-content boxed">

    <div class="registration">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form' . ($model->hasErrors() ? ' error' : ''),
                'autocomplete' => 'off'
            ]
        ]) ?>

            <input style="opacity: 0;position: absolute;">
            <input type="password" style="opacity: 0;position: absolute;">

            <div class="form__caption">
                Укажите новый пароль
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
                        <?= Html::activePasswordInput($model, 'password', ['autocomplete' => 'off']) ?>
                        <?= Html::activeLabel($model, 'password') ?>
                    </div>
                    <div class="input-field col s12">
                        <?= Html::activePasswordInput($model, 'passwordConfirm', ['autocomplete' => 'off']) ?>
                        <?= Html::activeLabel($model, 'passwordConfirm') ?>
                    </div>

            </div>

            <div class="form__buttons">
                <button type="submit" class="btn waves-effect waves-light">Изменить</button>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
