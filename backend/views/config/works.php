<?php


use common\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$enabledTechWorks = Settings::get()->enable_tech_works;

$enableNewYear = Settings::get()->enable_new_year;
?>


<div class="clearfix">
    <div class="btn-group pull-left" data-toggle="buttons" data-app-controller="config_works" data-enable-url="<?= Url::toRoute(['enable-works'])?>">
        <label class="btn btn-primary <?= $enabledTechWorks ? 'active' : ''?>">
            <input type="radio" name="enable" value="1" class="js-enable-btn" <?= $enabledTechWorks ? 'checked="checked"' : ''?>> Тех. работы вкл.
        </label>
        <label class="btn btn-primary <?= !$enabledTechWorks ? 'active' : ''?>">
            <input type="radio" name="enable" value="0" class="js-enable-btn" <?= !$enabledTechWorks ? 'checked="checked"' : ''?>> Тех. работы выкл.
        </label>
    </div>


    <div class="btn-group pull-right" data-toggle="buttons" data-app-controller="config_new_year" data-enable-url="<?= Url::toRoute(['enable-new-year'])?>">
        <label class="btn btn-primary <?= $enableNewYear ? 'active' : ''?>">
            <input type="radio" name="enable" value="1" class="js-enable-btn" <?= $enableNewYear ? 'checked="checked"' : ''?>> Новый Год вкл.
        </label>
        <label class="btn btn-primary <?= !$enableNewYear ? 'active' : ''?>">
            <input type="radio" name="enable" value="0" class="js-enable-btn" <?= !$enableNewYear ? 'checked="checked"' : ''?>> Новый Год выкл.
        </label>
    </div>
</div>


<div style="padding-top: 20px">

    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['save']),
    ])?>


    <?= $form->field(Settings::get(), 'text_tech_works')->textInput()?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end()?>

</div>
