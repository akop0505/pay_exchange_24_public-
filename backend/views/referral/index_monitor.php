<?php

use backend\models\referrals\ReferralFilter;
use common\models\Referrals;


/* @var $this yii\web\View */
/* @var $model Referrals */


$this->title = Yii::t('app', 'Реф. начисления');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-index">

    <br>

    <?= $this->render('_view_stat', compact('model')); ?>


    <hr>
    <h4>История выплат</h4>

    <?= $this->render('_withdraws_list', compact('model')); ?>


</div>



















