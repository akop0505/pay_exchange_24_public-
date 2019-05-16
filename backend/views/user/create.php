<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Добавить пользователя');
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]);
?>

<?= $form
    ->field($model, 'username')
    ->textInput(['placeholder' => $model->getAttributeLabel('username')]) 
    ?>

<?= $form
    ->field($model, 'email')
    ->textInput(['placeholder' => $model->getAttributeLabel('email')]) 
    ?>

       
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'save-button']) ?>

<?php ActiveForm::end(); ?>