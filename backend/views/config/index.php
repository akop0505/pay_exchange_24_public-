<?php

/** @var Settings $model */

use common\models\Settings;

?>

<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#schedule" data-toggle="tab">Расписание</a></li>
    <li><a href="#works" data-toggle="tab">Технические работы</a></li>
    <li><a href="#wallets" data-toggle="tab">Кошельки</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

    <div class="tab-pane active" id="schedule">

        <div class="panel panel-default panel-tabs">
            <div class="panel-body">
                <?= $this->render('schedule');?>
            </div>
        </div>

    </div>

    <div class="tab-pane" id="works">

        <div class="panel panel-default panel-tabs">
            <div class="panel-body">
                <?= $this->render('works');?>
            </div>
        </div>

    </div>


    <div class="tab-pane" id="wallets">

        <div class="panel panel-default panel-tabs">
            <div class="panel-body">
                <?= $this->render('wallets');?>
            </div>
        </div>

    </div>

</div>



