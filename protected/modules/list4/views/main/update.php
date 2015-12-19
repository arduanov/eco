<? $role_id = 2; ?>

<h1 class="pTitle">Редактирование «<?=$model->title?>»</h1>
<div class="actionsList">
	&larr; <a href="<?=Yii::app()->baseUrl; ?>?r=pages/update&id=<?=$page_id;?>&/#!/tab_<?=$this->module->id?>">Назад к редактированию страницы</a>
</div>

<div class="form">

    <?
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'page-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('class'=>'list4_form','enctype'=>'multipart/form-data','data-action'=>$_SERVER['REQUEST_URI'])
	));
	?>

    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>

    <? echo $form->errorSummary($model); ?>

			<?
			$additional_count = 0;
			foreach($params_list as $key => $value){
				if(in_array($value['data_type_id'],array(1,2,3,4,5,6,9))) $additional_count++;
			}
			?>
    <div class="tabs">
        <!-- Это сами вкладки -->
        <ul class="cf tabNavigation">
            <li class="tab_st"><a href="#first">Основные параметры</a></li>
			<? if($additional_count>0): ?>
				<li class="tab_st"><a href="#second">Дополнительные параметры</a></li>
			<? endif; ?>
            <? /*if($page_id == 37): ?><li class="tab_st"><a href="#third">Файлы</a></li><? endif;*/ ?>
			<? foreach($params_list as $key => $value): ?>
				<? if($value['data_type_id']==8): ?>
					<li class="tab_st"><a href="#param_<?=$value['id']?>"><?=$value['title']?></a></li>
				<? endif; ?>
			<? endforeach; ?>
        </ul>
        <!-- Это контейнеры содержимого -->
        <div id="first">
			
            <fieldset>
                <div class="row2 cf">

			<? if($module_settings->news_type>0): ?>
                    <div class="edit_line edit_line_right_date lastLine">
                        <? echo $form->labelEx($model,'date'); ?>
                        <div class="inpC dateInpC">
                            <input type="text" value="<? echo Yii::app()->dateFormatter->format('d MMMM yyyy', $model->isNewRecord ? date('Y-m-d'):$model->date);?>" id="edit_date_begin" class="inp datepicker2">
                        </div>
                        <? echo $form->error($model,'date'); ?>
                    </div>
                    <div class="edit_line lastLine" style="display:none;">
                        <? echo $form->textField($model,'date', array('id'=>'altDateField2', 'value' => $model->isNewRecord ? date('Y-m-d'):$model->date, 'type'=>"hidden")); ?>
                    </div>
			<? endif; ?>
			
                    <div class="edit_line">
                        <? echo $form->labelEx($model,'title'); ?>
                        <div class="inpC">
                            <? echo $form->textField($model,'title',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <? echo $form->error($model,'title'); ?>
                    </div>


            <? if($module_settings->btn_active>0): ?>
                    <div class="edit_line checkboxLine">
                        <? echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'checked':$model->active)); ?>
                        <? echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
                        <? echo $form->error($model,'active'); ?>
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
		                <? echo $form->labelEx($model,'short', array()); ?>
		                <div class="inpC">
		                    <? echo $form->textArea($model,'short', array('rows'=> '5', 'class'=>'inp')); ?>
		                </div>
		                <? echo $form->error($model,'short'); ?>
		            </div>
                    <? endif; ?>


                    <? if($module_settings->edit_text>0): ?>
                	<div class="edit_line">
		                <? echo $form->labelEx($model,'text'); ?>
		                <? echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
		                <? echo $form->error($model,'text'); ?>
		            </div>
                    <? endif; ?>

                    <? echo $form->HiddenField($model,'img_id',array('id'=>'smallImage')); ?>
                    <? if($module_settings->edit_img>0): ?>
	                <div style="margin-top: 20px;">
	                    <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
	                    array(
	                        'id'=>'uploadSmallImage',
	                        'config'=>array(
	                            'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id,
	                            'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
	                    		'button_text' => 'Загрузить изображение',
	                            'sizeLimit' => '40960000',
	                            'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#smallImage').val(responseJSON.image_id); $('.delete_image').show();}",
	                        ),
	                    ));
	                    ?>
	                </div>

	                <div id='smallImg'>
						<? if(count($model->img)): ?>
	                       <img src="<?=$model->img[1]?>">
	                    <?endif;?>
	                </div>
					<span class="delete_image" <?=($model->img_id)?'':'style="display:none;"'?> data-url="" data-img="smallImg" data-input="smallImage">Удалить картинку</span>
                    <? endif; ?>
					
	            </div>
				
				
	<? if($module_settings->ymaps>0): ?>
		<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>

		<h3>Карта</h3>

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

