<?php


use backend\models\referrals\ReferralWithdrawForm;
use common\models\Referrals;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $model Referrals */
/* @var $withdrawFrom ReferralWithdrawForm */

?>

<div data-app-controller="referrals_percent_form">

    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['user/update-percent', 'id' => $user->id]),
    ])?>

    <?= $form->field($user, 'withdraw_percent')->input('string',[])->label(false)?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>

    <?php ActiveForm::end()?>

</div>
