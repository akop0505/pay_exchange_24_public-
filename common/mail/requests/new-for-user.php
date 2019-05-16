<?php

/** @var Request $model */

use common\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;


$lines[] = "Номер заявки: {$model->id}";
$lines[] = "Дата оформления заявки: " . \Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y H:i:s');
$lines[] = "Направление обмена: {$model->currencyFrom->view_name} — {$model->currencyTo->view_name}";

if ($model->send_from) {
    $lines[] = "Вы оплачиваете с карты/кошелька: {$model->send_from}";
}
$lines[] = "Вы переводите сумму: {$model->sum_push} {$model->currencyFrom->currency}";
$lines[] = "Вы получаете на кошелек/номер карты: {$model->send_to}";
$lines[] = "Вы получаете сумму: {$model->sum_pull} {$model->currencyTo->currency}";

if ($model->hash_id) {
    $lines[] = "<br>";
    $urlDetail = Url::toRoute(['form/detail', 'hash' => $model->hash_id], true);
    $lines[] = "Вы можете отслеживать статус заявки по ссылке:";
    $lines[] = Html::a($urlDetail, $urlDetail);
    $lines[] = "<br>";
}

if ($model->ripple_tag && strlen($model->ripple_tag) > 0) {
    $lines[] = "Destination tag: {$model->ripple_tag}";
}

?>


<p>Ваша заявка принята!</p>
<?= join('<br>', $lines)?>
<p>С уважением, администрация сайта <a href="https://<?= Yii::$app->params['domain']?>"><?= Yii::$app->name?></a></p>