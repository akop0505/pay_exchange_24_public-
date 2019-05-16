<?php

$this->pageTitle = 'Заявка отменена';

?>

<div class="main-content">

    <div class="confirm-bid">

    <div class="confirm-attention">Заявка отменена</div>

    <div class="confirm-attention-caption">
        Время подтверждения заявки вышло
    </div>

    <div class="confirm-body-wrap">

        <div class="confirm-body">
            <div class="confirm-decline">
                Заявка <span>№ <?= $model->id ?></span> отменена
            </div>


            <div class="confirm-buttons">
                <a href="/" class="confirm-buttons__back waves-effect waves-light">На главную</a>
            </div>
        </div>

    </div>

</div>
</div>