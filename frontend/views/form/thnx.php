<?php

use frontend\models\Bids;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model Bids */

$this->pageTitle = 'Спасибо!';


?>



<div class="main-content">


    <div class=" confirm-thnx">

        <div class="modal-content">
            <div class="icon"></div>
            <div class="caption">
                <?php if ($model->currencyFrom->isBTC() == 'BTC') {?>
                    Заявка будет обработана в течение 30 минут с момента получения 1го подтверждения сети
                <?php } else {?>
                    Заявка будет обработана в течение 30 минут
                <?php } ?>
            </div>
        </div>

        <div class="modal-footer">
            <a class="submit-btn waves-effect waves-light btn-large" onclick="location = '/'">OK</a>
        </div>

    </div>

</div>
