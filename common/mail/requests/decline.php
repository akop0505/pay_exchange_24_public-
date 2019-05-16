<?php

/** @var Request $model */

use common\models\Request;

?>


<p>Ваша заявка №<?= $model->id?> отклонена.</p>
<b>Причина:</b> оплата не поступила.  <br><br>
<p>С уважением, администрация сайта <a href="https://<?= Yii::$app->params['domain']?>"><?= Yii::$app->name?></a></p>
