<?php

/* @var $this View */
/* @var $request Request */
/* @var $dataProvider ActiveDataProvider */

use common\models\enum\CryptCurrencyBidStatus;
use common\models\enum\RequestStatus;
use common\models\Request;
use frontend\helpers\BidHelper;
use yii\data\ActiveDataProvider;
use yii\web\View;


$getStatusClass = function (Request $model) {

    switch ($model->done) {
        case RequestStatus::COMPLETE:
            return 'complete';
        case RequestStatus::DECLINE:
            return 'decline';
        case RequestStatus::NEW_CREATED:
            if ($model->currencyFrom->isCrypt() && $model->is_confirmed != CryptCurrencyBidStatus::CONFIRMED) {
                return 'wait';
            }
            return 'in-work';
    }
};

$getStatusName = function (Request $model) {

    switch ($model->done) {
        case RequestStatus::COMPLETE:
            return 'ВЫПОЛНЕНА';
        case RequestStatus::DECLINE:
            return 'ОТКЛОНЕНА';
        case RequestStatus::NEW_CREATED:
            if ($model->currencyFrom->isCrypt() && $model->is_confirmed != CryptCurrencyBidStatus::CONFIRMED) {
                return 'ОЖИДАЕТ ПОСТУПЛЕНИЯ СРЕДСТВ';
            }
            return 'В РАБОТЕ';
    }
};

$pager = $dataProvider->pagination;

?>

<?php
/** @var Request $model */
foreach ($dataProvider->getModels() as $model) { ?>

    <div class="orders__item <?= $getStatusClass($model)?>">

        <div class="orders__item-status">
            <div class="item-id">№ <?= $model->id ?></div>
            <div class="status"><span class="text"><?= $getStatusName($model)?></span></div>

            <div class="date-caption">Дата создания:</div>
            <div class="date"><?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y, H:i')?> (МСК)</div>
        </div>

        <div class="orders__item-info">

            <div class="orders__item-info-from">
                <div class="caption">Отправлено</div>
                <div class="c-wrapper">
                    <div class="currency">
                        <img src="/images/<?= $model->currency_from?>.png" class="currency-icon currency-icon-sm" />
                        <?= $model->sum_push ?> <?= $model->currencyFrom->view_code ?>
                    </div>
                </div>

                <div class="detail">
                    <span class="detail-caption">Курс обмена:</span>
                    <span class="detail-value"><?= BidHelper::getViewRate($model) ?></span>
                </div>

                <?php if ($model->fio_from) {?>
                    <div class="detail">
                        <span class="detail-caption">ФИО отправителя:</span>
                        <span class="detail-value"><?= $model->fio_from?></span>
                    </div>
                <?php } ?>

                <?php if ($model->send_from) {?>
                    <div class="detail">
                        <span class="detail-caption">Счет отправителя:</span>
                        <span class="detail-value"><?= $model->send_from?></span>
                    </div>
                <?php } ?>
            </div>

            <div class="orders__item-info-to">
                <div class="caption">Получено</div>
                <div class="c-wrapper">
                    <div class="currency">
                        <img src="/images/<?= $model->currency_to?>.png" class="currency-icon currency-icon-sm" />
                        <?= $model->sum_pull ?> <?= $model->currencyTo->view_code ?>
                    </div>
                </div>

                <?php if ($model->fio_to) {?>
                    <div class="detail">
                        <span class="detail-caption">ФИО получателя:</span>
                        <span class="detail-value"><?= $model->fio_to ?></span>
                    </div>
                <?php } ?>

                <?php if ($model->send_to) {?>
                    <div class="detail">
                        <span class="detail-caption">Счет получателя:</span>
                        <span class="detail-value"><?= $model->send_to ?></span>
                    </div>
                <?php } ?>
            </div>

        </div>

        <div class="orders__item-actions">
            <!--<div class="repeat-btn hovered">Повторить обмен</div>-->
            <div class="comment-link js-feedback-form-open">Оставить отзыв</div>
            <!--<div class="close-btn hovered"></div>-->
        </div>

    </div>

<?php } ?>



<?php
$links = $pager->getLinks();

if (isset($links['next'])) { ?>

    <div class="js-pager orders__pager" data-url="<?= $links['next'] ?>">
        <div class="more-btn hovered">Показать еще…</div>
    </div>

<?php } ?>



