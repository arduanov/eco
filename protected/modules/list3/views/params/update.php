<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
?>

<h1 class="pTitle">Возможные значения параметра «<?=$item->title?>»</h1>
<div class="actionsList">
	&larr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/index&page_id=<?= $page_id ?>">Назад к списку параметров</a>
	<? if($role_id<2): ?>
		&darr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/settings&page_id=<?= $page_id ?>&id=<?= $id ?>">Настройки</a>
	<? endif; ?>
</div>

<div class="form">


    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>


	<fieldset>
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
				<div class="edit_line">
					<?php echo $form->labelEx($model, 'title'); ?>
					<div class="inpC">
						<?php echo $form->textField($model, 'title', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
					</div>
					<?php echo $form->error($model, 'title'); ?>
				</div>
				<? if(in_array($page_id,array(40,41,110,111,112))): ?>
					<div class="edit_line checkboxLine">
						<input id="ytModuleList3ParamsValues_check_1" type="hidden" value="0" name="ModuleList3ParamsValues[check_1]">
						<input name="ModuleList3ParamsValues[check_1]" id="ModuleList3ParamsValues_check_1" value="1" type="checkbox">
						<label class="labelCheckbox" for="ModuleList3ParamsValues_check_1">Скрыть для раздела «<?=Pages::model()->findByPk(40)->name?>»</label>
					</div>
					<div class="edit_line checkboxLine">
						<input id="ytModuleList3ParamsValues_check_2" type="hidden" value="0" name="ModuleList3ParamsValues[check_2]">
						<input name="ModuleList3ParamsValues[check_2]" id="ModuleList3ParamsValues_check_2" value="1" type="checkbox">
						<label class="labelCheckbox" for="ModuleList3ParamsValues_check_2">Скрыть для раздела «<?=Pages::model()->findByPk(41)->name?>»</label>
					</div>
                    <div class="edit_line checkboxLine">
                        <input id="ytModuleList3ParamsValues_check_3" type="hidden" value="0" name="ModuleList3ParamsValues[check_3]">
                        <input name="ModuleList3ParamsValues[check_3]" id="ModuleList3ParamsValues_check_3" value="1" type="checkbox">
                        <label class="labelCheckbox" for="ModuleList3ParamsValues_check_3">Скрыть для раздела «<?=Pages::model()->findByPk(110)->name?>»</label>
                    </div>
                    <div class="edit_line checkboxLine">
                        <input id="ytModuleList3ParamsValues_check_4" type="hidden" value="0" name="ModuleList3ParamsValues[check_4]">
                        <input name="ModuleList3ParamsValues[check_4]" id="ModuleList3ParamsValues_check_4" value="1" type="checkbox">
                        <label class="labelCheckbox" for="ModuleList3ParamsValues_check_4">Скрыть для раздела «<?=Pages::model()->findByPk(111)->name?>»</label>
                    </div>
                    <div class="edit_line checkboxLine">
                        <input id="ytModuleList3ParamsValues_check_5" type="hidden" value="0" name="ModuleList3ParamsValues[check_5]">
                        <input name="ModuleList3ParamsValues[check_5]" id="ModuleList3ParamsValues_check_5" value="1" type="checkbox">
                        <label class="labelCheckbox" for="ModuleList3ParamsValues_check_5">Скрыть для раздела «<?=Pages::model()->findByPk(112)->name?>»</label>
                    </div>
				<? endif; ?>

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


    <div class="catalog">
		<h3>Список занчений параметра «<?=$item->title?>»</h3>
		
	
		<?
		if(count($list) > 0):
			?>
			<ul class="<?=(count($list)>1)?'sortable':''?> type_1">
				<? foreach($list as $item_id => $item): ?>
					<li data-id="<?= $item->id ?>" class="link ids">
						<a href="/admin.php?r=/<?= $this->module->id ?>/params/update_value&page_id=<?= $page_id ?>&param_id=<?=$id?>&id=<?= $item->id ?>" class="alert_title"><?= $item->title ?></a>&nbsp;&nbsp;&nbsp;
						<a href="/admin.php?r=/<?= $this->module->id ?>/params/delete_value&page_id=<?= $page_id ?>&param_id=<?=$id?>&id=<?= $item->id ?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<? if(count($list) > 1): ?>
				<form class="sortable_form" method="POST" action="/admin.php?r=/<?= $this->module->id ?>/params/update&page_id=<?=$page_id?>&id=<?=$id?>">
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
			<p class="empty_data">Ни одного возможного значения пока нет</p>
		<? endif; ?>
    </div>
	
	</fieldset>

</div><!-- form -->