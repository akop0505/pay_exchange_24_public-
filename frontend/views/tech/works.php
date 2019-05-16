<?php

use common\models\Settings;
use frontend\components\View;

/* @var $this View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Технические работы';
$this->pageTitle = 'Технические работы';

$time = Settings::get()->text_tech_works;
$time = explode(' ', $time);
?>

<div class="main-content boxed">

    <div class="tech-works">

        <div class="tech-works__header">

            <div class="tech-works__header-logo">

            </div>


            <div class="tech-works__header-text">
                На данный момент на сайте ведутся технические работы.
            </div>
        </div>


        <div class="text1">
            Все заявки, которые уже были созданы - будут <br>обработаны в штатном режиме.
        </div>

        <div class="text2">
            Прием новых заявок возобновится:
        </div>

        <div class="timer clearfix">
            <div class="timer-date">
                <?= $time[0]?>
            </div>

            <div class="timer-time">
                <?= $time[1]?> по МСК
            </div>
        </div>

        <div class="text3">
            Если у Вас остались какие-либо вопросы - <br>напишите на нашу почту
        </div>
        
            <a class="mail-to" href="mailto:24expay@gmail.com">24expay@gmail.com</a>

        <div class="text4">
            Приносим извинения за возможные неудобства
        </div>

    </div>
</div>