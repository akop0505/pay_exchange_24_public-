<?php


use common\models\enum\BtcWalletsCreateMode;
use common\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>


<div style="padding-top: 20px">

    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['save']),
        'options' => [
                'enableClientValidation' => false
        ]
    ])?>

    <?= $form->field(Settings::get(), 'enable_btc_static_wallets')->radioList(BtcWalletsCreateMode::getNamesList(), [
            'class' => ''
    ])->label(false)?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end()?>

</div>
