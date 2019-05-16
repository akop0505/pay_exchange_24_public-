<?php

use backend\models\wallets\ArchiveForm;
use common\models\Wallets;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Wallets */

$formModel = new ArchiveForm();

$wallets = Wallets::find()->andWhere(['<>', 'id', $model->id])->andWhere(['<>', 'archived', true])->andWhere(['direction' => $model->direction])->all();
$wallets = ArrayHelper::map($wallets, 'id', 'requisite');
?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['archive', 'id' => $model->id]),
    'enableClientValidation' => false,
]); ?>

<div class="modal-header">
    <h4 class="modal-title pull-left">Архивация кошелька #<?= $model->id?></h4>
    <button type="button" class="modal-default-close close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">

    <?php if ($model->active) {?>

        <b>Кошелек является активным, выберите другой кошелек перед архивацией:</b><br>

        <br>

        <?php if (count($wallets) == 0) {?>
            <?= Html::a('Создать кошелек', Url::toRoute('create'), ['class' => 'btn btn-success'])?>
        <?php } else {?>
            <?= $form->field($formModel, 'newWalletId')->dropDownList($wallets)->label(false) ?>
        <?php } ?>


    <?php } else { ?>

        <b>Архивировать кошелек?</b>

    <?php } ?>

</div>

<div class="modal-footer">
    <?= Html::submitButton('Архивировать', ['class' => 'btn btn-primary js-submit'])?>
</div>

<?php ActiveForm::end()?>

