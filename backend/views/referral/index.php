<?php

use backend\models\referrals\ReferralFilter;
use backend\models\referrals\ReferralStat;
use common\models\Referrals;


/* @var $this yii\web\View */
/* @var $model Referrals */
/* @var $filter ReferralFilter */


$this->title = Yii::t('app', 'Реф. начисления');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-index">

    <br>

    <?= $this->render('_referrals_filter', compact('filter'))?>

    <?php if ($model) { ?>

        <?= $this->render('_view_stat', compact('model')); ?>

        <hr>
        <h4>Вывод средств</h4>

        <?= $this->render('_withdraw_form', compact('model')); ?>

        <hr>
        <h4>История выплат</h4>

        <?= $this->render('_withdraws_list', compact('model')); ?>

        <hr>
        <h4>Корректировка</h4>
        <br>
        <?= $this->render('_correct_form', compact('model')); ?>

    <?php } ?>

</div>



















