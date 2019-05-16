<?php

$this->title = 'Контакты';
$this->pageTitle = 'Напишите нам';
?>

<div class="main-content">

    <div class="contacts">
        <div class="contacts__text">
            Мы всегда готовы ответить на интересующие Вас вопросы, а также выслушать Ваши предложения по улучшению нашего сервиса.
        </div>

        <div class="contacts__links">
            <div class="contacts__links-prompt">
                Вы можете связаться с нами по указанным ниже контактам
            </div>

            <a href="mailto:<?= Yii::$app->params['supportEmail']?>" class="contacts__links-mailto hovered"><?= Yii::$app->params['supportEmail']?></a>
        </div>
    </div>

</div>