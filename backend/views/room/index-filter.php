<?php


use backend\models\referrals\ReferralFilter;

/* @var $this yii\web\View */
/* @var $filter ReferralFilter */

$this->title = Yii::t('app', 'Личный кабинет');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-index">

    <br>

    <?= $this->render('/referral/_referrals_filter', compact('filter'))?>

</div>
