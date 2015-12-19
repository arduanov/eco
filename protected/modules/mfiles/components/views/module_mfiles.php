<fieldset>
	<div class="js_tabs">
		<a href="#add_mfiles"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<div class="js_tabs_container row2 cf" id="add_mfiles"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?'':' style="display:none"'?>>
		
		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
    	<p class="note">Доступные расширения файлов: .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .odf, .rtf, .txt, .rar, .zip, .7z, .jpeg, .jpg, .png, .gif, .bmp<br>Максимальный размер файла: 10 Mb.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-mfiles-form',
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
			
			<?
			$list4_mpage_id = ModulesInPages::model()->getLink($page_id,'list4');
			if($list4_mpage_id>0):
				$ModuleList4 = ModuleList4::model()->getList($list4_mpage_id);
				if(count($ModuleList4)):
					$dropdown = array(0 => 'Без группы');
					foreach($ModuleList4 as $k => $v){
						$dropdown[$k] = $v->title;
					}
			?>
			
					<div class="edit_line">
						<?php echo $form->labelEx($model,'group_id'); ?>
						<div class="inpC">
							<?php echo $form->dropDownList($model,'group_id',$dropdown,array('class' => 'inp')); ?>
						</div>
						<?php echo $form->error($model,'group_id'); ?>
					</div>
				<? endif; ?>
			<? endif; ?>
			
			<div class="edit_line checkboxLine">
				<?php echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'':$model->active)); ?>
				<?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
				<?php echo $form->error($model,'active'); ?>
			</div>
			
			<div class="edit_line">
				<?php echo $form->labelEx($model,'text', array()); ?>
				<div class="inpC">
					<?php echo $form->textArea($model,'text', array('rows'=> '5', 'class'=>'inp')); ?>
				</div>
				<?php echo $form->error($model,'text'); ?>
			</div>
					
			<?php echo $form->HiddenField($model,'file_id',array('id'=>'imageMfiles')); ?>
			
			<div class="none-upload-drop-area" style="margin-top: 20px;">
				<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id'=>'uploadImageMfiles',
					'config'=>array(
						'button_text'=>'Загрузить файл',
						'action'=>'/admin.php?r=Files/uploadFile&module='.$this->module_id,
						'allowedExtensions'=>array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "odf", "rtf", "txt", "rar", "zip", "7z", "jpeg","jpg", "png", "gif", "bmp"),
						'sizeLimit' => '63000000',
						'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImgMfiles').html('<h1>'+responseJSON.filename+'</h1>'); $('#imageMfiles').val(responseJSON.image_id); $('#delete_smallImgMfiles').show();}",
					),
				));
				?>
				<div id="smallImgMfiles" class="smallImg">
				</div>
				<span class="delete_image" id="delete_smallImgMfiles" style="display:none;" data-url="" data-img="smallImgMfiles" data-input="imageMfiles">Удалить файл</span>
			</div>
			
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
			<p class="empty_data">Файлы пока не добавлены</p>
		<? endif;?>
	</div>
	<?=$pagination?>
</fieldset>