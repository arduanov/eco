<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
$true_role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
if(isset($_GET['client'])) $role_id = 2;
?>

<fieldset>
	<div class="js_tabs">
		<? if($module_settings->btn_add>0 || $role_id<2): ?>
			<a href="#add_list4"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<? endif; ?>
		<? if($module_settings->btn_params>0 || $role_id<2): ?>
			<a class="no_js" style="border: none; text-decoration: underline;" href="/admin.php?r=/<?=$this->module_id?>/params/index&page_id=<?=$page_id?>">Параметры</a>
		<? endif; ?>
		<? if($module_settings->export_csv>0): ?>
			<a class="no_js" target="_blank" style="border: none; text-decoration: underline;" href="/admin.php?r=/<?=$this->module_id?>/main/export_csv&page_id=<?=$page_id?>">Экспорт данных в .CSV</a>
		<? endif; ?>
		<? if($module_settings->import_csv>0): ?>
			<a class="no_js" target="_blank" style="border: none; text-decoration: underline;" href="/admin.php?r=/<?=$this->module_id?>/main/import_csv&page_id=<?=$page_id?>">Импорт данных</a>
		<? endif; ?>
		<? if($role_id<2): ?>
			<a class="no_js" style="border: none; text-decoration: underline;" href="/admin.php?r=/<?=$this->module_id?>/msettings/index&page_id=<?=$page_id?>">Настройки</a>
		<? endif; ?>
		<? if($true_role_id<2): ?>
			<? if($role_id<2): ?>
				<a class="no_js" style="border: none; text-decoration: underline;" href="/admin.php?r=pages/update&id=<?=$page_id?>&client=1&/#!/tab_<?=$this->module_id?>">Включить режим «Клиент»</a>
			<? else: ?>
				<a class="no_js" style="border: none; text-decoration: underline;" href="/admin.php?r=pages/update&id=<?=$page_id?>&/#!/tab_<?=$this->module_id?>">Выключить режим «Клиент»</a>
			<? endif; ?>
		<? endif; ?>
		<div class="js_tabs_container row2 cf" id="add_list4"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?'':' style="display:none"'?>>
		
		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-list4-form',
			'action'=>'/admin.php?r=/pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id,
			'enableAjaxValidation'=>false,
		)); ?>
			
			<? if($module_settings->news_type>0): ?>
			<div class="edit_line edit_line_right_date lastLine">
				<?php echo $form->labelEx($model,'date'); ?>
				<div class="inpC dateInpC">
					<input type="text" value="<?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $model->isNewRecord ? date('Y-m-d'):$model->date);?>" id="edit_date_begin" class="inp datepicker2">
				</div>
				<?php echo $form->error($model,'date'); ?>
			</div>
			<div class="edit_line lastLine" style="display:none;">
				<?php echo $form->textField($model,'date', array('id'=>'altDateField2', 'value' => $model->isNewRecord ? date('Y-m-d'):$model->date, 'type'=>"hidden")); ?>
			</div>
			<? endif; ?>
					
			<div class="edit_line">
				<?php echo $form->labelEx($model,'title'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'title',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'title'); ?>
			</div>

            <? if($module_settings->btn_active>0): ?>
			<div class="edit_line checkboxLine">
				<?php echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'':$model->active)); ?>
				<?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
				<?php echo $form->error($model,'active'); ?>
			</div>
            <? endif; ?>

            <? if($module_settings->maps_fields>0): ?>
				<div class="edit_line edit_line_right_date" style="width:50%">
					<?php echo $form->labelEx($model, 'longitude'); ?>
					<div class="inpC">
						<?php echo $form->textField($model, 'longitude', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
					</div>
					<?php echo $form->error($model, 'longitude'); ?>
				</div>
				<div class="edit_line">
					<?php echo $form->labelEx($model, 'latitude'); ?>
					<div class="inpC">
						<?php echo $form->textField($model, 'latitude', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
					</div>
					<?php echo $form->error($model, 'latitude'); ?>
				</div>
            <? endif; ?>

            <? if($module_settings->edit_short>0): ?>
			<div class="edit_line">
				<?php echo $form->labelEx($model,'short', array()); ?>
				<div class="inpC">
					<?php echo $form->textArea($model,'short', array('rows'=> '5', 'class'=>'inp')); ?>
				</div>
				<?php echo $form->error($model,'short'); ?>
			</div>
            <? endif; ?>

            <? if($module_settings->edit_text>0): ?>
			<div class="edit_line">
				<?php echo $form->labelEx($model,'text'); ?>
				<?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
				<?php echo $form->error($model,'text'); ?>
			</div>
            <? endif; ?>

			<? foreach($params_list as $key => $value): ?>
				<? if($role_id<2 || (($key<28 || $key>63) && $key!=25 && $key!=27)): ?>
					<? if($value['data_type_id']==1): ?>
						<div class="edit_line">
							<label for="ModuleList4Values_<?=$value['code']?>" class="required"><?=$value['title']?></label>
							<div class="inpC">
								<input class="inp" size="60" maxlength="255" name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>" type="text" value="<?=$value['default_value']?>">
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==2): ?>
						<div class="edit_line checkboxLine">
							<input id="ytModuleList4Values_<?=$value['code']?>" type="hidden" value="0" name="ModuleList4Values[<?=$value['id']?>]">
							<input name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>" value="1" type="checkbox">
							<label class="labelCheckbox" for="ModuleList4Values_<?=$value['code']?>"><?=$value['title']?></label>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==3): ?>
						<div class="edit_line">
							<label for="ModuleList4Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
							<div class="inpC">
								<textarea rows="5" class="inp" name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>"><?=$value['default_value']?></textarea>
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==4): ?>
						<div class="edit_line">
							<label for="ModuleList4Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
							<textarea class="mceEditor inp" rows="25" name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>"><?=$value['default_value']?></textarea>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==5): ?>
						<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
							<label><strong><?=$value['title']?></strong></label>
							<?
							$params_values = ModuleList4ParamsValues::model()->getList($value['id']);
                            ?>
                            <div class="edit_line checkboxLine">
                                <input name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>0" value="0" type="radio" checked>
                                <label class="labelCheckbox" for="ModuleList4Values_<?=$value['code']?>0">Нет</label>
                            </div>
                            <?
							foreach($params_values as $key2 => $value2):
							?>
								<div class="edit_line checkboxLine">
									<input name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="radio">
									<label class="labelCheckbox" for="ModuleList4Values_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
								</div>
							<? endforeach; ?>
							</div>
					<? endif; ?>
					<? if($value['data_type_id']==6): ?>
						<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
							<label><strong><?=$value['title']?></strong></label>
							<?
							$params_values = ModuleList4ParamsValues::model()->getList($value['id']);
							$i = 0;
							foreach($params_values as $key2 => $value2):
									$i++;
							?>
								<div class="edit_line checkboxLine">
									<input id="ytModuleList4Values_<?=$value['code']?><?=$value2['id']?>" type="hidden" value="0" name="ModuleList4Values[<?=$value['id']?>][<?=$i?>]">
									<input name="ModuleList4Values[<?=$value['id']?>][<?=$i?>]" id="ModuleList4Values_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="checkbox">
									<label class="labelCheckbox" for="ModuleList4Values_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
								</div>
							<? endforeach; ?>
							</div>
					<? endif; ?>
				<? endif; ?>
			<? endforeach; ?>

			<?php echo $form->HiddenField($model,'img_id',array('id'=>'imageList4')); ?>

            <? if($module_settings->edit_img>0): ?>
			<div class="none-upload-drop-area" style="margin-top: 20px;">
				<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id'=>'uploadImageList4',
					'config'=>array(
						'button_text'=>'Загрузить фото',
						'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module_id,
						'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
						'sizeLimit' => '40960000',
						'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImgList4').html('<img src=\'/upload/".md5($this->module_id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#imageList4').val(responseJSON.image_id); $('#delete_smallImgList4').show();}",
					),
				));
				?>
			</div>
			<div id="smallImgList4" class="smallImg">
			</div>
			<span class="delete_image" id="delete_smallImgList4" style="display:none;" data-url="" data-img="smallImgList4" data-input="imageList4">Удалить картинку</span>
            <? endif; ?>
			
			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
			</div>
			<?
			if(Yii::app()->user->hasFlash($this->module_id.'_add_message')){
				echo Yii::app()->user->getFlash($this->module_id.'_add_message');
			}
			?>
		<?php $this->endWidget(); ?>
		</div>
	</div>
	
	<? if($module_settings->ymaps>0): ?>
		<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>

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
<?php elseif(!$model->isNewRecord && isset($model->params['address']) && !empty($model->params['address']['value'])): ?>

					myMap = new ymaps.Map("map", {
						center: [58.0046, 56.2399],
						zoom: 11
					}, {
						balloonMaxWidth: 200
					});



					var myGeocoder = ymaps.geocode('Пермь, <?=$model->params['address']['value']?>');
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

							$("#ModuleList4_latitude").val(coords[0].toPrecision(6));
							$("#ModuleList4_longitude").val(coords[1].toPrecision(6));
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

