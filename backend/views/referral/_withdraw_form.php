<?php


use backend\models\referrals\ReferralWithdrawForm;
use common\models\Referrals;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $model Referrals */
/* @var $withdrawFrom ReferralWithdrawForm */


$withdrawForm = new ReferralWithdrawForm($model);
?>

<div data-app-controller="referrals_withdraw_form">

    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['add-withdraw', 'id' => $model->id]),
    ])?>


    <?= $form->field($withdrawForm, 'amount')->textInput()->label(false)?>

    <?= Html::submitButton('Вывод', ['class' => 'btn btn-success'])?>

    <?php ActiveForm::end()?>

</div>
