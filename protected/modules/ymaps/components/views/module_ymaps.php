<?
// принудительное ограничение функциональности «А ЛЯ Костыль»
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
?>

<fieldset>
	<? if($role_id<2): ?>
    <div class="js_tabs">
        <a href="#add_ymaps"<?= (Yii::app()->user->hasFlash($this->module_id.'_add_message')) ? ' class="active"' : '' ?>>Добавить</a>
        <div class="js_tabs_container row2 cf" id="add_ymaps"<?= (Yii::app()->user->hasFlash($this->module_id.'_add_message')) ? '' : ' style="display:none"' ?>>

            <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
			<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'module-ymaps-form',
				'action' => '/admin.php?r=/pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id,
				'enableAjaxValidation' => false,
					));
			?>


            <div class="edit_line">
				<?php echo $form->labelEx($model, 'title'); ?>
                <div class="inpC">
					<?php echo $form->textField($model, 'title', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
                </div>
				<?php echo $form->error($model, 'title'); ?>
            </div>

            <div class="edit_line checkboxLine">
				<?php echo $form->checkBox($model, 'active', array('checked' => ($model->isNewRecord) ? '' : $model->active)); ?>
				<?php echo $form->labelEx($model, 'active', array('class' => 'labelCheckbox')); ?>
				<?php echo $form->error($model, 'active'); ?>
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
	<? endif; ?>
    <div class="catalog">
		<?
		$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module_id);
		$data = ModuleYmapsCategories::model()->getList($mpage_id);
		if(count($data) > 0):
			?>
			<h3>Категории</h3>
			<ul class="type_1">
				<? foreach($data as $item_id => $item): ?>
					<li data-id="<?= $item->id ?>" class="link ids">
						<? if($role_id<2): ?>
							<div class="act_block">
								<? if(!$item->active): ?>
									<a href="/admin.php?r=/<?= $this->module_id ?>/main/activate&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="activate">Опубликовать</a>
								<? else: ?>
									<a href="/admin.php?r=/<?= $this->module_id ?>/main/deactivate&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="deactivate">Не публиковать</a>
								<? endif; ?>
							</div>
						<? endif; ?>
						<a href="/admin.php?r=/<?= $this->module_id ?>/main/update&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="alert_title"><?= $item->title ?></a><? if($role_id<2): ?>&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?= $this->module_id ?>/main/delete&page_id=<?= $page_id ?>&id=<?= $item->id ?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a><? endif; ?>
						<div class="clear"></div>
					</li>
				<?php endforeach; ?>
			</ul>
			<?
			if(Yii::app()->user->hasFlash($this->module_id.'_delete_message')){
				echo Yii::app()->user->getFlash($this->module_id.'_delete_message');
			}
			?>
		<? else: ?>
			<p class="empty_data">Ни одной категории точек пока нет</p>
		<? endif; ?>
    </div>
</fieldset>