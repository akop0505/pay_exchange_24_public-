<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/registration-end', 'token' => $user->password_reset_token]);
$resetLink = str_replace("manage/","",$resetLink);
?>
<div class="password-reset">
    <p>Здравствуйте, Уважаемый пользователь!</p>

    <p>Для задания пароля перейдите по одноразовой ссылке:<br>
        <?= Html::a(Html::encode($resetLink), $resetLink) ?>
    </p>

    <p>Ссылка будет действительна в течение 1 часа до первой авторизации на сайте.</p>

    <p>Если у Вас возникнут вопросы, пожалуйста, обратитесь в службу поддержки на нашем сайте.</p>

    <p>С уважением, администрация сайта <a href="https://<?= Yii::$app->params['domain']?>"><?= Yii::$app->name?></p>
</div>
