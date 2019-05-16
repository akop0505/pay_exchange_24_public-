<?php

use backend\models\referrals\ReferralStat;
use common\models\Referrals;
use frontend\models\forms\ReferralWithdrawForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/** @var ReferralWithdrawForm $model */
/** @var Referrals $referral */
/** @var ReferralStat $stats */

$referral = Yii::$app->user->getIdentity()->referral;
$stats = $referral->getStats();
$model = new ReferralWithdrawForm($referral);
?>

<div class="main-content boxed user-ref clearfix" data-app-controller="lk_ref">


    <div class="ref-left-col">

        <div class="user-ref__caption">Детали</div>

        <div class="user-ref__detail clearfix">

            <div class="user-ref__detail-left">

                <div class="block-info">
                    <div class="block-caption">
                        Ваш процент
                        <div class="block-caption__hint js-lk-hint" data-activates="lk-hint1"></div>
                        <div id="lk-hint1" class="block-caption__hint-popup dropdown-content">
                            Процент, который Вы получаете от суммы обменов рефералов
                        </div>
                    </div>
                    <div class="block-value"><?= $referral->rate ?>%</div>
                </div>
                <div class="block-info">
                    <div class="block-caption">
                        Сумма обменов

                        <div class="block-caption__hint js-lk-hint" data-activates="lk-hint2"></div>
                        <div id="lk-hint2" class="block-caption__hint-popup dropdown-content">
                            Сумма всех выполненных заявок от клиентов, пришедших по Вашей ссылке
                        </div>

                    </div>
                    <div class="block-value"><?= number_format($stats->exchangesSum, 2, ',', ' ')?> руб</div>
                </div>
                <div class="block-info">
                    <div class="block-caption">
                        Заработано

                        <div class="block-caption__hint js-lk-hint" data-activates="lk-hint3"></div>
                        <div id="lk-hint3" class="block-caption__hint-popup dropdown-content">
                            Ваш доход за все время
                        </div>

                    </div>
                    <div class="block-value"><?= number_format($stats->earnings, 2, ',', ' ')?> руб</div>
                </div>

            </div>

            <div class="user-ref__detail-right">

                <div class="block-info">
                    <div class="block-caption">
                        Доступно для вывода

                        <div class="block-caption__hint js-lk-hint" data-activates="lk-hint4"></div>
                        <div id="lk-hint4" class="block-caption__hint-popup dropdown-content">
                            Средства, доступные Вам для вывода
                        </div>

                    </div>
                    <div class="block-value total"><?= number_format($stats->availableToWithdraw, 2, ',', ' ')?> руб</div>
                </div>


                <a class="user-ref__detail-button hovered js-request-wd">Вывести средства</a>

            </div>
        </div>



        <div class="user-ref__caption">Ваша ссылка</div>

        <div class="user-ref__link">
            https://<?= Yii::$app->params['domain']?>/?utm_source=<?= $referral->user->generateRefLink() ?>
            <a class="user-ref__link-button waves-effect waves-light js-ref-link" data-clipboard-text="https://<?= Yii::$app->params['domain']?>/?utm_source=<?= $referral->user->generateRefLink() ?>">Скопировать</a>
        </div>


        <div class="user-ref__caption">О реферальной программе</div>
        <div class="user-ref__text">
            <p>Реферальная программа - вид заработка для зарегистрированных пользователей нашего сервиса, в виде вознаграждений за обмены клиентов, которые пришли к нам по вашей реферальной ссылке.
                Условия реферальных начислений за обмен Ваших рефералов: 0,3 % от суммы обмена.</p>

            <p>Обратите внимание что, Вы получаете процент от заработка сервиса с каждой Вашей обменной операции. Вы получаете реферальные начисления, только если комиссия сервиса за обмен больше 0%. Если комиссия сервиса по данному направлению обмена отсутствует, Вы не получаете реферальные начисления.</p>

        </div>

    </div>


    <div class="ref-right-col">

        <div class="user-ref__caption">История вывода средств</div>

        <div class="ref-history">

            <div class="ref-history__row ref-history-header">
                <div class="ref-history__l">Дата</div>
                <div class="ref-history__r">Сумма</div>
            </div>


            <?php foreach ($referral->withdraws as $withdraw) { ?>
                <div class="ref-history__row">
                    <div class="ref-history__l"><?= \Yii::$app->formatter->asDate($withdraw->created_at, 'php:d.m.Y')?></div>
                    <div class="ref-history__r"><?= number_format($withdraw->amount, 2, ',', ' ')?> руб</div>
                </div>
            <?php } ?>


        </div>

    </div>


    <div id="lk-request-modal" class="modal lk-request-modal js-request-modal">
        <?= $this->render('_withdraw_form', ['model' => $model]) ?>
    </div>


    <div id="lk-success-modal" class="modal lk-success-modal js-success-modal">
        <div class="modal-content">
            <div class="icon"></div>
            <div class="caption">Ваша заявка на вывод успешно принята и скоро будет обработана</div>
        </div>

        <div class="modal-footer">
            <a class="js-success-bid-form modal-close submit-btn waves-effect waves-light btn-large" onclick="">OK</a>
        </div>
    </div>
</div>


