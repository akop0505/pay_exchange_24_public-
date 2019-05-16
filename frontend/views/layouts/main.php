<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\widgets\OperatorInfo;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use \yii\helpers\Url;

AppAsset::register($this);
$this->registerJs("
$(document).ready(function(){
$('header .main-menu > a').each(function () {
  if($(this).attr('href') == location.pathname) $(this).addClass('active');
});
});
");

$user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="Description" content="">
    <meta name="keywords" content=""/>

    <!-- use of initial-scale means width param is treated as min-width -->
    <meta name="viewport" content="width=1148" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <title><?= \Yii::$app->name . ' - ' . ($this->pageTitle ? Html::encode($this->pageTitle) : Html::encode($this->title)) ?></title>
    <?php $this->head() ?>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    <?php if (YII_ENV != 'dev') {?>

        <?= $this->render('/tech/metrica'); ?>

    <?php } ?>
</head>
<body class="<?= Yii::$app->params['globalCssClass'] ?>">
<?php $this->beginBody() ?>

    <main>

        <header>

            <div class="main-content clearfix">

                <a href="/" class="logo hovered">
                    <img src="/images/logo1.svg" alt="" />
                </a>

                <div class="main-menu">
                    <a href="/" class="main-menu__item">Главная</a>
                    <a href="/faq" class="main-menu__item">FAQ</a>
                    <a href="/rules" class="main-menu__item">Правила</a>
                    <a href="/contacts" class="main-menu__item">Контакты</a>
                </div>

                <?php if (Yii::$app->user->isGuest) { ?>

                    <a href="<?= Url::toRoute(['auth/signin'])?>" class="sign-in-btn waves-effect waves-light">
                        <span>Вход</span>
                    </a>

                <?php } else { ?>


                    <div class="user-menu-pl dropdown-trigger hovered" data-activates="user-menu" data-target="user-menu">

                        <div href="<?= Url::toRoute(['cabinet/index'])?>" class="user-menu-pl__profile"></div>
                        <div class="user-menu-pl__dd-ico"></div>

                    </div>

                    <div id="user-menu" class="user-menu dropdown-content">

                        <a href="<?= Url::toRoute(['cabinet/index'])?>" class="user-menu__email"><?= Yii::$app->user->getIdentity()->email ?></a>

                        <?= Html::beginForm(['auth/logout'], 'post') ?>
                        <button type="submit" class="user-menu__logout hovered" title="Logout">
                            Выйти
                        </button>
                        <?= Html::endForm() ?>

                    </div>



                <?php } ?>
            </div>

        </header>

        <div class="menu-line main-content">

            <h1 class="menu-line__header"><?= $this->title ?></h1>

            <?= OperatorInfo::widget([]); ?>

        </div>



            <?= $content ?>

    </main>

    <footer>

        <div class="main-content footer">
            <div class="footer__menu">
                <a href="/" class="footer__menu-item">Главная</a>
                <?php /*<a href="/cabinet/index" class="footer__menu-item">Личный кабинет</a>*/?>
                <a href="/faq" class="footer__menu-item">FAQ</a>
                <a href="/rules" class="footer__menu-item">Правила обмена</a>
                <a href="/contacts" class="footer__menu-item">Контакты</a>
            </div>

            <div class="footer__copyrights">&copy; <?= date('Y')?></div>
        </div>

    </footer>


<?= $this->render('/tech/feedback-form'); ?>

<?php $this->endBody() ?>

<?php if (YII_ENV != 'dev') {?>
    <?= $this->render('/tech/jivo'); ?>
<?php } ?>

</body>
</html>
<?php $this->endPage() ?>
