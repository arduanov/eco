<? $stats['sql'] = Yii::app()->db->getStats(); ?>
<div style="
    position: fixed;
    height: 20px;
    right: 0;
    top: 0;
    background-color: #AAA;
    -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)';
	filter:alpha(opacity=50);
	-moz-opacity:0.5;
	-khtml-opacity: 0.5;
	opacity: 0.5;
	z-index: 100;
	">
    <strong>БД</strong>&nbsp;Запросов: <?=$stats['sql'][0]?>&nbsp;Время: <?=sprintf('%0.5f',$stats['sql'][1])?>c.&nbsp;<strong>Скрипт</strong>&nbsp;Время:&nbsp;<?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?>с.&nbsp;Память:&nbsp;<?=round(memory_get_peak_usage()/(1024*1024),2)."MB"?>
</div>