<?php

/** @var SigninForm $model */

use frontend\models\forms\SigninForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$this->title = 'Вход';
?>

<div class="main-content boxed">

    <?php if (Yii::$app->session->hasFlash('message')) {?>
        <script>
            setTimeout(function () {
                Materialize.toast('<?= Yii::$app->session->getFlash('message')?>');
            }, 1000);
        </script>
    <?php } ?>

    <div class="login">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form' . ($model->hasErrors() ? ' error' : ''),
                'autocomplete' => 'off'
            ]
        ]) ?>

            <input style="opacity: 0;position: absolute;">
            <input type="password" style="opacity: 0;position: absolute;">

            <div class="form__caption">
                Для входа в личный кабинет
                введите ваш логин и пароль
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
                        <?= Html::activePasswordInput($model, 'password', ['autocomplete' => 'off', 'class' => 'password-input']) ?>
                        <?= Html::activeLabel($model, 'password') ?>

                        <a href="<?= Url::toRoute(['auth/restore'])?>" class="form__link forgot-link js-forgot-link">Забыли пароль?</a>
                    </div>
                </div>

            </div>

            <div class="form__buttons">
                <button type="submit" class="btn">Войти</button>

                <a href="<?= Url::toRoute(['auth/signup'])?>" class="form__link reg-link">Зарегистрироваться</a>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