<?
$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
$data = ModuleList4::model()->getList($mpage_id);
?>
<? foreach($data as $point_id => $point): ?>
	<? if(!is_null($point->latitude) && !empty($point->latitude) && !is_null($point->longitude) && !empty($point->longitude)): ?>
		myPlacemark = new ymaps.Placemark([<?=$point->latitude?>, <?=$point->longitude?>], {
			<?//=(!$point->active)?"style: 'default#bankIcon',":''?>
			style: 'default#bankIcon',
            content: '<?=$point->title?>',
            balloonContent: '<strong><?=$point->title?></strong>'+
				'<br><a href="<?= Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/update&page_id=<?=$page_id?>&id=<?=$point->id?>">Редактировать</a>'
        });
		myMap.geoObjects.add(myPlacemark);
	<? endif; ?>
<? endforeach; ?>

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
				
				
				
            </fieldset>
		</div>
        <div id="second">
            <fieldset>
			<? foreach($params_list as $key => $value): ?>
					<? if($value['data_type_id']==1): ?>
						<div class="edit_line">
							<label for="ModuleList4Values_<?=$value['code']?>" class="required"><?=$value['title']?></label>
							<div class="inpC">
								<input class="inp" size="60" maxlength="255" name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==2): ?>
						<div class="edit_line checkboxLine">
							<input id="ytModuleList4Values_<?=$value['code']?>" type="hidden" value="0" name="ModuleList4Values[<?=$value['id']?>]">
							<input name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>" value="1" type="checkbox" <?=(isset($params_values_list[$value['id']]) && $params_values_list[$value['id']]['value']==1)?'checked':''?>>
							<label class="labelCheckbox" for="ModuleList4Values_<?=$value['code']?>"><?=$value['title']?></label>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==3): ?>
						<div class="edit_line">
							<label for="ModuleList4Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
							<div class="inpC">
								<textarea rows="5" class="inp" name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>"><?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?></textarea>
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==4): ?>
						<div class="edit_line">
							<label for="ModuleList4Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
							<textarea class="mceEditor inp" rows="25" name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?>"><?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?></textarea>
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
									<input name="ModuleList4Values[<?=$value['id']?>]" id="ModuleList4Values_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="radio" <?=(isset($params_values_list[$value['id']]) && $params_values_list[$value['id']]['value']==$value2['id'])?'checked':''?>>
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
									$exist_params_values = ModuleList4Values::model()->exist_value($model->id, $value['id'], $value2['id']);
							?>
								<div class="edit_line checkboxLine">
									<input id="ytModuleList4ValuesMultiply_<?=$value['code']?><?=$value2['id']?>" type="hidden" value="0" name="ModuleList4ValuesMultiply[<?=$value['id']?>][<?=$i?>]">
									<input name="ModuleList4ValuesMultiply[<?=$value['id']?>][<?=$i?>]" id="ModuleList4ValuesMultiply_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="checkbox" <?=($exist_params_values)?'checked':''?>>
									<label class="labelCheckbox" for="ModuleList4ValuesMultiply_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
								</div>
							<? endforeach; ?>
							</div>
					<? endif; ?>
					<? if($value['data_type_id']==7): ?>
						<? $sufix_id = $this->module->id.'_'.$value['id']?>
						<input id="image_<?=$sufix_id?>" type="hidden" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>" name="ModuleList4Values[<?=$value['id']?>]" id="image_<?=$sufix_id?>">
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
					<? if($value['data_type_id']==9):
                        $settings = unserialize($value->settings);
                    ?>
						<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
							<label><strong><?=$value['title']?></strong></label>
                            <? if($page_id==99): ?>
                                <div class="search_form" data-id="only_checked_div_<?=$value['id']?>">
                                    <div class="edit_line">
                                        <label for="ModuleList4_title" class="required">Поиск</label>
                                        <div class="inpC">
                                            <input class="inp" size="60" maxlength="255" type="text">
                                        </div>
                                    </div>
                                    <button type="button">Найти</button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="edit_line checkboxLine">
                                    <label for="only_checked_<?=$value['id']?>" class="labelCheckbox only_checked">
                                        <input id="only_checked_<?=$value['id']?>" type="checkbox" data-id="only_checked_div_<?=$value['id']?>">
                                        <strong><i>Только объекты этой категории</i></strong>
                                    </label>
                                </div>
                            <? endif; ?>
                            <div style="padding: 5px; height: 400px; overflow-y: auto;" id="only_checked_div_<?=$value['id']?>">
							<?
							$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
							$list = ModuleList4Settings::model()->getList($mpage_id);
							$params_values = ModuleList4ParamsList4::model()->getList($value['id']);
                            ?><table><tr><thead><tr><th></th><th><?=$settings['text1'] !== false ? $settings['text1label'] : ''?></th></tr></te></thead>
							<? if(($settings['type'] !== false)): ?>
							<tr>
								<td>
									<div class="edit_line checkboxLine">
										<input name="ModuleList4List4[<?=$value['id']?>]" id="ModuleList4List4_<?=$value['id']?>_0" value="0" type="radio" checked>
										<label class="labelCheckbox" for="ModuleList4List4_<?=$value['id']?>_0"><i>Нет</i></label>&nbsp;
									</div>
								</td>
							</tr>
							<? endif; ?>
							<?
                            foreach($params_values as $mpage_ids){
								$params_values2 = ModuleList4List4::model()->getList($model->id);
								$list4 = ModuleList4::model()->getList($mpage_ids);
                                foreach($list4 as $l3){
                                    $params_text = ModuleList4List4::model()->getText($l3->id,$model->id);
								?>
									<tr>
										<td>
											<div class="edit_line checkboxLine">
												<? if(($settings['type'] === false)): ?>
													<input name="ModuleList4List4[<?=$value['id']?>][<?=$l3->id?>]" id="ytModuleList4List4_<?=$value['id']?>_<?=$l3->id?>" value="0" type="hidden">
													<input name="ModuleList4List4[<?=$value['id']?>][<?=$l3->id?>]" id="ModuleList4List4_<?=$value['id']?>_<?=$l3->id?>" value="<?=$l3->id?>" type="checkbox" <?=(in_array($l3->id,$params_values2))?'checked':''?>>
												<? else: ?>
													<input name="ModuleList4List4[<?=$value['id']?>]" id="ModuleList4List4_<?=$value['id']?>_<?=$l3->id?>" value="<?=$l3->id?>" type="radio" <?=(in_array($l3->id,$params_values2))?'checked':''?>>
												<? endif; ?>
												<label class="labelCheckbox" for="ModuleList4List4_<?=$value['id']?>_<?=$l3->id?>"><?=$l3->title?><?=($page_id==99)?' ('.$l3->params['address']['value'].')':''?></label>&nbsp;
											</div>
                                        </td>
                <?
                if ($settings['text1'] !== false) {
                    ?>
                    <td>
                    <div class="inpC">
                        <input name="ModuleList4List4Text[<?=$value['id']?>][<?=$l3->id?>]" id="ytModuleList4List4_<?=$l3->id?>" value="<?=$params_text?>" type="text" class="inp">
                    </div>
                        </td>
                <?
                }
                                    ?></tr><?
			}
		}
				?></table>
                            </div>
						</div>
					<? endif; ?>
			<? endforeach; ?>
            </fieldset>
        </div>
        <div id="third">
            <fieldset>
                <div class="row2 cf">
                    <div style="margin-top: 20px;">
                        <div class="catalog">
                        <?
                        if (!$files) {
                            ?> <h3>Нет файлов.</h3> <?
                        } else {?>
                                <h3>Список файлов.</h3><ul class="type_1">
                            <?

                            foreach ($files as $key=>$file) {
                                ?>
                                <li class="link ids"><a href="/admin.php?r=/<?= $this->module->id ?>/files/update&page_id=<?= $page_id ?>&item_id=<?=$model->id?>&id=<?= $key ?>" class="alert_title"><?=$file['short']?></a>
                                <a href="/admin.php?r=/<?= $this->module->id ?>/files/delete&page_id=<?= $page_id ?>&item_id=<?=$model->id?>&id=<?= $key ?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a><br></li>
                                <?
                            }
                            ?> </ul> <?
                        }

