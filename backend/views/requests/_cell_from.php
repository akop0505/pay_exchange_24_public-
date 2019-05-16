<?php

/** @var $model Request */

use common\models\enum\CryptCurrencyBidStatus;
use common\models\Request;
use common\services\CryptRateService;
use yii\bootstrap\Html;
use yii\helpers\Url;


?>


<div class="paid-from-cell">

    <div class="item">
        <span class="caption">Валюта:</span>
        <span class="value"><?= Html::encode($model->currency_from)?></span>
    </div>


    <?php if ($model->currency_from == 'CASHRUB') {?>
        <div class="item">
            <span class="caption">Город:</span>
            <span class="value"><?= Html::encode($model->attr_city )?></span>
        </div>
        <div class="item">
            <span class="caption">Телефон:</span>
            <span class="value"><?= Html::encode($model->attr_phone )?></span>
        </div>
        <div class="item">
            <span class="caption">Имя:</span>
            <span class="value"><?= Html::encode($model->attr_name )?></span>
        </div>
    <?php } else { ?>
        <div class="item">
            <span class="caption">Куда придет:</span>
            <span class="value"><?= Html::encode($model->requisites)?></span>
        </div>
    <?php } ?>


    <div class="item">
        <span class="caption">Сколько:</span>
        <span class="value"><?= Html::encode($model->sum_push . ' ' . $model->currencyFrom->currency )?></span>
        &nbsp;&nbsp;&nbsp;
        <?= Html::button('Реадктировать', [
            'class' => 'btn btn-default btn-xs js-amount-form-caller',
            'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'amount-form']),
        ])?>
    </div>

    <?php if ($model->send_from) {?>
        <div class="item">
            <span class="caption">Откуда:</span>
            <span class="value"><?= Html::encode($model->send_from)?></span>
        </div>
    <?php } ?>


    <?php if ($model->fio_from) {?>
        <div class="item">
            <span class="caption">ФИО:</span>
            <span class="value"><?= Html::encode($model->fio_from)?></span>
        </div>
    <?php } ?>


    <!-- подтверждения и статус -->

    <?php if ($model->currencyFrom->isBTC()) { ?>

        <?php if ($model->is_confirmed == CryptCurrencyBidStatus::CONFIRMED) {?>

            <div class="item">
                <span class="caption">Сумма поступлений:</span>
                <span class="value"><?= number_format($model->blockchain_value / 100000000, 7) ?> BTC</span>
            </div>
            <div class="item">
                <span class="caption">Подтверждений:</span>
                <span class="value"><?= Html::encode($model->blockchain_confirmations )?></span>
            </div>
            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value green">Подтверждено</span>
            </div>

        <?php } else if ($model->is_confirmed == CryptCurrencyBidStatus::WAIT) {?>

            <div class="item">
                <span class="caption">Сумма поступлений:</span>
                <span class="value"><?= number_format($model->blockchain_value / 100000000, 7) ?> BTC</span>
            </div>
            <div class="item">
                <span class="caption">Подтверждений:</span>
                <span class="value"><?= Html::encode($model->blockchain_confirmations )?></span>
            </div>
            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value wait">Ожидает подтверждения</span>
            </div>

        <?php } else { ?>

            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value red">Поступлений нет</span>
            </div>

        <?php } ?>

    <?php } ?>

    <?php if ($model->currencyFrom->isETH()) { ?>

        <?php if ($model->is_confirmed == CryptCurrencyBidStatus::CONFIRMED) {?>

            <div class="item">
                <span class="caption">Сумма поступлений:</span>
                <span class="value"><?= Html::encode($model->transaction_amount )?> ETH</span>
            </div>
            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value green">Подтверждено</span>
            </div>

        <?php } else if ($model->is_confirmed == CryptCurrencyBidStatus::WAIT) {?>

            <div class="item">
                <span class="caption">Сумма поступлений:</span>
                <span class="value"><?= Html::encode($model->transaction_amount )?> ETH</span>
            </div>
            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value wait">Ожидает подтверждения</span>
            </div>

        <?php } else { ?>

            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value red">Поступлений нет</span>
            </div>

        <?php } ?>

    <?php } ?>

    <?php if ($model->currencyFrom->isBCH()) { ?>

        <?php if ($model->is_confirmed == CryptCurrencyBidStatus::CONFIRMED) {?>

            <div class="item">
                <span class="caption">Сумма поступлений:</span>
                <span class="value"><?= Html::encode($model->transaction_amount )?> BCH</span>
            </div>
            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value green">Подтверждено</span>
            </div>

        <?php } else if ($model->is_confirmed == CryptCurrencyBidStatus::WAIT) {?>

            <div class="item">
                <span class="caption">Сумма поступлений:</span>
                <span class="value"><?= Html::encode($model->transaction_amount )?> BCH</span>
            </div>
            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value wait">Ожидает подтверждения</span>
            </div>

        <?php } else { ?>

            <div class="item">
                <span class="caption">Статус:</span>
                <span class="value red">Поступлений нет</span>
            </div>

        <?php } ?>

    <?php } ?>




    <?php if ($model->currencyFrom->isCrypt()) { ?>

        <div class="item">
            <span class="caption">Курс заявки:</span>
            <span class="value"><?= Html::encode($model->exchange_price_dfrom )?> <?= Html::encode($model->currency_from)?> = <?= Html::encode($model->exchange_price )?> <?= Html::encode($model->currency_to )?></span>
        </div>

        <div class="item">
            <span class="caption">Оф. курс:</span>
            <span class="value">1 <?= Html::encode($model->currency_from)?> = <?= CryptRateService::create()->get($model->currency_from)?></span>
        </div>

    <?php } else if ($model->currencyTo->isCrypt()) { ?>

        <div class="item">
            <span class="caption">Курс заявки:</span>
            <span class="value"><?= Html::encode($model->exchange_price )?> <?= Html::encode($model->currency_to )?> = <?= Html::encode($model->exchange_price_dfrom )?> <?= Html::encode($model->currency_from )?></span>
        </div>

        <div class="item">
            <span class="caption">Оф. курс:</span>
            <span class="value">1 <?= Html::encode($model->currency_to )?> = <?= CryptRateService::create()->get($model->currency_to)?></span>
        </div>

    <?php } else { ?>

        <div class="item">
            <span class="caption">Курс заявки:</span>
            <span class="value"><?= Html::encode($model->exchange_price_dfrom )?> <?= Html::encode($model->currency_from )?> = <?= Html::encode($model->exchange_price )?> <?= Html::encode($model->currency_to )?></span>
        </div>

    <?php } ?>

</div>


















