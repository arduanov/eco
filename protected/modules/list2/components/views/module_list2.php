<fieldset>
	<div class="js_tabs">
		<a href="#add_list2"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<div class="js_tabs_container row2 cf" id="add_list2"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?'':' style="display:none"'?>>
		
		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-list2-form',
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
					
			<?php echo $form->HiddenField($model,'img_id',array('id'=>'imageList2')); ?>

			<div class="none-upload-drop-area" style="margin-top: 20px;">
				<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id'=>'uploadImageList2',
					'config'=>array(
						'button_text'=>'Загрузить фото',
						'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module_id,
						'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
						'sizeLimit' => '40960000',
						'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImgList2').html('<img src=\'/upload/".md5($this->module_id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#imageList2').val(responseJSON.image_id); $('#delete_smallImgList2').show();}",
					),
				));
				?>
			</div>
			<div id="smallImgList2" class="smallImg">
			</div>
			<span class="delete_image" id="delete_smallImgList2" style="display:none;" data-url="" data-img="smallImgList2" data-input="imageList2">Удалить картинку</span>
			
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
		$data = ModuleList2::model()->getList($mpage_id);
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