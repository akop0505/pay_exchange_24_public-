<?php

/** @var $model Request */

use common\models\enum\RequestStatus;
use common\models\Request;
use yii\bootstrap\Html;
use yii\helpers\Url;


?>


<?php if ($model->done == RequestStatus::DRAFT) {?>

    <?= Html::button('Взять в обработку', [
        'class' => 'btn btn-success btn-xs action-btn js-take',
        'data-url' => Url::toRoute(['requests/take', 'id' => $model->id])
    ])?>

    <?= Html::button('Отклонить', [
        'class' => 'btn btn-danger btn-xs action-btn js-decline-form-caller',
        'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'decline-form']),
    ])?>

<?php } else if ($model->done == RequestStatus::NEW_CREATED) {?>

    <?= Html::button('Выполнить', [
        'class' => 'btn btn-success btn-xs action-btn js-complete-form-caller',
        'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'complete-form']),
    ])?>

    <?= Html::button('Отклонить', [
        'class' => 'btn btn-danger btn-xs action-btn js-decline-form-caller',
        'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'decline-form']),
    ])?>

<?php } else if ($model->done == RequestStatus::COMPLETE) {?>

    <?= Html::button('Отклонить', [
        'class' => 'btn btn-danger btn-xs action-btn js-decline-form-caller',
        'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'decline-form']),
    ])?>

<?php } else if ($model->done == RequestStatus::DECLINE) {?>

    <?= Html::button('Выполнить', [
        'class' => 'btn btn-success btn-xs action-btn js-complete-form-caller',
        'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'complete-form']),
    ])?>

<?php }?>