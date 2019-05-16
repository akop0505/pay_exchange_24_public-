<?php

use frontend\components\View;
use yii\data\ActiveDataProvider;

/* @var $this View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $dataProvider ActiveDataProvider */

$this->pageTitle = 'Личный кабинет';
$this->title = 'Личный кабинет';


$referral = Yii::$app->user->getIdentity()->referral;

?>

<?php if (Yii::$app->session->hasFlash('message')) {?>
    <script>
        setTimeout(function () {
            Materialize.toast('<?= Yii::$app->session->getFlash('message')?>');
        }, 1000);
    </script>
<?php } ?>



<div class="main-content boxed" data-app-controller="lk_list">

    <div class="lk">

        <div class="lk__menu">

            <div class="nav-content">
                <ul class="tabs tabs-transparent">
                    <li class="tab"><a href="#orders">Заявки</a></li>
                    <?php if ($referral) {?>
                        <li class="tab"><a class="" href="#referals">Реферальная программа</a></li>
                    <?php } ?>
                    <li class="tab"><a class="<?= $model->hasErrors() ? 'active' : ''?>" href="#settings">Настройки</a></li>
                </ul>
            </div>

        </div>

        <div id="orders">

            <div class="main-info">
                <div class="main-info__header">Доступный мониторинг Ваших транзакций</div>
                <div class="prompt">На этом экране отображаются Ваши последние заявки:</div>
                <div class="li">• 	отслеживайте движение Ваших финансовых стредств</div>
                <div class="li">• 	повторяйте транзакции в один клик</div>
                <div class="li">• 	оставляйте отзывы</div>

                <!--<div class="close-btn hovered"></div>-->
            </div>

            <div class="orders">
                <?= $this->render('_items', ['dataProvider' => $dataProvider])?>
            </div>

        </div>

        <div id="settings">
            <?= $this->render('_settings', ['model' => $model])?>
        </div>

        <?php if ($referral) {?>
            <div id="referals">
                <?= $this->render('_referals', ['model' => $model])?>
            </div>
        <?php } ?>

    </div>

</div>

<div class="top-button" data-app-controller="top_btn"></div>