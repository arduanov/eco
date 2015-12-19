<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
?>

<h1 class="pTitle">Связанные модули «List4» в параметре «<?=$item->title?>»</h1>
<div class="actionsList">
	&larr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/index&page_id=<?= $page_id ?>">Назад к списку параметров</a>
	<? if($role_id<2): ?>
		&darr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/settings&page_id=<?= $page_id ?>&id=<?= $id ?>">Настройки</a>
	<? endif; ?>
</div>

<div class="form">


    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>


	<fieldset>


    <div class="catalog">
		<h3>Модули «List4»</h3>
		
	
		<?
		$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
		$list = ModuleList4Settings::model()->getList($mpage_id);
		$params_values = ModuleList4ParamsList4::model()->getList($id);
		if(count($list) > 0):
			?>
				<?php
				$form = $this->beginWidget('CActiveForm', array(
					'id' => 'module-product-form',
					'enableAjaxValidation' => false,
						));
				?>
			<? foreach($list as $item_id => $item): ?>
				<div class="edit_line checkboxLine">
					<input name="ModuleList4ParamsList4[<?=$item->mpage_id?>]" id="ModuleList4ParamsList4_<?=$item->mpage_id?>" value="<?=$item->mpage_id?>" type="checkbox" <?=(in_array($item->mpage_id,$params_values))?'checked':''?>>
					<label class="labelCheckbox" for="ModuleList4ParamsList4_<?=$item->mpage_id?>"><?=$item->title?></label>
				</div>
			<? endforeach; ?>
				<input type="hidden" value="save" name="type">
				<div class="row buttons" style="margin-top: 10px;">
					<?php echo CHtml::submitButton('Сохранить'); ?>
				</div>
				<?php $this->endWidget(); ?>
		<? else: ?>
			<p class="empty_data">Ни одного возможного значения пока нет</p>
		<? endif; ?>
    </div>
	
	</fieldset>

</div><!-- form -->