<?php


use backend\models\referrals\ReferralFilter;
use common\models\Referrals;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $filter ReferralFilter */

?>


<div data-app-controller="referrals_filter"
     data-url="<?= Url::toRoute(['monitor'])?>"
     data-back-url="<?= Url::toRoute(['index-admin'])?>"
>

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ])?>

    <?= $form->field($filter, 'id')->dropDownList(
            ArrayHelper::map(
                Referrals::find()->joinWith('user', true, 'RIGHT JOIN')->all(),
                'id',
                function ($m) {
                    return $m->user ? $m->user->username : "";
                }
            ),
            ['prompt' => 'Выберите пользователя', 'class' => 'js-monitor'])->label(false)->error(false)?>

    <?php ActiveForm::end()?>

</div>
