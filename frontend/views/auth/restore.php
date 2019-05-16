<?php

/** @var RestorePasswordForm $model */

use frontend\models\forms\RestorePasswordForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Востановление пароля';
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
                Укажите email на который отправить ссылку для востановления
            </div>

            <?php if ($model->hasErrors()) {?>
                <div class="form__errors">
                    <?php foreach ($model->errors as $error) {
                        echo join('; ', $error) . '<br>';
                    } ?>
                </div>
            <?php } ?>


            <div class="form__inputs">

                <div class="-row">
                    <div class="input-field col s12">
                        <?= Html::activeTextInput($model, 'email', ['autocomplete' => 'off']) ?>
                        <?= Html::activeLabel($model, 'email') ?>
                    </div>
                </div>

            </div>

            <div class="form__buttons">
                <button type="submit" class="btn waves-effect waves-light">Отправить</button>

                <div class="captcha <?= $model->hasErrors('reCaptcha') ? 'error' : ''?>">
                    <?= ReCaptcha::widget([
                        'model' => $model,
                        'attribute' => 'reCaptcha',
                    ])?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
