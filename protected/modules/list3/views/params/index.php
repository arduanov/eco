<h1 class="pTitle">Редактирование параметров</h1>
<div class="actionsList">
	&larr; <a href="<?= Yii::app()->baseUrl; ?>?r=pages/update&id=<?= $page_id; ?>&/#!/tab_<?= $this->module->id ?>">Назад к редактированию страницы</a>
</div>

<div class="form">


    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>


	<fieldset>
		<? if($role_id<2): ?>
		<div class="js_tabs">
			<a href="#add_<?= $this->module->id ?>"<?= (Yii::app()->user->hasFlash($this->module->id.'_add_message')) ? ' class="active"' : '' ?>>Добавить</a>
			<div class="js_tabs_container row2 cf" id="add_<?= $this->module->id ?>"<?= (Yii::app()->user->hasFlash($this->module->id.'_add_message')) ? '' : ' style="display:none"' ?>>
				
				<?php
				$form = $this->beginWidget('CActiveForm', array(
					'id' => 'module-product-form',
					'enableAjaxValidation' => false,
						));
				?>

				<?php echo $form->errorSummary($model); ?>
				<div class="edit_line edit_line_right_date" style="width:50%">
					<?php echo $form->labelEx($model, 'code'); ?>
					<div class="inpC">
						<?php echo $form->textField($model, 'code', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
					</div>
					<?php echo $form->error($model, 'code'); ?>
				</div>
				<div class="edit_line">
					<?php echo $form->labelEx($model, 'title'); ?>
					<div class="inpC">
						<?php echo $form->textField($model, 'title', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
					</div>
					<?php echo $form->error($model, 'title'); ?>
				</div>
				
				<? if(isset($data_type_drop_down_list[7])) unset($data_type_drop_down_list[7]); ?>
				
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'data_type_id', array()); ?>
                    <div class="inpC">
                        <?php echo $form->dropDownList($model, 'data_type_id', $data_type_drop_down_list, array('class'=>'inp', 'options' => array(1  => array('selected'=>true)))); ?>
                    </div>
                    <?php echo $form->error($model,'data_type_id'); ?>
                </div>
				
				<?/*
				<div class="edit_line lastLine">
					<?php echo $form->labelEx($model, 'default_value'); ?>
					<div class="inpC">
						<?php echo $form->textField($model, 'default_value', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
					</div>
					<?php echo $form->error($model, 'default_value'); ?>
				</div>
				 */?>
				
				<?
				if(Yii::app()->user->hasFlash($this->module->id.'_add_message')){
					echo Yii::app()->user->getFlash($this->module->id.'_add_message');
				}
				?>


				<div style="display: none;">
					<?php echo $form->textField($model, 'mpage_id', array('value' => ModulesInPages::model()->getLink($page_id, $this->module->id))); ?>
				</div>

				<div class="row buttons" style="margin-top: 10px;">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
				</div>

				<?php $this->endWidget(); ?>
				
			</div>
		</div>
		<? endif; ?>


    <div class="catalog">
		<h3>Список параметров</h3>
		
	
		<?
		if(count($list) > 0):
			?>
			<ul class="<?=($role_id<2 && count($list)>1)?'sortable':''?> type_1">
				<? foreach($list as $item_id => $item): ?>
					<li data-id="<?= $item->id ?>" class="link ids">
						<? if(in_array($item->data_type_id,array(5,6))): ?>
							<a href="/admin.php?r=/<?= $this->module->id ?>/params/update&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="alert_title"><?= $item->title ?></a>&nbsp;&nbsp;&nbsp;
						<? elseif($role_id<2): ?>
							<a href="/admin.php?r=/<?= $this->module->id ?>/params/settings&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="alert_title"><?= $item->title ?></a>&nbsp;&nbsp;&nbsp;
						<? else: ?>
							<?= $item->title ?>&nbsp;&nbsp;&nbsp;
						<? endif; ?>
						<? if($role_id<2): ?>
							<a href="/admin.php?r=/<?= $this->module->id ?>/params/delete&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
							<br><i style="color: #666;"><?=$item->type_title?></i>
						<? endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<? if($role_id<2 && count($list) > 1): ?>
				<form class="sortable_form" method="POST" action="/admin.php?r=/<?= $this->module->id ?>/params/index&page_id=<?=$page_id?>">
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
			?>
		<? else: ?>
			<p class="empty_data">Ни одного параметра пока нет</p>
		<? endif; ?>
    </div>
	
	</fieldset>

</div><!-- form -->