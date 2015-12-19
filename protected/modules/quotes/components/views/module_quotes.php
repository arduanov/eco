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
			
			<div class="edit_line" style="width: 320px; float: left;">
				<?php echo $form->labelEx($model,'date'); ?>
				<div class="inpC">
					<input type="text" value="<?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $model->isNewRecord ? date('Y-m-d'):$model->date);?>" id="edit_date_begin" class="inp datepicker2">
				</div>
				<?php echo $form->error($model,'date'); ?>
			</div>
			<div class="edit_line lastLine" style="display:none;">
				<?php echo $form->textField($model,'date', array('id'=>'altDateField2', 'value' => $model->isNewRecord ? date('Y-m-d'):$model->date, 'type'=>"hidden")); ?>
			</div>
		
			<div style="clear: both;"></div>
					
			<div class="edit_line" style="width: 150px; float: left; margin-right: 20px;">
				<?php echo $form->labelEx($model,'usd_purchase'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'usd_purchase',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'usd_purchase'); ?>
			</div>
					
			<div class="edit_line" style="width: 150px; float: left;">
				<?php echo $form->labelEx($model,'usd_selling'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'usd_selling',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'usd_selling'); ?>
			</div>
		
			<div style="clear: both;"></div>
					
			<div class="edit_line" style="width: 150px; float: left; margin-right: 20px;">
				<?php echo $form->labelEx($model,'eur_purchase'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'eur_purchase',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'eur_purchase'); ?>
			</div>
					
			<div class="edit_line" style="width: 150px; float: left;">
				<?php echo $form->labelEx($model,'eur_selling'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'eur_selling',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'eur_selling'); ?>
			</div>
		
			<div style="clear: both;"></div>
			
			<div class="edit_line checkboxLine">
				<?php echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'':$model->active)); ?>
				<?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
				<?php echo $form->error($model,'active'); ?>
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
	<div class="catalog">
		<?
		if(count($data) > 0): ?>
			<h3>Курсы валют</h3>
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
					<a href="/admin.php?r=/<?=$this->module_id?>/main/update&page_id=<?=$page_id?>&id=<?=$item->id?>" class="alert_title"><?=Yii::app()->dateFormatter->format('d MMMM yyyy', $item->date)?></a>&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?=$this->module_id?>/main/delete&page_id=<?=$page_id?>&id=<?=$item->id?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
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
			<p class="empty_data">Курсов валют пока нет</p>
		<? endif;?>
	</div>
	<?=$pagination?>
</fieldset>