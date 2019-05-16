<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Wallets */

$this->title = 'Update Wallets: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wallets-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
