<?php


/* @var $this View */
/* @var $currencyList Reserves[] */

use common\models\Reserves;
use frontend\components\View;
use frontend\models\exchange\ExchangeMain;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Directions;

$isVisible = function ($code) use ($currencyList) {
    return isset($currencyList[$code]) && $currencyList[$code]->enable;
};

$form = new ExchangeMain();
$formDirection = new Directions();
?>



<div class="exchange js-exchanger">

    <form method="post" action="<?= Url::toRoute(['form/create'])?>" autocomplete="off" style="display: block;" class="js-form clearfix" data-app-controller="exg_form">

        <div class="exchange__block exchange__from exchange__list shadow-box">

            <div class="exchange__header">1. Отдаете</div>

            <div class="exchange__block__top">

                <div class="input-field">
                    <?= Html::activeTextInput($form, 'amountFrom', [
                        'class' => 'from js-required js-sell',
                        'placeholder' => 'Мин. сумма обмена:'
                    ])?>
                    <div class="error-keeper">Мин. сумма обмена: 0.01 BTC</div>
                    <img src="" class="currency-icon currency-icon-sm js-icon-from"  style="display: none;">
                </div>

                <div class="exchange__list__caption clearfix">
                    <span class="exchange__list__caption-exchange">Платежная система</span>
                </div>

            </div>

            <div class="js-list-from">

            <?php foreach ($currencyList as $model) { ?>
                <div
                    class="exchange__list-item js-currency js-currency-sell js-currency-sell-<?= $model->currency?>"
                    style="<?= !$model->enable ? 'display: none;' : ''?>"
                    data-name="<?= $model->currency?>"
                    data-big="b-ico-<?= $model->currency?>">

                    <div class="name">
                        <?= $model->currencyModel->view_name ?>
                        <img src="/images/<?= $model->currency ?>.png" class="currency-icon currency-icon-sm" alt="">
                    </div>
                </div>
            <?php } ?>

            </div>

        </div>

        <div class="exchange__block exchange__to exchange__list shadow-box">

            <div class="exchange__header">2. Получаете</div>

            <div class="exchange__block__top">

                <div class="input-field">
                    <?= Html::activeTextInput($form, 'amountTo', [
                        'class' => 'to js-required js-buy',
                    ])?>
                    <div class="error-keeper to">Error</div>
                    <img src="" class="currency-icon currency-icon-sm js-icon-to"  style="display: none;">
                </div>


                <div class="exchange__list__caption clearfix">
                    <span class="exchange__list__caption-exchange">Платежная система</span>
                    <span class="exchange__list__caption-reserve">Резерв</span>
                </div>

            </div>

            <div class="js-list-to">

            <?php foreach ($currencyList as $model) { ?>

                <div
                    class="exchange__list-item js-currency js-currency-buy js-currency-buy-<?= $model->currency ?>"
                    style="<?= !$model->enable ? 'display: none;' : ''?>"
                    data-name="<?= $model->currency?>"
                    data-big="b-ico-<?= $model->currency?>">

                    <div class="name">
                        <?= $model->currencyModel->view_name ?>
                        <img src="/images/<?= $model->currency ?>.png" class="currency-icon currency-icon-sm" alt="">
                    </div>
                    <div class="reserves">
                        <span class="js-reserve"><?= $model->getFormatAmount() ?></span>
                        <span class="currency"><?= $model->currencyModel->isCrypt() ? $model->currencyModel->currency : 'RUB'?></span>
                    </div>
                </div>

            <?php } ?>

            </div>

        </div>

        <div class="exchange__block exchange__details shadow-box">

            <div class="exchange__header">3. Ввод данных</div>

            <div class="exchange__block__top">

                <div class="exchange__details-course">
                    КУРС:
                    <span class="js-course-full">
                        <span class="js-course-sell"></span>&nbsp;<span class="js-course-sell-currency"></span>&nbsp;=&nbsp;
                        <span class="js-course-buy"></span>&nbsp;<span class="js-course-buy-currency"></span>
                    </span>
                </div>

                <div class="exchange__details__currency">
                    <span class="js-amount-from">...</span> <span class="js-amount-from-currency"></span>
                    <img src="" class="currency-icon currency-icon-sm js-icon-from" style="display: none;">
                </div>

                <div class="exchange__details__currency">
                    <span class="js-amount-to">...</span> <span class="js-amount-to-currency"></span>
                    <img src="" class="currency-icon currency-icon-sm js-icon-to" style="display: none;">
                </div>

                <div class="exchange__details__switch hovered js-switch"></div>

            </div>


            <?= Html::activeHiddenInput($form, 'from', ['class' => 'js-exchange-form-from']) ?>
            <?= Html::activeHiddenInput($form, 'to', ['class' => 'js-exchange-form-to']) ?>

            <?= Html::activeHiddenInput($formDirection, 'd_out', ['class' => 'js-course-buy-hidden']) ?>
            <?= Html::activeHiddenInput($formDirection, 'd_in', ['class' => 'js-course-sell-hidden']) ?>


            <div class="exchange__form">

                <div class="row">

                    <?php if (Yii::$app->user->isGuest) { ?>

                        <div class="input-field">
                            <?= Html::activeTextInput($form, 'email', [
                                'class' => 'js-email js-required',
                                'placeholder' => 'email@example.com',
                            ])?>
                            <?= Html::activeLabel($form, 'email')?>
                            <div class="error-keeper">Error</div>
                        </div>

                    <?php } else { ?>

                        <?= Html::activeHiddenInput($form, 'email')?>

                    <?php } ?>


                    <div class="js-form-fields-block clearfix">

                    </div>

                    <div class="confirm-rules">
                        <input type="checkbox" class="filled-in js-required js-checkbox" id="filled-in-box" />
                        <label for="filled-in-box">
                            Я согласен с <a target="_blank" href="/rules">правилами соглашения</a>
                        </label>
                        <div class="error-keeper">Error</div>
                    </div>

