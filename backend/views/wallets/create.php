<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Wallets */

$this->title = 'Create Wallets';
$this->params['breadcrumbs'][] = ['label' => 'Wallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallets-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
