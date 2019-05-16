<?php

/** @var bool $isEnable */
/** @var string $from */
/** @var string $to */


?>


<div class="operator-status <?= !$isEnable ? 'operator-status-offline' : ''?>">

    <div class="operator-status__line">

        <div class="operator-status__status">
            Оператор <?= $isEnable ? 'доступен' : 'недоступен'?>
        </div>

        <div class="operator-status__time">
            <span id="js-operator-date"></span> МСК
        </div>

    </div>

    <div class="operator-status__info">Мы обрабатываем заявки с <?= $from?> до <?= $to?> по МСК</div>
</div>

