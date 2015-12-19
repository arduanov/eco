<h1 class="pTitle">Точка на карте: «<?= $model->title ?>»</h1>
<div class="actionsList">
	&larr; <a href="<?= Yii::app()->baseUrl; ?>?r=pages/update&id=<?= $page_id; ?>&/#!/tab_<?= $this->module->id ?>">Назад к редактированию страницы</a>
	&larr; <a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/update&page_id=<?= $page_id; ?>&id=<?= $model->category_id ?>">Назад к категории</a>
</div>

<?

?>

<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'module-product-form',
		'enableAjaxValidation' => false,
			));
	?>

    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
		<div class="row2 cf">
			<div class="edit_line">
				<?php echo $form->labelEx($model,'title'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'title',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'title'); ?>
			</div>
			<div class="edit_line edit_line_right_date" style="width:50%">
				<?php echo $form->labelEx($model, 'longitude'); ?>
				<div class="inpC">
					<?php echo $form->textField($model, 'longitude', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
				</div>
				<?php echo $form->error($model, 'longitude'); ?>
			</div>
			<div class="edit_line lastLine">
				<?php echo $form->labelEx($model, 'latitude'); ?>
				<div class="inpC">
					<?php echo $form->textField($model, 'latitude', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
				</div>
				<?php echo $form->error($model, 'latitude'); ?>
			</div>
			<div class="edit_line checkboxLine">
				<?php echo $form->checkBox($model,'active'); ?>
				<?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
				<?php echo $form->error($model,'active'); ?>
			</div>
			
			<? foreach($params_list as $key => $value): ?>
				<? if($value['data_type_id']==1): ?>
					<div class="edit_line">
						<label for="ModuleYmapsParams_<?=$value['code']?>" class="required"><?=$value['title']?></label>
						<div class="inpC">
							<input class="inp" size="60" maxlength="255" name="ModuleYmapsParams[<?=$value['id']?>]" id="ModuleYmapsParams_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
						</div>
					</div>
				<? endif; ?>
				<? if($value['data_type_id']==2): ?>
					<div class="edit_line checkboxLine">
						<input id="ytModuleYmapsParams_<?=$value['code']?>" type="hidden" value="0" name="ModuleYmapsParams[<?=$value['id']?>]">
						<input name="ModuleYmapsParams[<?=$value['id']?>]" id="ModuleYmapsParams_<?=$value['code']?>" value="1" type="checkbox" <?=(isset($params_values_list[$value['id']]) && $params_values_list[$value['id']]['value']==1)?'checked':''?>>
						<label class="labelCheckbox" for="ModuleYmapsParams_<?=$value['code']?>"><?=$value['title']?></label>
					</div>
				<? endif; ?>
				<? if($value['data_type_id']==7): ?>
					<? $sufix_id = $this->module->id.'_'.$value['id']?>
					<input id="image_<?=$sufix_id?>" type="hidden" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>" name="ModuleYmapsParams[<?=$value['id']?>]" id="image_<?=$sufix_id?>">
					<div class="none-upload-drop-area" style="margin-top: 20px;">
						<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
						array(
							'id'=>'upload_'.$sufix_id,
							'config'=>array(
								'button_text'=>$value['title'],
								'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id,
								'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
								'sizeLimit' => '40960000',
								'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg_".$sufix_id."').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#image_".$sufix_id."').val(responseJSON.image_id); $('#delete_smallImg_".$sufix_id."').show();}",
							),
						));
						?>
					</div>
					<div id="smallImg_<?=$sufix_id?>" class="smallImg">
						<? if(count($params_values_list[$value['id']]->img)): ?>
	                       <img src="<?=$params_values_list[$value['id']]->img[1]?>">
	                    <?endif;?>
					</div>
					<span class="delete_image" id="delete_smallImg_<?=$sufix_id?>" <?=(count($params_values_list[$value['id']]->img))?'':'style="display:none;"'?> data-url="" data-img="smallImg_<?=$sufix_id?>" data-input="image_<?=$sufix_id?>">Удалить изображение</span>
				<? endif; ?>
			<? endforeach; ?>
		</div>


		<div id="map" style="width: 800px; height: 400px"></div>

		<script type="text/javascript">
			
			$(document).ready(function(){

				function module_ymaps_init() {


<?php if(!$model->isNewRecord && !empty($model->longitude) && !empty($model->latitude)): ?>

					myMap = new ymaps.Map("map", {
						center: [<?php echo $model->latitude; ?>, <?php echo $model->longitude; ?>], // Красное-на-Волге
						zoom: 14
					}, {
						balloonMaxWidth: 200
					});


					myGeoObject = new ymaps.GeoObject({
						geometry: {
							type: "Point",
							coordinates: [<?php echo $model->latitude; ?>, <?php echo $model->longitude; ?>]
						}
					});

					myMap.geoObjects.add(myGeoObject);
<?php elseif(!$model->isNewRecord && !empty($model->address)): ?>

					myMap = new ymaps.Map("map", {
						center: [58.0046, 56.2399],
						zoom: 11
					}, {
						balloonMaxWidth: 200
					});



					var myGeocoder = ymaps.geocode('Пермь, <?php echo $model->address; ?>');
					myGeocoder.then(
					function (res) {
						var coords = res.geoObjects.get(0).geometry.getCoordinates();
						var myGeocoder = ymaps.geocode(coords, {kind: 'house'});
						myGeocoder.then(
						function (res) {
							var street = res.geoObjects.get(0);
							var name = street.properties.get('name');
							findMyGeoObject = new ymaps.GeoObject({
								geometry: {
									type: "Point",
									coordinates: [coords[0].toPrecision(6), coords[1].toPrecision(6)]
								}
							});
							myMap.geoObjects.add(findMyGeoObject);

							$("#ModuleYmaps_latitude").val(coords[0].toPrecision(6));
							$("#ModuleYmaps_longitude").val(coords[1].toPrecision(6));
						}
					);
					});


<?php else: ?>
					myMap = new ymaps.Map("map", {
						center: [58.0046, 56.2399],
						zoom: 11
					}, {
						balloonMaxWidth: 200
					});
					/*if ($('#ModuleYmaps_category_id option:selected').val()!=0){
						var ab=ymaps.geocode($('#ModuleYmaps_category_id option:selected').text());
						ab.then(
							function(res){
								myMap.setCenter(res.geoObjects.get(0).geometry.getCoordinates(),11);
							}
						);
					} else {
						myMap.setCenter([58.0046, 56.2399],5);
					}*/
<?php endif; ?>

					myMap.controls.add('zoomControl', { top: 5, left: 5 });

<? foreach($point_list as $point_id => $point): ?>
	 myPlacemark = new ymaps.Placemark([<?=$point['latitude']?>, <?=$point['longitude']?>], {
			<?//=(!$point['active'])?"style: 'default#bankIcon',":''?>
			style: 'default#bankIcon',
            content: '<?=$point['title']?>',
            balloonContent: '<strong><?=$point['title']?></strong>'+
				'<br><a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/show&page_id=<?=$page_id?>&id=<?=$point['id']?>">Редактировать</a>'
        });
		myMap.geoObjects.add(myPlacemark);
<? endforeach; ?>

					myMap.events.add('click', function (e) {
						if (!myMap.balloon.isOpen()) {
							var coords = e.get('coordPosition');
							var names = [];
							ymaps.geocode(coords).then(function (res) {
								res.geoObjects.each(function (obj) {
									names.push(obj.properties.get('name'));
								});
								$("#ModuleYmaps_latitude").val(coords[0].toPrecision(6));
								$("#ModuleYmaps_longitude").val(coords[1].toPrecision(6));
							});
							myMap.balloon.open(coords, {
								contentHeader: 'Новые координаты !',
								contentBody: '<p style="color: red;">Отмечено новое местоположение объекта.</p>'+
									'<p>Координаты: ' + [
									coords[0].toPrecision(6),
									coords[1].toPrecision(6)
								].join(', ') + '</p>',
								contentFooter: '<sup>Щелкните еще раз чтобы выбрать другие координаты</sup>'
							});
						} else {
							myMap.balloon.close();
						}
					});
					myMap.events.add('contextmenu', function (e) {
						myMap.hint.show(e.get('coordPosition'), 'Кто-то щелкнул правой кнопкой');
					});
				}
			//module_ymaps_init();
			
    ymaps.ready(module_ymaps_init);
	var myMap,
        myPlacemark;
			});
		</script>
	</fieldset>


    <div style="display: none;">
		<?php echo $form->textField($model, 'mpage_id', array('value' => ModulesInPages::model()->getLink($page_id, $this->module->id))); ?>
    </div>

    <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

	<?
	if(Yii::app()->user->hasFlash('message')){
		echo Yii::app()->user->getFlash('message');
	}
	?>

	<?php $this->endWidget(); ?>

</div><!-- form -->