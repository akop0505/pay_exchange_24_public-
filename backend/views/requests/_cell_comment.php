<?php

/** @var $model Request */

use common\models\Request;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\helpers\Url;


?>


<?= Html::encode($model->email)?>
<?php if ($model->description) {?>
    <br>Комменатрий: <i><?= Html::encode($model->description )?></i>
<?php }?>

<br><?= Html::button('Комментарий', [
    'class' => 'btn btn-default btn-xs js-comment-form-caller',
    'data-url' => Url::toRoute(['get-form', 'id' => $model->id, 'form' => 'comment-form']),
])?>
