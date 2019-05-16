<?php

use backend\modules\bestchange\models\MonitorDirection;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $model MonitorDirection */
/** @var $attribute string */

?>


<div class="edit-field js-edit-field"
     data-app-controller="autobalance_editField"
     data-url='<?= Url::to(['save-attribute', 'id' => $model->id])?>'
     data-attribute="<?= $attribute?>"
>

    <div class="view-aria edit-field__aria js-view-aria">
        <?= $model->{$attribute} ?>
    </div>

    <div class="edit-aria edit-field__aria js-edit-aria" style="display: none">
        <?= Html::activeTextInput($model, $attribute, ['class' => 'js-edit-input'])?>
    </div>

</div>
