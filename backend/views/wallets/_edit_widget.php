<?php

use common\models\Wallets;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $model Wallets */
/** @var $attribute string */

?>


<div class="trans-widget edit-field js-edit-field"
     data-app-controller="wallet_editField"
     data-url='<?= Url::to(['wallets/save-transactions', 'id' => $model->id])?>'
     data-attribute="trans_available"
>

    <div class="trans-formula-item view-aria trans-receive"><?= $model->trans_receive?> (</div>

    <div class="trans-formula-item view-aria  js-view-aria">
        <?= $model->trans_available ?>
    </div>

    <div class="trans-formula-item edit-aria  js-edit-aria" style="display: none">
        <?= Html::activeTextInput($model, 'trans_available', ['class' => 'js-edit-input'])?>
    </div>

    <div class="trans-formula-item view-aria">) + <?= $model->trans_sends ?></div>
    <div class="trans-formula-item view-aria">= <?= $model->trans_sends + $model->trans_receive ?></div>

</div>
