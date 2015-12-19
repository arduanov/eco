<fieldset>
	<div class="js_tabs">
		<a href="#add_catalog"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<div class="js_tabs_container row2 cf" id="add_catalog"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?'':' style="display:none"'?>>
		
		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-catalog-form',
			'action'=>'/admin.php?r=/pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id,
			'enableAjaxValidation'=>false,
		)); ?>
			
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
					
			<? /*
			<?php echo $form->HiddenField($model,'photo_id',array('id'=>'imageCatalog')); ?>
			
			<div class="none-upload-drop-area" style="margin-top: 20px;">
				<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id'=>'uploadImageCatalog',
					'config'=>array(
						'button_text'=>'Загрузить фото',
						'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module_id,
						'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
						'sizeLimit' => '40960000',
						'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImgCatalog').html('<img src=\'/upload/".md5($this->module_id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#imageCatalog').val(responseJSON.image_id); $('#delete_smallImgCatalog').show();}",
					),
				));
				?>
				<div id="smallImgCatalog">
				</div>
				<span class="delete_image" id="delete_smallImgCatalog" style="display:none;" data-url="" data-img="smallImgCatalog" data-input="imageCatalog">Удалить картинку</span>
			</div>
			*/ ?>
			
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
	<?=$pagination?>
	<div class="catalog" style="margin-top:35px;">
		<?
		if(count($data) > 0): ?>
			<ul class="type_1">
			<? foreach($data as $item_id => $item):?>
				<li data-id="<?=$item->id?>" class="link ids">
					<div class="act_block">
					<? if(!$item->active): ?>
						<a href="/admin.php?r=/<?=$this->module_id?>/main/activate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="activate">Опубликовать</a>
					<? else: ?>
						<a href="/admin.php?r=/<?=$this->module_id?>/main/deactivate&page_id=<?=$page_id?>&id=<?=$item->id?>" class="deactivate">Не публиковать</a>
					<? endif; ?>
					</div>
					<span><?=Yii::app()->dateFormatter->format('d MMMM yyyy', $item->date)?></span>, <a href="/admin.php?r=/<?=$this->module_id?>/main/update&page_id=<?=$page_id?>&id=<?=$item->id?>" class="alert_title"><?=$item->title?></a>&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?=$this->module_id?>/main/delete&page_id=<?=$page_id?>&id=<?=$item->id?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
					<div class="clear"></div>
				</li>
			<?php endforeach;?>
			</ul>
			<?
			if(Yii::app()->user->hasFlash($this->module_id.'_delete_message')){
				echo Yii::app()->user->getFlash($this->module_id.'_delete_message');
			}
			?>
		<? else:?>
			<p class="empty_data">Альбомы пока не добавлены</p>
		<? endif;?>
	</div>
	<?=$pagination?>
</fieldset>