?>
                    </div>
                        <h3>Загрузить файл</h3>
                        <div class="edit_line">
                            <label for="ModuleList4Files_short" class="required">Описание</label>
                            <div class="inpC">
                                <input class="inp" size="60" maxlength="255" name="ModuleList4Files[short]" id="ModuleList4Files_short" type="text">
                            </div>
                            <input name="ModuleList4Files[file_id]" id="ModuleList4Files_file" type="hidden">
                        </div>
                        <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
                        array(
                            'id'=>'uploadFile',
                            'config'=>array(
                                'action'=>'/admin.php?r=Files/uploadFile&module='.$this->module->id,
                                'allowedExtensions'=>array("pdf","doc", "docx", "xls", "xlsx"),
                                'button_text' => 'Загрузить файл',
                                'sizeLimit' => '40960000',
                                'onComplete'=>"js:function(id, fileName, responseJSON){ $('#ModuleList4Files_file').html('<a href=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#ModuleList4Files_file').val(responseJSON.image_id); }"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </fieldset>
        </div>
		<? foreach($params_list as $key => $value): ?>
			<? if($value['data_type_id']==8): ?>
				<div id="param_<?=$value['id']?>" class="list4_gallery">
					<fieldset>
					<?
                if(!isset($params_values_list[$value['id']]) || empty($params_values_list[$value['id']]['value']) || is_null(ModuleGallery::model()->findByPk((int)$params_values_list[$value['id']]['value']))){
                    $id = $model->id;
                    $param_id = $value['id'];
                    $param_value = ModuleList4Values::model()->getItem($id, $param_id);
                    if(count($param_value)==0 || is_null(ModuleGallery::model()->findByPk((int)$param_value['value']))){
                        // галерея
                        $gallery = new ModuleGallery();
                        $gallery->attributes = array(
                            'title' => 'list4 # param_id = '.$param_id.', item_id = '.$id,
                            'date' => date('Y-m-d'),
                            'active' => 1
                        );
                        if($gallery->save()){
                            if(count($param_value)==0){
                                $model = new ModuleList4Values();
                                $model->attributes = array(
                                    'param_id' => $param_id,
                                    'item_id' => $id,
                                    'value' => $gallery->primaryKey
                                );
                                $model->save();
                            }else{
                                ModuleList4Values::model()->new_value($id, $param_id, $gallery->primaryKey);
                            }
                            $params_values_list[$value['id']] = ModuleList4Values::model()->getItem($id, $param_id);
                        }
                    }
                }
                if(isset($params_values_list[$value['id']]) && !empty($params_values_list[$value['id']]['value']) && !is_null(ModuleGallery::model()->findByPk((int)$params_values_list[$value['id']]['value']))):
                    $gallery_id = (int)$params_values_list[$value['id']]['value'];
					?>
                <div class="row2 cf">
				
					<div style="margin-top: 10px;">
                    <?
                    $this->widget('ext.EAjaxUpload.EAjaxUpload',
						array(
							'id'=>'upload_param_'.$value['id'],
							'config'=>array(
								'multiple'=>true,
								'action'=>'/admin.php?r=/gallery/main/upload&gallery_id='.$gallery_id.'&resize=1&width=1300&height=1300',
								'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
								'button_text' => 'Загрузить изображения',
								'sizeLimit' => '40960000',
								'onComplete'=>"js:function(id, fileName, responseJSON){
									$('#gallery_param_".$value['id']."').append($(responseJSON.html));
									cboxInit();
									$('#param_".$value['id']." .gallery_note_message').hide();
								}",
							),
						)
                    );
                    ?>
					</div>
					
					<?
					$photos = new ModuleGalleryPhotos;
					$photos = $photos->getList($gallery_id);
					?>
					<p class="gallery_note_message" style="<?=(count($photos))?'display:none;':''?>">Фотокарточек пока нет. Для того, чтобы загрузить фотокарточки, нажмите на кнопку «Загрузить изображения» и выберите одну или несколько файлов. По мере того, как файлы будут загружаться, фотокарточки будут появляться ниже.</p>
					
					<div class="edit_gallery" class="thumbs clearfix">
						<ul class="<?=(count($photos)>1)?'sortable':'sortable'?> type_3 gallery_container" id="gallery_param_<?=$value['id']?>" data-gallery_id="<?=$gallery_id?>">
							<? foreach($photos as $value2): ?>
								<li data-id="<?=$value2->id?>" class="link ids gallery_photo_<?=$value2->id?> <?= $value2->cover==1 ? ' cover' : '' ?>">
									<figure class="thumb">
                                        <div class="loader"></div>
										<div class="palaroid">
											<div class="thumb_img" style="text-align:center; width:auto;">
												<img src="<?=$value2->img[0]?>">		
											</div>
											<p class="note" style="position:absolute; margin:5px 0 0 0;"><?=$value2->title?></p>
										</div>
										<figcaption>
											<div class="bg"></div>
											<div class="thumb_controls">
												<ul>
													<li class="tEnlarge"><a href="<?=$value2->img[1]?>" rel="gal">Увеличить</a></li>
                                                    <li class="tTitle"><a href="javascript:void(0)" data-id="<?=$value2->id?>">Название</a></li>
                                                    <li class="tCover"><a href="javascript:void(0)" data-id="<?=$value2->id?>">Обложка</a></li>
                                                    <li class="tDelete"><a href="javascript:void(0)" data-id="<?=$value2->id?>">Удалить</a></li>
											</div>
										</figcaption>
									</figure>
								</li>
							<?endforeach;?>
						</ul>
						<input type="hidden" name="gallery_ids[<?=$gallery_id?>]" value="">
					</div>
					
					
                </div>

				<?/* else: ?>
					<a href="/admin.php?r=/<?=$this->module->id?>/gallery/add&page_id=<?= $page_id ?>&id=<?=$model->id?>&param_id=<?=$value['id']?>">Активировать галерею</a>
				<?*/ endif; ?>
					</fieldset>
				</div>
			<? endif; ?>
		<? endforeach; ?>
	</div>

    <div style="display: none;">
        <? echo $form->textField($model,'mpage_id', array('value' => ModulesInPages::model()->getLink($page_id, $this->module->id))); ?>
    </div>

    <div class="row buttons">
        <? echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>
	
	<?
	if(Yii::app()->user->hasFlash('message')){
		echo Yii::app()->user->getFlash('message');
	}
	?>

    <? $this->endWidget(); ?>

</div><!-- form -->