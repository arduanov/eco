<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
?>

<? $role_id = 2; ?>

<fieldset>
	<div class="js_tabs">
		<a href="#add_list3"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<a class="no_js" style="border: none; text-decoration: underline;" href="/admin.php?r=/<?=$this->module_id?>/params/index&page_id=<?=$page_id?>">Параметры</a>
		<div class="js_tabs_container row2 cf" id="add_list3"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?'':' style="display:none"'?>>
		
		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-list3-form',
			'action'=>'/admin.php?r=/pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id,
			'enableAjaxValidation'=>false,
		)); ?>
			
					
			<div class="edit_line">
				<?php echo $form->labelEx($model,'title'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'title',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'title'); ?>
			</div>
			
			<div class="edit_line checkboxLine">
				<?php echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'':$model->active)); ?>
				<?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
				<?php echo $form->error($model,'active'); ?>
			</div>

			<div class="edit_line">
				<?php echo $form->labelEx($model,'short', array()); ?>
				<div class="inpC">
					<?php echo $form->textArea($model,'short', array('rows'=> '5', 'class'=>'inp')); ?>
				</div>
				<?php echo $form->error($model,'short'); ?>
			</div>
			
			<div class="edit_line">
				<?php echo $form->labelEx($model,'text'); ?>
				<?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
				<?php echo $form->error($model,'text'); ?>
			</div>

			<? foreach($params_list as $key => $value): ?>
				<? if($role_id<2 || (($key<28 || $key>63)&($key<82 || $key>109) && $key!=25 && $key!=27)): ?>
					<? if($value['data_type_id']==1): ?>
						<div class="edit_line">
							<label for="ModuleList3Values_<?=$value['code']?>" class="required"><?=$value['title']?></label>
							<div class="inpC">
								<input class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=$value['default_value']?>">
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==2): ?>
						<div class="edit_line checkboxLine">
							<input id="ytModuleList3Values_<?=$value['code']?>" type="hidden" value="0" name="ModuleList3Values[<?=$value['id']?>]">
							<input name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" value="1" type="checkbox">
							<label class="labelCheckbox" for="ModuleList3Values_<?=$value['code']?>"><?=$value['title']?></label>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==3): ?>
						<div class="edit_line">
							<label for="ModuleList3Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
							<div class="inpC">
								<textarea rows="5" class="inp" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>"><?=$value['default_value']?></textarea>
							</div>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==4): ?>
						<div class="edit_line">
							<label for="ModuleList3Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
							<textarea class="mceEditor inp" rows="25" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>"><?=$value['default_value']?></textarea>
						</div>
					<? endif; ?>
					<? if($value['data_type_id']==5): ?>
						<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
							<label><strong><?=$value['title']?></strong></label>
							<?
							$params_values = ModuleList3ParamsValues::model()->getList($value['id']);
							foreach($params_values as $key2 => $value2):
							?>
								<div class="edit_line checkboxLine">
									<input name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="radio">
									<label class="labelCheckbox" for="ModuleList3Values_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
								</div>
							<? endforeach; ?>
							</div>
					<? endif; ?>
					<? if($value['data_type_id']==6): ?>
						<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
							<label><strong><?=$value['title']?></strong></label>
							<?
							$params_values = ModuleList3ParamsValues::model()->getList($value['id']);
							$i = 0;
							foreach($params_values as $key2 => $value2):
									$i++;
							?>
								<div class="edit_line checkboxLine">
									<input id="ytModuleList3Values_<?=$value['code']?><?=$value2['id']?>" type="hidden" value="0" name="ModuleList3Values[<?=$value['id']?>][<?=$i?>]">
									<input name="ModuleList3Values[<?=$value['id']?>][<?=$i?>]" id="ModuleList3Values_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="checkbox">
									<label class="labelCheckbox" for="ModuleList3Values_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
								</div>
							<? endforeach; ?>
							</div>
					<? endif; ?>
				<? endif; ?>
			<? endforeach; ?>
		
		<? if($page_id == 37 && $role_id>1): ?>
			<style>
				.table-inputs .td-first div {height: 22px;}
			</style>
            <p>Ставки (обе таблицы должны быть заполнены)</p>
            <p>Декларируемая ставка</p>
			<table class="table-inputs">
				<thead>
					<tr>
						<th style="width: 70px;">Срок</th>
						<th>RUR</th>
						<th>USD</th>
						<th>EUR</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="td-first">
							<div>31 день</div>
							<div>91 день</div>
							<div>181 день</div>
							<div>271 день</div>
							<div>370 дней</div>
							<div>740 дней</div>
							<div>1110 дней</div>
							<div>1480 дней</div>
							<div>1850 дней</div>
						</td>
						<td>
			<?
				for($i = 28; $i < 55; $i++){
					$value = $params_list[$i];
					?>
					<? if($value['data_type_id']==1): ?>
						<div class="inpC" style="padding: 0;">
							<input style="width: 100px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=$value['default_value']?>">
						</div>
					<? endif; ?>
					<?
					if($i==36 || $i==45) echo '</td><td>';
				}
			?>
						</td>
					</tr>
				</tbody>
			</table>
		<? endif; ?>

        <? if($page_id == 37 && $role_id>1): ?>
        			<style>
        				.table-inputs .td-first div {height: 22px;}
        			</style>
                    <p>Эффективная ставка</p>
        			<table class="table-inputs">
        				<thead>
        					<tr>
        						<th style="width: 70px;">Срок</th>
        						<th>RUR</th>
        						<th>USD</th>
        						<th>EUR</th>
        					</tr>
        				</thead>
        				<tbody>
        					<tr>
        						<td class="td-first">
        							<div>31 день</div>
        							<div>91 день</div>
        							<div>181 день</div>
        							<div>271 день</div>
        							<div>370 дней</div>
        							<div>740 дней</div>
        							<div>1110 дней</div>
        							<div>1480 дней</div>
        							<div>1850 дней</div>
        						</td>
        						<td>
        			<?
        				for($i = 82; $i < 109; $i++){
        					$value = $params_list[$i];
        					?>
        					<? if($value['data_type_id']==1): ?>
        						<div class="inpC" style="padding: 0;">
        							<input style="width: 100px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=$value['default_value']?>">
        						</div>
        					<? endif; ?>
        					<?
        					if($i==90 || $i==99) echo '</td><td>';
        				}
        			?>
        						</td>
        					</tr>
        				</tbody>
        			</table>
        		<? endif; ?>
			
			<?php echo $form->HiddenField($model,'img_id',array('id'=>'imageList3')); ?>

			<div class="none-upload-drop-area" style="margin-top: 20px;">
				<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id'=>'uploadImageList3',
					'config'=>array(
						'button_text'=>'Загрузить фото',
						'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module_id,
						'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
						'sizeLimit' => '40960000',
						'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImgList3').html('<img src=\'/upload/".md5($this->module_id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#imageList3').val(responseJSON.image_id); $('#delete_smallImgList3').show();}",
					),
				));
				?>
			</div>
			<div id="smallImgList3" class="smallImg">
			</div>
			<span class="delete_image" id="delete_smallImgList3" style="display:none;" data-url="" data-img="smallImgList3" data-input="imageList3">Удалить картинку</span>
			
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
	<div class="catalog">
		<?
		$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module_id);
		$data = ModuleList3::model()->getList($mpage_id);
		if(count($data) > 0): ?>
			<h3>Список</h3>
			<ul class="<?=(count($data)>1)?'sortable':''?> type_1">
			<? foreach($data as $item_id => $item):?>
				<li data-id="<?=$item->id?>" class="link ids">
					<div class="act_block">
						<? if(!$item->active): ?>
							<a href="/admin.php?r=/<?=$this->module_id?>/main/activate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="activate">Опубликовать</a>
						<? else: ?>
							<a href="/admin.php?r=/<?=$this->module_id?>/main/deactivate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="deactivate">Не публиковать</a>
						<? endif; ?>
					</div>
					<a href="/admin.php?r=/<?=$this->module_id?>/main/update&page_id=<?=$page_id?>&id=<?=$item->id?>" class="alert_title"><?=$item->title?></a>&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?=$this->module_id?>/main/delete&page_id=<?=$page_id?>&id=<?=$item->id?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
					<div class="clear"></div>
				</li>
			<?php endforeach;?>
			</ul>
			<? if(count($data) > 1): ?>
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
			<?
			if(Yii::app()->user->hasFlash($this->module_id.'_delete_message')){
				echo Yii::app()->user->getFlash($this->module_id.'_delete_message');
			}
			?>
		<? else:?>
			<p class="empty_data">Ни одного элемента списка пока нет</p>
		<? endif;?>
	</div>
</fieldset>