<!--                    <div class="captcha js-captcha">
                        <?php /*echo ReCaptcha::widget([
                            'model' => $form,
                            'attribute' => 'reCaptcha',
                        ])*/?>
                    </div>-->

                    <div class="btn-wrapper">
                        <button class="submit-btn waves-effect waves-light js-submit-btn">Обменять</button>
                    </div>
                </div>
                <div class="loader"></div>
            </div>

        </div>

    </form>

</div>



<div id="successBidModal" class="modal success-modal">


    <div class="modal-content">
        <div class="icon"></div>
        <div class="caption"><span class="js-text">Ваша заявка будет обработана в течение 30 минут</span></div>
    </div>

    <div class="modal-footer">
        <a class="js-success-bid-form submit-btn waves-effect waves-light btn-large" onclick="location.reload(true)">OK</a>
    </div>

</div>

<div id="confirmBidModal" class="modal confirm-modal">

    <div class="modal-header">
        <div class="modal-action modal-close"></div>
        <div class="modal-title">Подтвердите заявку</div>
    </div>

    <div class="modal-content">
        <div class="caption">Чтобы подтвердить создание заявки вам необходимо:</div>

        <div id="url-href" class="step">
            1. Перейти на сайт: <a href="#" target="_blank" class="js-href"></a>
        </div>

        <div id="url-inct" class="step" style="display: none">
            1. Перейти на сайт: <a href="#" target="_blank" class="js-href"></a>
        </div>

        <div class="step">
            2. Сделать перевод по реквизитам:

            <div class="req"><span class="js-pay-type"></span>: <span class="selected js-pay-number"></span> <div class="copy btn-clipboard-number" data-clipboard-text="test"></div></div>

            <div class="req line-fio" style="display: block">
                <span class="js-fio-type"></span> <div class="copy btn-clipboard-fio" data-clipboard-text="test"></div>
            </div>

            <div class="req">На сумму: <span class="js-sum-request selected">15 000</span> <span class="currency-popup selected"></span> <div class="copy btn-clipboard-price" data-clipboard-text="test111"></div></div>
        </div>

        <div class="step">3. После оплаты нажать на кнопку <span class="sell">“Я ОПЛАТИЛ”</span></div>

        <!--<div class="notify">Заявка будет обработана в течении 5-15 минут.</div>-->
    </div>

    <div class="modal-footer">
        <a class="js-confirm-bid-form submit-btn waves-effect waves-light btn-large">Я оплатил</a>
    </div>

</div>