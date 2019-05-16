<?php

/** @var SignupForm $model */

use frontend\models\forms\SignupForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Регистрация';
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
                Зарегистрируйтесь,
                чтобы создать личный кабинет
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

                    <div class="input-field col s12">
                        <?= Html::activePasswordInput($model, 'password', ['autocomplete' => 'off']) ?>
                        <?= Html::activeLabel($model, 'password') ?>
                    </div>

                    <div class="input-field col s12">
                        <?= Html::activePasswordInput($model, 'passwordConfirm', ['autocomplete' => 'off']) ?>
                        <?= Html::activeLabel($model, 'passwordConfirm') ?>
                    </div>
                </div>

            </div>

            <div class="form__buttons">
                <button type="submit" class="btn">Зарегистрироваться</button>

                <div class="captcha">
                    <?= ReCaptcha::widget([
                        'model' => $model,
                        'attribute' => 'reCaptcha',
                        'siteKey' => '6LekwFUUAAAAAEO_a8XrDNKHzoHd9NQdcRrOY8xj'
                    ])?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
