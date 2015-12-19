<h1 class="pTitle">Карта: «<?= $model->title ?>»</h1>
<div class="actionsList">
	&larr; <a href="<?= Yii::app()->baseUrl; ?>?r=pages/update&id=<?= $page_id; ?>&/#!/tab_<?= $this->module->id ?>">Назад к редактированию страницы</a>
	&darr; <a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/settings&page_id=<?= $page_id; ?>&id=<?= $model->id ?>">Настройки категории</a>
</div>

<?
$category_id = $model->id;
$model = new ModuleGmaps();
?>

<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>

<div class="form">


    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>


	<fieldset>
		<div class="js_tabs">
			<a href="#add_gmaps"<?= (Yii::app()->user->hasFlash('message')) ? ' class="active"' : '' ?>>Добавить точку на карту</a>
			<div class="js_tabs_container row2 cf" id="add_gmaps"<?= (Yii::app()->user->hasFlash('message')) ? '' : ' style="display:none"' ?>>
				
				<?php
				$form = $this->beginWidget('CActiveForm', array(
					'id' => 'module-product-form',
					'enableAjaxValidation' => false,
						));
				?>

				<?php echo $form->errorSummary($model); ?>
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
							<label for="ModuleGmapsParams_<?=$value['code']?>" class="required"><?=$value['title']?></label>
							<div class="inpC">
								<input class="inp" size="60" maxlength="255" name="ModuleGmapsParams[<?=$value['id']?>]" id="ModuleGmapsParams_<?=$value['code']?>" type="text" value="<?=$value['default_value']?>">
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==2): ?>
						<div class="edit_line checkboxLine">
							<input id="ytModuleGmapsParams_<?=$value['code']?>" type="hidden" value="0" name="ModuleGmapsParams[<?=$value['id']?>]">
							<input name="ModuleGmapsParams[<?=$value['id']?>]" id="ModuleGmapsParams_<?=$value['code']?>" value="1" type="checkbox">
							<label class="labelCheckbox" for="ModuleGmapsParams_<?=$value['code']?>"><?=$value['title']?></label>
						</div>
					<? endif; ?>
				<? endforeach; ?>

				<?
				if(Yii::app()->user->hasFlash('message')){
					echo Yii::app()->user->getFlash('message');
				}
				?>


				<div style="display: none;">
					<?php echo $form->textField($model, 'mpage_id', array('value' => ModulesInPages::model()->getLink($page_id, $this->module->id))); ?>
				</div>

				<div class="row buttons">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
				</div>

				<?php $this->endWidget(); ?>
				
			</div>
		</div>


    <div class="catalog">
		<h3>Карта</h3>
		<div id="map" style="margin-top: 20px; width: 800px; height: 400px"></div>

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

							$("#ModuleGmaps_latitude").val(coords[0].toPrecision(6));
							$("#ModuleGmaps_longitude").val(coords[1].toPrecision(6));
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
					/*if ($('#ModuleGmaps_category_id option:selected').val()!=0){
						var ab=ymaps.geocode($('#ModuleGmaps_category_id option:selected').text());
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

<? if(count($point_list) > 0): ?>
	<? foreach($point_list as $point_id => $point): ?>
		myPlacemark = new ymaps.Placemark([<?=$point['latitude']?>, <?=$point['longitude']?>], {
				<?//=(!$point['active'])?"style: 'default#bankIcon',":''?>
				style: 'default#bankIcon',
				content: '<?=$point['title']?>',
				balloonContent: '<strong><?=$point['title']?></strong>'+
					'<br><a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/show&page_id=<?=$page_id?>&id=<?=$point['id']?>">Редактировать</a>'+
					<? if($point['active']==0): ?>
					'<br><a style="color:red;" href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/activate_point&page_id=<?=$page_id?>&category_id=<?=$category_id?>&id=<?=$point['id']?>">Опубликовать</a>'
					<? else: ?>
					'<br><a style="color:#0B0;" href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/deactivate_point&page_id=<?=$page_id?>&category_id=<?=$category_id?>&id=<?=$point['id']?>">Не публиковать</a>'
					<? endif; ?>
					+'<br><a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/delete_point&page_id=<?=$page_id?>&category_id=<?=$category_id?>&id=<?=$point['id']?>" onclick="return confirm(\'Вы уверены, что хотите удалить эту точку с карты?\');">Удалить</a>'
			});
			myMap.geoObjects.add(myPlacemark);
	<? endforeach; ?>
<? endif; ?>

					myMap.events.add('click', function (e) {
						if (!myMap.balloon.isOpen()) {
							var coords = e.get('coordPosition');
							var names = [];
							ymaps.geocode(coords).then(function (res) {
								res.geoObjects.each(function (obj) {
									names.push(obj.properties.get('name'));
								});
								$("#ModuleGmaps_latitude").val(coords[0].toPrecision(6));
								$("#ModuleGmaps_longitude").val(coords[1].toPrecision(6));
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
		
	
		<?
		if(count($point_list) > 0):
			?>
			<h3>Список точек</h3>
			<ul class="type_1">
				<? foreach($point_list as $point_id => $point): ?>
					<li data-id="<?= $point->id ?>" class="link ids">
						<div class="act_block">
							<? if(!$point->active): ?>
								<a href="/admin.php?r=/<?= $this->module->id ?>/main/activate_point&page_id=<?= $page_id ?>&category_id=<?=$category_id?>&id=<?= $point->id ?>" class="activate">Опубликовать</a>
							<? else: ?>
								<a href="/admin.php?r=/<?= $this->module->id ?>/main/deactivate_point&page_id=<?= $page_id ?>&category_id=<?=$category_id?>&id=<?= $point->id ?>" class="deactivate">Не публиковать</a>
							<? endif; ?>
						</div>
						<a href="/admin.php?r=/<?= $this->module->id ?>/main/show&page_id=<?= $page_id ?>&id=<?= $point->id ?>" class="alert_title"><?= $point->title ?></a>&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?= $this->module->id ?>/main/delete_point&page_id=<?= $page_id ?>&category_id=<?=$category_id?>&id=<?= $point->id ?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
						<div class="clear"></div>
					</li>
				<?php endforeach; ?>
			</ul>
			<?
			if(Yii::app()->user->hasFlash($this->module->id.'_delete_message')){
				echo Yii::app()->user->getFlash($this->module->id.'_delete_message');
			}
			?>
		<? else: ?>
			<p class="empty_data">Ни одной точки пока нет</p>
		<? endif; ?>
    </div>
	
	</fieldset>

</div><!-- form -->