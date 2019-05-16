<?php

/** @var $model Request */

use common\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="paid-from-cell">

    <div class="item">
        <span class="caption">Валюта:</span>
        <span class="value"><?= Html::encode($model->currency_to) ?></span>
    </div>


    <?php if ($model->currency_to == 'CASHRUB') {?>
        <div class="item">
            <span class="caption">Город:</span>
            <span class="value"><?= Html::encode($model->attr_city) ?></span>
        </div>
        <div class="item">
            <span class="caption">Телефон:</span>
            <span class="value"><?= Html::encode($model->attr_phone) ?></span>
        </div>
        <div class="item">
            <span class="caption">Имя:</span>
            <span class="value"><?= Html::encode($model->attr_name) ?></span>
        </div>
    <?php } else { ?>
        <div class="item">
            <span class="caption">Куда отправить:</span>
            <span class="value"><?= Html::encode($model->send_to) ?></span>
        </div>
    <?php } ?>


    <?php if ($model->ripple_tag) {?>
        <div class="item">
            <span class="caption">Tag Destination:</span>
            <span class="value"><?= Html::encode($model->ripple_tag) ?></span>
        </div>
    <?php } ?>

    <div class="item">
        <span class="caption">Сколько:</span>
        <span class="value"><?= Html::encode($model->sum_pull . ' ' . $model->currencyTo->currency) ?></span>
    </div>

    <?php if ($model->fio_to) {?>
        <div class="item">
            <span class="caption">ФИО:</span>
            <span class="value"><?= Html::encode($model->fio_to) ?></span>
        </div>
    <?php } ?>


</div>


















