<?php

use backend\models\referrals\ReferralFilter;
use backend\models\referrals\ReferralStat;
use common\models\Referrals;
use \common\models\enum\Role;

/* @var $this yii\web\View */
/* @var $model Referrals */
/* @var $filter ReferralFilter */


$this->title = Yii::t('app', 'Личный кабинет');
$this->params['breadcrumbs'][] = $this->title;
$page = 'room';
?>

<div class="referral-index">

    <br>

    <?= Yii::$app->user->can(Role::ADMIN) ? $this->render('/referral/_referrals_filter', compact('filter')) : '<h4>' . Yii::$app->user->getIdentity()->username . '</h4><hr>' ?>

    <?php if ($model) { ?>

        <?= $this->render('/referral/_view_stat', compact('model', 'page')); ?>

        <?php if (Yii::$app->user->can(Role::ADMIN)) { ?>
            <hr>
            <h4>Вывод средств</h4>

            <?= $this->render('/referral/_withdraw_form', compact('model')); ?>
        <?php } ?>

        <hr>
        <h4>История выплат</h4>

        <?= $this->render('/referral/_withdraws_list', compact('model')); ?>

        <?php if (Yii::$app->user->can(Role::ADMIN)) { ?>
            <hr>
            <h4>Процент начислений</h4>

            <?= $this->render('_percent_form', compact('user')); ?>
        <?php } ?>
    <?php } ?>

</div>
