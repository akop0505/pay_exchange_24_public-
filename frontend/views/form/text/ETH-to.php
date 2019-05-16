<?php


/** @var $model Request */

use common\models\Request;

?>

<div class="text-block">
После выполнения заявки с нашей стороны эфириумы могут отобразиться на Вашем кошельке не сразу. Это полностью зависит от той платформы, на которую Вы совершаете перевод. Иногда для отображения средств на счету транзакция должна получить подтверждения сети. Состояние адреса на предмет поступления средств и подтверждений можете отслеживать по этой ссылке:
</div>

<div class="text-block">
    <a href="https://etherscan.io/address/<?= $model->send_to?>">https://etherscan.io/address/<?= $model->send_to?></a>
</div>
