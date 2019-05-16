<?php

/* @var $this View */
/* @var $request Request */

/* @var $dataProvider ActiveDataProvider */

use common\models\Request;
use frontend\helpers\BidHelper;
use frontend\helpers\LKHelper;
use yii\data\ActiveDataProvider;
use yii\web\View;


?>

<?php
/** @var Request $model */
foreach ($dataProvider->getModels() as $model) { ?>

    <div class="detail-orders__item <?= LKHelper::getStatusClass($model) ?>">


        <div class="detail-orders__item-status item-status-color">

            <div style="float: left">
                <div class="item-id">№ <?= $model->id ?></div>
                <div class="status"><?= LKHelper::getStatusName($model) ?></div>
            </div>

            <div style="float: right">
                <div class="date-caption">Дата создания</div>
                <div class="date"><?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y, H:i') ?> (МСК)</div>
            </div>

        </div>

        <div class="detail-orders__item-info">


            <div class="detail-orders__item-info-from">
                <div class="caption">Отправлено</div>
                <div class="c-wrapper">
                    <div class="currency">
                        <img src="/images/<?= $model->currency_from ?>.png" class="currency-icon currency-icon-sm"/>
                        <?= $model->sum_push ?> <?= $model->currencyFrom->view_code ?>
                    </div>
                </div>

                <div class="detail">
                    <span class="detail-caption">Курс обмена:</span>
                    <span class="detail-value"><?= BidHelper::getViewRate($model) ?></span>
                </div>

                <?php if ($model->fio_from) { ?>
                    <div class="detail">
                        <span class="detail-caption">ФИО отправителя:</span>
                        <span class="detail-value"><?= $model->fio_from ?></span>
                    </div>
                <?php } ?>

                <?php if ($model->send_from) { ?>
                    <div class="detail">
                        <span class="detail-caption">Счет отправителя:</span>
                        <span class="detail-value"><?= $model->send_from ?></span>
                    </div>
                <?php } ?>
            </div>

            <div class="detail-orders__item-info-to">
                <div class="caption">Получено</div>
                <div class="c-wrapper">
                    <div class="currency">
                        <img src="/images/<?= $model->currency_to ?>.png" class="currency-icon currency-icon-sm"/>
                        <?= $model->sum_pull ?> <?= $model->currencyTo->view_code ?>
                    </div>
                </div>

                <?php if ($model->fio_to) { ?>
                    <div class="detail">
                        <span class="detail-caption">ФИО получателя:</span>
                        <span class="detail-value"><?= $model->fio_to ?></span>
                    </div>
                <?php } ?>

                <?php if ($model->send_to) { ?>
                    <div class="detail">
                        <span class="detail-caption">Счет получателя:</span>
                        <span class="detail-value"><?= $model->send_to ?></span>
                    </div>
                <?php } ?>
            </div>


        </div>

    </div>

<?php } ?>




