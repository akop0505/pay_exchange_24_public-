<?php
use common\services\CryptRateService;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">PayL</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="header-rates">
            <?php if (!(defined('LOCAL_DEV') && LOCAL_DEV) && Yii::$app->user->can('admin')) { ?>
                BTC: <?php echo CryptRateService::create()->getBTC()?>&nbsp;&nbsp;&nbsp; BCH: <?php echo CryptRateService::create()->getBCH()?>  <br>
                ETH: <?php echo CryptRateService::create()->getETH()?> &nbsp;&nbsp; XRP: <?php echo CryptRateService::create()->get('XRP')?>
            <?php } ?>
        </div>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/avatar04.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Yii::$app->user->getIdentity()->username?></span>
                    </a>

                    <ul class="dropdown-menu">

                        <li class="user-footer">

                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>

                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>
