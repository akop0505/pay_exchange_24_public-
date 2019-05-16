<?php


use backend\models\referrals\ReferralCorrectForm;
use common\models\Referrals;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $model Referrals */
/* @var $correctForm ReferralCorrectForm */


$correctForm = new ReferralCorrectForm($model);
?>

<div data-app-controller="referrals_correct_form">

    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['correct', 'id' => $model->id]),
    ])?>


    <?= $form->field($correctForm, 'additional')->textInput()?>

    <?= $form->field($correctForm, 'exchange_amount')->textInput()?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end()?>

</div>