<? if(count($data) > 0): ?>
	<? foreach($data as $point_id => $point): ?>
		<? if(!is_null($point->latitude) && !empty($point->latitude) && !is_null($point->longitude) && !empty($point->longitude)): ?>
			myPlacemark = new ymaps.Placemark([<?=$point->latitude?>, <?=$point->longitude?>], {
				<?//=(!$point->active)?"style: 'default#bankIcon',":''?>
				style: 'default#bankIcon',
				content: '<?=$point->title?>',
				balloonContent: '<strong><?=$point->title?></strong>'+
					'<br><a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module_id ?>/main/update&page_id=<?=$page_id?>&id=<?=$point->id?>">Редактировать</a>'+
					<? if($point->active==0): ?>
					'<br><a style="color:red;" href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module_id ?>/main/activate&page_id=<?=$page_id?>&id=<?=$point->id?>">Опубликовать</a>'
					<? else: ?>
					'<br><a style="color:#0B0;" href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module_id ?>/main/deactivate&page_id=<?=$page_id?>&id=<?=$point->id?>">Не публиковать</a>'
					<? endif; ?>
					+'<br><a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module_id ?>/main/delete&page_id=<?=$page_id?>&id=<?=$point->id?>" onclick="return confirm(\'Вы уверены, что хотите удалить эту точку с карты?\');">Удалить</a>'
			});
			myMap.geoObjects.add(myPlacemark);
		<? endif; ?>
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
								$("#ModuleList4_latitude").val(coords[0].toPrecision(6));
								$("#ModuleList4_longitude").val(coords[1].toPrecision(6));
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
		
	<? endif; ?>
	
	<?=$pagination?>
	<div class="catalog">
		<?
		if(count($data) > 0): ?>
			<h3><?=(!is_null($module_settings))?$module_settings->title:'Список'?></h3>
			<? if($module_settings->news_type>0): ?>
				<ul class="type_1">
				<? foreach($data as $item_id => $item):?>
					<?
					switch($module_settings->list_view){
						case 1:
							$item->title = $item->title;
							break;
						case 2:
							$item->title = $item->title.', '.$item->short;
							break;
						case 3:
							if(isset($item->params['address']) && !empty($item->params['address']['value']))
								$item->title = $item->title.' ('.$item->params['address']['value'].')';
							break;
					}
					?>
					<li data-id="<?=$item->id?>" class="link ids">
						<? if($module_settings->btn_active>0 || $role_id<2): ?>
							<div class="act_block">
								<? if(!$item->active): ?>
									<a href="/admin.php?r=/<?=$this->module_id?>/main/activate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="activate">Опубликовать</a>
								<? else: ?>
									<a href="/admin.php?r=/<?=$this->module_id?>/main/deactivate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="deactivate">Не публиковать</a>
								<? endif; ?>
							</div>
						<? endif; ?>
						<? if($module_settings->edit_type>0 || $role_id<2): ?>
							<span><?=Yii::app()->dateFormatter->format('d MMMM yyyy', $item->date)?></span>, <a href="/admin.php?r=/<?=$this->module_id?>/main/update&page_id=<?=$page_id?>&id=<?=$item->id?>" class="alert_title"><?=$item->title?></a>
						<? else: ?>
							<span style="font-size: 10px; font-style: italic;"><?=Yii::app()->dateFormatter->format('d MMMM yyyy', $item->date)?></span>, <span class="alert_title"><?=$item->title?></span>
						<? endif; ?>
						<? if($module_settings->btn_delete>0 || $role_id<2): ?>
						&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?=$this->module_id?>/main/delete&page_id=<?=$page_id?>&id=<?=$item->id?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
						<? endif; ?>
						<div class="clear"></div>
					</li>
				<?php endforeach;?>
				</ul>
			<? else: ?>
				<ul class="<?=($module_settings->order_by_title==0 && ($module_settings->btn_order>0 || $role_id<2) && count($data)>1)?'sortable':''?> type_1">
				<? foreach($data as $item_id => $item):?>
					<?
					switch($module_settings->list_view){
						case 1:
							$item->title = $item->title;
							break;
						case 2:
							$item->title = $item->title.', '.$item->short;
							break;
						case 3:
							if(isset($item->params['address']) && !empty($item->params['address']['value']))
								$item->title = $item->title.' ('.$item->params['address']['value'].')';
							break;
					}
					?>
					<li data-id="<?=$item->id?>" class="link ids">
						<? if($module_settings->btn_active>0 || $role_id<2): ?>
							<div class="act_block">
								<? if(!$item->active): ?>
									<a href="/admin.php?r=/<?=$this->module_id?>/main/activate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="activate">Опубликовать</a>
								<? else: ?>
									<a href="/admin.php?r=/<?=$this->module_id?>/main/deactivate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="deactivate">Не публиковать</a>
								<? endif; ?>
							</div>
						<? endif; ?>
						<? if($module_settings->edit_type>0 || $role_id<2): ?>
							<a href="/admin.php?r=/<?=$this->module_id?>/main/update&page_id=<?=$page_id?>&id=<?=$item->id?>" class="alert_title"><?=$item->title?></a>
						<? else: ?>
							<span class="alert_title"><?=$item->title?></span>
						<? endif; ?>
						<? if($module_settings->btn_delete>0 || $role_id<2): ?>
						&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?=$this->module_id?>/main/delete&page_id=<?=$page_id?>&id=<?=$item->id?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
						<? endif; ?>
						<div class="clear"></div>
					</li>
				<?php endforeach;?>
				</ul>
				<? if($module_settings->order_by_title==0 && ($module_settings->btn_order>0 || $role_id<2) && count($data) > 1): ?>
					<form class="sortable_form" method="POST" action="/admin.php?r=pages/update&id=<?=$page_id?>&/#!/tab_<?=$this->module_id?>">
						<input type="hidden" name="type" value="<?=$this->module_id?>">
						<input type="hidden" name="ids" value="">
						<input type="submit" value="Сохранить порядок сортировки" style="margin-bottom:20px;">
					</form>
					<?
					if(Yii::app()->user->hasFlash($this->module_id.'_order_message')){
						echo Yii::app()->user->getFlash($this->module_id.'_order_message');
					}
					?>
				<? endif; ?>
			<? endif; ?>
			<?
			if(Yii::app()->user->hasFlash($this->module_id.'_delete_message')){
				echo Yii::app()->user->getFlash($this->module_id.'_delete_message');
			}
			?>
		<? else:?>
			<p class="empty_data">Ни одного элемента списка пока нет</p>
		<? endif;?>
	</div>
	<?=$pagination?>
</fieldset>