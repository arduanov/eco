<div id="importCsvSteps">
    <h1>Обновить цены</h1>
	
	<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
	array(
		'id'=>'uploadImageAccessories',
		'config'=>array(
			'button_text'=>'Загрузить файл с ценами',
			'action'=>'/admin.php?r=/importcsv/default/updatePrices/',
			'allowedExtensions'=>array('csv'),
			'sizeLimit' => '40960000',
			'onComplete'=>"js:function(id, fileName, responseJSON){ $('#csv_message').html(responseJSON.message); }",
		),
	));
	?>	
	
	<div id="csv_message"><?=$message?></div>
	<? if(!empty($log)): ?>
    <h2>Log</h2>
	<p><i><?=$log?></i></p>
	<? endif; ?>
</div>