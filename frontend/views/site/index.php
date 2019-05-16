<?php

/* @var $this View */
/* @var $currencyList Reserves[] */

/* @var $amountExchanges string */
/* @var $countExchanges string */
/* @var $countClients string */

use common\models\Reserves;
use frontend\components\View;
use \yii\helpers\Html;

$this->title = 'Быстрый обмен валют';
$this->pageTitle = 'Обмен валют';

?>


<div class="main-content">

    <?= $this->render('exchange/_exchange', ['currencyList' => $currencyList]) ?>

    <div class="main-info">
        <div class="main-info__header">Удобный обмен</div>
        <div class="prompt">Пожалуйста, перед тем как начать обмен ознакомьтесь с пошаговой инструкцией</div>
        <div class="li">1. Выберите из таблицы направление обмена.</div>
        <div class="li">2. В появившейся форме ввдеите сумму обмена, ваш e-mail адрес, номера счетов и подтвердите согласие с правилами обмена.</div>
        <div class="li">3. Оплатите заявку. Платеж необходимо совершить в течение 15-ти минут. После оплаты заявки кликните «Я ОПЛАТИЛ».</div>
        <div class="li">4. Заявка принята и будет обработана в течение 30 минут с момента поступления средств (для ВТС после 3х подтверждений сети).</div>
    </div>

</div>

<div class="front-page">

    <div class="main-content">

        <div class="front-page__header">О нас</div>

        <div class="clearfix front-page__about">

            <div class="front-page__box reviews shadow-box">

                <div class="front-page__box-header">
                    Отзывы
                </div>

                <div class="front-page__box-body">

                    <div class="js-slider">

                    <?php foreach ($feedback as $review): ?>

                        <div class="reviews__item">

                            <div class="reviews__item__info">

                                <div class="reviews__item__info-name"><?= $review['name'] ?></div>
                                <div class="reviews__item__info-date">
                                    <?php
                                    $date = strtotime($review['date']);
                                    echo date('d.m.Y H:i', $date);
                                    ?>
                                </div>
                            </div>

                            <div class="reviews__item__text"><?= $review['text'] ?></div>
                        </div>

                    <?php endforeach; ?>

                    </div>

                </div>

                <div class="front-page__box-footer">

                        <div class="reviews__button hovered js-feedback-form-open">+ Добавить отзыв</div>

                </div>

            </div>


            <div class="front-page__box stat shadow-box">

                <div class="front-page__box-header">
                    Статистика
                </div>

                <div class="front-page__box-body">

                    <div class="js-slider-stat">

                        <div class="stat__item">
                            <div class="stat__caption">
                                Сумма обменов, <span>$</span>
                            </div>
                            <div class="stat__counter">
                                <?= (int) $amountExchanges?>
                            </div>
                        </div>

                        <div class="stat__item">
                            <div class="stat__caption">
                                Количество сделок, шт.
                            </div>
                            <div class="stat__counter">
                                <?= (int) $countExchanges?>
                            </div>
                        </div>

                        <div class="stat__item">
                            <div class="stat__caption">
                                Наши клиенты, чел.
                            </div>
                            <div class="stat__counter">
                                <?= (int) $countClients?>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>


        <div class="front-page__header">Наши партнеры</div>

    </div>

    <?= $this->render('_partners') ?>

</div>
