<?php


use frontend\models\forms\FeedbackForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$model = new FeedbackForm();
?>



<div id="successFeedback" class="modal success-modal success-fb-modal">

    <div class="modal-content">
        <div class="icon-fb"></div>
        <div class="caption">
            Спасибо! Ваш отзыв отправлен на модерацию и скоро будет размещен на сайте.
        </div>
    </div>

    <div class="modal-footer">
        <a class="js-success-bid-form submit-btn waves-effect waves-light btn-large" onclick="location.reload(true)">OK</a>
    </div>

</div>


<div id="feedbackModal" class="modal feedback-modal" data-app-controller="feedback_form">

    <div class="modal-content registration">

            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['feedback/create']),
                'options' => [
                    'class' => 'js-feedback form simple-form' . ($model->hasErrors() ? ' error' : ''),
                    'autocomplete' => 'off'
                ]
            ]) ?>

            <div class="form__caption">
                Написать отзыв
            </div>

        <div class="form__errors js-error" style="display: none">

        </div>


            <?= Html::activeTextInput($model, 'name', [
                'autocomplete' => 'off',
                'placeholder' => 'Имя',
                'class' => 'browser-default'
            ]) ?>

        <br>
        <br>
            <?= Html::activeTextarea($model, 'text', [
                'autocomplete' => 'off',
                'placeholder' => 'Текст отзыва',
                'class' => 'browser-default'
            ]) ?>




            <div class="form__buttons">
                <button type="submit" class="waves-effect waves-light btn">Отправить</button>

                <div class="captcha js-captcha">
                    <?= ReCaptcha::widget([
                        'model' => $model,
                        'attribute' => 'reCaptcha',
                    ])?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


    </div>

</div>
