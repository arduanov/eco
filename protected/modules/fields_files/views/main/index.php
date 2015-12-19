<? $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id; ?>
<fieldset>
	<? if($role_id<2):?>
	<div class="js_tabs">
		<a href="#add_catalog"<?=(Yii::app()->user->hasFlash($this->module->id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<div class="js_tabs_container" id="add_catalog"<?=(Yii::app()->user->hasFlash($this->module->id.'_add_message'))?'':' style="display:none"'?>>
		
		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-catalog-form',
			'action'=>'/admin.php?r=/pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id,
			'enableAjaxValidation'=>false,
		)); ?>
			
			<div class="edit_line">
				<?php echo $form->labelEx($model,'title'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'title',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'title'); ?>
			</div>
			
			<div class="edit_line">
				<?php echo $form->labelEx($model,'code'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'code',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'code'); ?>
			</div>
			
			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
			</div>
			<?
			if(Yii::app()->user->hasFlash($this->module->id.'_add_message')){
				echo Yii::app()->user->getFlash($this->module->id.'_add_message');
			}
			?>
		<?php $this->endWidget(); ?>
		</div>
	</div>
	<? endif; ?>
	<div class="catalog">
		<?
		$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
		$data = ModuleFields::model()->getList($mpage_id);
		if(count($data) > 0): ?>
			<form method="POST" action="/admin.php?r=pages/update&id=<?=$page_id?>&/#!/tab_<?=$this->module->id?>">
				<ul class="<?=(count($data)>1 && $role_id<2)?'sortable':''?> type_2">
				<? foreach($data as $item_id => $item):?>
					<li data-id="<?=$item->id?>" class="link ids">
						<div class="edit_line">
							<label for="fields_<?=$item->code?>" class="required">
								<?=($role_id<2)?'<b>':''?><span class="alert_title"><?=$item->title?></span><?=($role_id<2)?'</b> (code: '.$item->code.')':''?>
								<? if($role_id<2):?>
								<a href="/admin.php?r=/<?=$this->module->id?>/main/delete&page_id=<?=$page_id?>&id=<?=$item->id?>" class="delete">
									<img src="/admin/pics/i/del-small.png" alt="Удалить">
								</a>
								<? endif; ?>
							</label>
							<div class="inpC">
								<input maxlength="255" class="inp" name="fields[<?=$item->id?>]" id="fields_<?=$item->code?>" type="text" value="<?=$item->value?>">
							</div>
							<? if($role_id<2):?>
							<a style="display:block; margin-top:5px" href="/admin.php?r=/<?=$this->module->id?>/main/update&page_id=<?=$page_id?>&id=<?=$item->id?>">Редактировать</a>
							<? endif; ?>
						</div>
					</li>
				<?php endforeach;?>
				</ul>
				<input type="hidden" name="type" value="values">
				<input type="submit" value="Сохранить" style="margin-bottom:20px; <?=($role_id<2)?'float:left; margin-right:30px':''?>">
			</form>
			<? if(count($data)>1 && $role_id<2): ?>
				<form class="sortable_form" method="POST" action="/admin.php?r=pages/update&id=<?=$page_id?>&/#!/tab_<?=$this->module->id?>">
					<input type="hidden" name="type" value="<?=$this->module->id?>">
					<input type="hidden" name="ids" value="">
					<input type="submit" value="Сохранить порядок сортировки" style="margin-bottom:20px;">
				</form>
				<?
				if(Yii::app()->user->hasFlash($this->module->id.'_order_message')){
					echo Yii::app()->user->getFlash($this->module->id.'_order_message');
				}
				?>
			<? endif; ?>
			<?
			if(Yii::app()->user->hasFlash($this->module->id.'_delete_message')){
				echo Yii::app()->user->getFlash($this->module->id.'_delete_message');
			}
			if(Yii::app()->user->hasFlash($this->module->id.'_values_message')){
				echo Yii::app()->user->getFlash($this->module->id.'_values_message');
			}
			?>
		<? else:?>
			<p class="empty_data">Дополнительных полей пока нет</p>
		<? endif;?>
	</div>
</fieldset>