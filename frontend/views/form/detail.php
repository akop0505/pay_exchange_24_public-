<?php

use common\models\Request;
use frontend\helpers\BidHelper;
use frontend\helpers\LKHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $model Request */
/** @var $this View */

$this->pageTitle = 'Обмен валют';
$this->title = 'Заявка № ' . $model->id;

?>


<div class="main-content bid-info boxed js-check-status"
     data-status="<?= $model->done?>"
     data-status-url="<?= Url::toRoute(['form/get-status', 'id' => $model->id])?>">


    <?php if ($model->isNewCreated()) {?>

        <div class="bid-info__alert">

            <div class="bid-info__alert-close" onclick="$(this).parent().hide()"></div>

            Ваша заявка успешно создана.
            <?php if ($model->currencyFrom->send == 'BTC') { ?>
                Заявка будет обработана в течение 30 минут с момента получения 1го подтверждения сети
            <?php } else { ?>
                Заявка будет обработана в течение 30 минут
            <?php } ?>
        </div>

    <?php } ?>


    <div class="bid-info__head">
        Заявка № <?= $model->id ?>
    </div>

    <div class="bid-info__status <?= LKHelper::getStatusClass($model) ?>">
        статус: <span class="status"><?= LKHelper::getStatusName($model) ?></span>
    </div>

    <div class="bid-info__cols clearfix">

        <div class="bid-info__req">

            <div class="bid-info__req-caption">Отправлено</div>
            <div class="currency">
                <img src="/images/<?= $model->currency_from ?>.png" class="currency-icon currency-icon-md"/>
                <div class="bid-info__req-value"><?= $model->sum_push ?> <?= $model->currencyFrom->view_code ?></div>
            </div>

            <div class="bid-info__req-caption">Получено</div>
            <div class="currency">
                <img src="/images/<?= $model->currency_to ?>.png" class="currency-icon currency-icon-md"/>
                <div class="bid-info__req-value"><?= $model->sum_pull ?> <?= $model->currencyTo->view_code ?></div>
            </div>

            <div class="hr-line"></div>

            <div class="bid-info__req-req">

                <div class="detail">
                    <div class="detail-caption">Курс обмена:</div>
                    <div class="detail-value"><?= BidHelper::getViewRate($model) ?></div>
                </div>

                <?php if ($model->fio_from) { ?>
                    <div class="detail">
                        <div class="detail-caption">ФИО отправителя:</div>
                        <div class="detail-value"><?= $model->fio_from ?></div>
                    </div>
                <?php } ?>

                <?php if ($model->send_from) { ?>
                    <div class="detail">
                        <div class="detail-caption">
                            <?= $model->currencyFrom->isBank() ? 'Номер карты отправителя'  : 'Кошелек отправителя' ?>:
                        </div>
                        <div class="detail-value"><?= $model->send_from ?></div>
                    </div>
                <?php } ?>

                <?php if ($model->fio_to) { ?>
                    <div class="detail">
                        <div class="detail-caption">ФИО получателя:</div>
                        <div class="detail-value"><?= $model->fio_to ?></div>
                    </div>
                <?php } ?>

                <?php if ($model->send_to) { ?>
                    <div class="detail">
                        <div class="detail-caption">
                            <?= $model->currencyTo->isBank() ? 'Номер карты получателя'  : 'Кошелек получателя' ?>:
                        </div>
                        <div class="detail-value"><?= $model->send_to ?></div>
                    </div>
                <?php } ?>

            </div>

        </div>

        <div class="bid-info__text">

            <div class="text-block block_1">
                <?php if ($model->isNewCreated()) { ?>

                    Заявка будет обработана в течение 30 минут с момента поступления оплаты.

                <?php } else if ($model->isDeclined()) { ?>

                    Причина "Оплата не поступила, либо ожидается вывод средств из сторонней системы."

                <?php } else if ($model->isCompleted()) { ?>

                    Будем признательны, если оставите отзыв о нашей работе!
                    <br>
                    <br>
                    <a target="_blank" class="bid-info__btn" href="<?= Yii::$app->params['bestchangePage'] ?>">Оставить
                        отзыв</a>
                    <br>
                    <br>
                    Спасибо и всего доброго!

                <?php } ?>
            </div>

            <?php

            if ($model->isNewCreated()) {

                try {
                    echo $this->render('text/' . $model->currency_from . '-from', compact('model'));
                } catch (Exception $e) {
                }

                try {
                    echo $this->render('text/' . $model->currency_to . '-to', compact('model'));
                } catch (Exception $e) {
                }

            }

            ?>

            <div class="text-block block_4">
                Если у Вас возникли сложности или есть вопросы, прочитайте <?= Html::a('FAQ', ['site/faq'])?>, скорее всего там уже есть ответ. Если
                все ещё остался вопрос, тогда напишите в наш чат поддержки.
            </div>

        </div>
    </div>


</div>
