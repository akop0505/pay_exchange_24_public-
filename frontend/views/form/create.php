<?php

use common\models\Currencies;
use common\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model Request */
/** @var $currency Currencies */

$this->pageTitle = 'Подтверждение заявки';

$currency = $model->currencyFrom;
$wallet = $currency->wallet;

$data = [
    'link' => $currency->pay_link,
    'text' => $currency->pay_text,
    'number' => $wallet ? $wallet->requisite : false,
    'fio' => $wallet ? $wallet->requisite_full_name : false,
];

if ($currency->send == 'QWRUB') {
    $data['link_ex'] = "https://qiwi.com/payment/form.action?provider=99&extra['account']=" . $data['number'] . "&currency=643&amountInteger=" . $model->sum_push;
}

if ($model->direction->bank_alert) {
    $data['link'] = 'https://pay.mkb.ru/';
}

$now = time();
$createdAt = (new \DateTime($model->created_at))->getTimestamp();

$counterValid = $now - $createdAt < 900; // 15 min

?>


<script>

  var bidNow = '<?= $now ?>';
  var bidCreated = '<?= $createdAt ?>';

</script>

<div class="main-content">

    <div class="confirm-bid">


        <div class="js-confirm-invalid" style="display: <?= $counterValid ? 'none' : 'block'; ?>"
             data-url="<?= Url::toRoute(['form/cancel', 'hash' => $model->hash_id]) ?>">
            <div class="confirm-attention">Предупреждение</div>

            <div class="confirm-attention-caption">
                Время подтверждения заявки вышло
            </div>

            <div class="confirm-body-wrap">

                <div class="confirm-body">
                    <div class="confirm-decline">
                        Заявка <span>№ <?= $model->id ?></span> отменена
                    </div>


                    <div class="confirm-buttons">
                        <a href="/" class="confirm-buttons__back waves-effect waves-light">На главную</a>
                    </div>
                </div>

            </div>

        </div>


        <div class="js-confirm-valid"
             style="display: <?= $counterValid ? 'block' : 'none'; ?>"
             data-status-url="<?= Url::toRoute(['form/is-draft', 'id' => $model->id]) ?>">

            <div class="confirm-attention">Подтвердите заявку</div>

            <div class="confirm-attention-caption">
                До отмены заявки осталось: <span class="js-minutes"></span> мин <span class="js-seconds"></span> сек

                <!-- Dropdown Trigger -->
                <div class='dropdown-trigger confirm-attention-tip js-lk-hint' href='#' data-activates="tip"></div>

                <!-- Dropdown Structure -->
                <div id="tip" class='dropdown-content confirm-attention-tip__content '>
                    <div class="confirm-attention-tip__content--header">Курс зафиксирован</div>
                    <div class="confirm-attention-tip__content--text">По истечению времени заявка будет автоматически
                        отклонена. Для более детальной информации читайте FAQ.
                    </div>
                </div>
            </div>

            <div class="confirm-body-wrap">

                <div class="confirm-body">

                    <div class="confirm-header">
                        Чтобы подтвердить создание заявки <span>№ <?= $model->id ?></span> вам необходимо:
                    </div>

                    <div class="confirm-step"><?= $currency->isCrypt()
                            ? $data['link']
                            : '1. Перейти на сайт: ' . Html::a(
                                $data['link'],
                                isset($data['link_ex']) ? $data['link_ex'] : $data['link'],
                                ['target' => '_blank']
                            ) ?>
                    </div>

                    <div class="confirm-step confirm-step__step2">2. Сделать перевод по реквизитам:</div>

                    <div class="confirm-info">

                        <table>

                            <tr>
                                <td class="confirm-info__caption"><?= $data['text'] ?>:</td>
                                <td class="confirm-info__value">
                                    <span class="js-req"><?= $model->requisites ?? '<span style="font-size: 12px">За реквизитами обратитесь в чат поддержки</span>' ?></span>
                                </td>
                                <td class="td-copy">
                                    <?php if ($model->requisites) {?>
                                        <div
                                                class="confirm-info-copy waves-effect waves-light js-copy-req"
                                                data-clipboard-text="<?= $model->requisites ?>">Скопировать
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>

                            <?php if ($data['fio'] && !$model->direction->bank_alert) { ?>
                                <tr>
                                    <td class="confirm-info__caption">ФИО:</td>
                                    <td class="confirm-info__value">
                                        <span class="js-req"><?= $data['fio'] ?></span>
                                    </td>
                                    <td class="td-copy">
                                        <div
                                                class="confirm-info-copy waves-effect waves-light js-copy-req"
                                                data-clipboard-text="<?= $data['fio'] ?>">Скопировать
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td class="confirm-info__caption">На сумму:</td>
                                <td class="confirm-info__value">
                                    <span class="js-req"><?= $model->sum_push ?> <?= $currency->currency ?></span>
                                </td>
                                <td class="td-copy">
                                    <div
                                            class="confirm-info-copy waves-effect waves-light js-copy-req"
                                            data-clipboard-text="<?= $model->sum_push ?>">Скопировать
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>

                    <div class="confirm-step confirm-step__step3">3. После оплаты нажать на кнопку
                        <span>“Я ОПЛАТИЛ”</span>
                    </div>

                    <div class="confirm-step confirm-step__summ">
                        Вы получаете: <span><?= $model->sum_pull ?> <?= $model->currencyTo->send ?></span>
                    </div>

                    <div class="confirm-buttons">
                        <a href="<?= Url::toRoute(['form/cancel', 'hash' => $model->hash_id]) ?>"
                           class="confirm-buttons__back waves-effect waves-light">Отменить</a>

                        <a href="<?= Url::toRoute(['form/paid', 'hash' => $model->hash_id]) ?>"
                           class="confirm-buttons__ok waves-effect waves-light">Я оплатил</a>

                        <!--<div class="confirm-buttons__text">
                            <?php /*if ($currency->send == 'BTC') {*/ ?>
                                Заявка будет обработана в течение 30 минут с момента получения 1го подтверждения сети
                            <?php /*} else {*/ ?>
                                Заявка будет обработана в течение 30 минут
                            <?php /*} */ ?>

                        </div>-->
                    </div>
                </div>

            </div>


        </div>

    </div>

</div>


<?php if ($model->direction->bank_alert) {?>

    <div id="alertBankModal" class="modal">

        <div class="modal-header">
            <div class="modal-action modal-close"></div>
            <div class="modal-title">Предупреждение</div>
        </div>

        <div class="modal-content">
            <div class="caption">
                1. Нельзя указывать в комментарии к платежу номер заявки, слово обмен, всякие названия криптовалют. Максимум
                это «Возврат долга или частный перевод»
                <br><br>
                2. В редких случаях требуется звонок в поддержку банка для подтверждения перевода. В этом случае в качестве
                цели перевода обязательно говорите «Возврат долга или частный перевод».
            </div>
        </div>

        <div class="modal-footer">
            <a class="confirm-buttons__ok btn btn-large waves-effect waves-light modal-action modal-close">OK</a>
            <a class="confirm-buttons__ok btn btn-large waves-effect waves-light" href="<?= Url::toRoute(['form/cancel', 'hash' => $model->hash_id]) ?>">Отмена</a>
        </div>

    </div>

<?php } ?>

