<?php

$this->title = 'FAQ';
$this->pageTitle = 'Вопросы и ответы';
?>


<div class="main-content">

    <div class="faq js-faq">

        <div class="faq__item">
            <div class="question">
                Не получается сделать обмен. Что делать?
            </div>

            <div class="answer">
                Пожалуйста, свяжитесь с нами через чат поддержки, либо через почту <a href="mailto:<?= Yii::$app->params['supportEmail']?>"><?= Yii::$app->params['supportEmail']?></a> и мы обязательно Вам поможем.
            </div>
        </div>
        <div class="faq__item">
            <div class="question">
                Сколько времени уходит на обмен средств?
            </div>

            <div class="answer">
                В среднем, по статистике обмен происходит за 5 минут, однако, по регламенту заявка обрабатывается в течение 30 минут с момента получения средств(для BTC c момента получения 1го подтверждения сети).
            </div>
        </div>
        <div class="faq__item">
            <div class="question">
                Как войти в личный кабинет?
            </div>

            <div class="answer">
                Для того, чтобы войти в свой личный кабинет Вам потребуется зарегистрироваться на нашем сайте. Нажмите на кнопку «Вход» в правом верхнем углу сайта. Далее нажмите на кнопку «Зарегистрироваться» и заполните форму.
            </div>
        </div>
        <div class="faq__item">
            <div class="question">
                Как узнать статус заявки?
            </div>

            <div class="answer">
                При изменении статуса Вы получите письмо на указанный в форме email. Так же Вы всегда можете отслеживать статус через личный кабинет. Вы будете автоматически зарегистрированы в кабинете при создании заявки и тогда пароль будет отпарвлен в письме на указанную Вами почту. Либо Вы можете зарегистрироваться самостоятельно, указав любой желаемый пароль.
            </div>
        </div>
        <div class="faq__item">
            <div class="question">
                Какие ограничения на суммы обмена?
            </div>

            <div class="answer">
                Ограничения зависят от направления обмена. Минимальное значение указано в поле ввода отправляемой Вами суммы. Если же Вы укажите сумму больше, чем максимально допустимая за 1 заявку, появится соответствующее уведомление.
            </div>
        </div>





    </div>

</div>