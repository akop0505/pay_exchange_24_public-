<?php

use common\services\ScheduleService;
use yii\helpers\BaseHtml;

$checked = ScheduleService::create()->getCheckedItem();

echo BaseHtml::beginForm('shedule', 'post');
echo BaseHtml::radioList( 
	"mode",
	$checked, 
	[1=>"Автоматическое расписание",2=>"Онлайн",3=>"Оффлайн"], 
	["separator"=>"<br/>"]
	);
echo BaseHtml::submitButton('Сохранить');
echo BaseHtml::endForm();