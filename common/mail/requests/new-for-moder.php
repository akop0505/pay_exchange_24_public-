<?php

/** @var Request $model */

use common\models\Request;


$lines[] = "Номер заявки: {$model->id}";
$lines[] = "Дата оформления заявки: " . \Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y H:i:s');
$lines[] = "Направление обмена: {$model->currencyFrom->view_name} — {$model->currencyTo->view_name}";
$lines[] = "Email клиента: {$model->email}";

if ($model->send_from) {
    $lines[] = "Откуда придет кошелек/карта: {$model->send_from}";
}
if ($model->fio_to) {
    $lines[] = "От кого: {$model->fio_to}";
}
$lines[] = "Сколько придет: {$model->sum_push} {$model->currencyFrom->currency}";

$lines[] = "Куда отправить: {$model->send_to}";
$lines[] = "Сколько: {$model->sum_pull} {$model->currencyTo->currency}";

if ($model->ripple_tag && strlen($model->ripple_tag) > 0) {
    $lines[] = "Destination tag: {$model->ripple_tag}";
}
?>


<p><strong>Новая заявка!</strong></p>
<?= join('<br>', $lines)?>
<p>Да поможет нам Бог!</p>