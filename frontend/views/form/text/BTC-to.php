<?php


/** @var $model Request */

use common\models\Request;

?>

<div class="text-block">
    После выполнения заявки с нашей стороны биткоины могут отобразиться на Вашем кошельке не сразу. Это полностью
    зависит от той платформы, на которую Вы совершаете перевод. Иногда для отображения средств на счету транзакция
    должна получить подтверждения сети. Состояние адреса на предмет поступления средств и подтверждений можете
    отслеживать по этой ссылке:
</div>

<div class="text-block">
    <a target="_blank"
       href="https://www.blockchain.com/btc/address/<?= $model->send_to ?>">https://www.blockchain.com/btc/address/<?= $model->send_to ?></a>
</div>
