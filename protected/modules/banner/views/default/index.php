<h2>Баннеры</h2>
<fieldset>
	<div class="js_tabs">
		<a href="#add_accessories"<?=($save || $failed)?' class="active"':''?>>Добавить</a>
		<div class="js_tabs_container" id="add_accessories"<?=($save || $failed)?'':' style="display:none"'?>>
			<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.<br>
			Ссылка на страницу этого сайта будет формироваться автоматически, если написать так: [[make_url_##]], где ## — номер страницы.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-catalog-form',
			'action'=>'/admin.php?r=/banner/default/',
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
				<?php echo $form->labelEx($model,'link'); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'link',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
				</div>
				<?php echo $form->error($model,'link'); ?>
			</div>
			<div class="edit_line">
				<?php echo $form->labelEx($model,'text'); ?>
				<?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=>15)); ?>
				<?php echo $form->error($model,'text'); ?>
			</div>
					
			<?php echo $form->HiddenField($model,'img_id',array('id'=>'imageBanner')); ?>

			<div class="none-upload-drop-area" style="margin-top: 20px;">
				<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
					'id'=>'uploadImageBanner',
					'config'=>array(
						'button_text'=>'Загрузить фото',
						'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id/*.'&resize=1&width=960&height=105'*/,
						'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
						'sizeLimit' => '40960000',
						'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImgBanner').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#imageBanner').val(responseJSON.image_id); $('#delete_smallImgBanner').show();}",
					),
				));
				?>
				<div id="smallImgBanner">
				</div>
				<span class="delete_image" id="delete_smallImgBanner" style="display:none;" data-url="" data-img="smallImgBanner" data-input="imageBanner">Удалить картинку</span>
			</div>
			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
			</div>
			<?=($save)?'<p style="color:green;">Добавлено</p>':''?>
		<?php $this->endWidget(); ?>
		</div>
	</div>
	<div class="catalog">
		<? if(count($data)): ?>
			<ul class="<?=(count($data)>1)?'sortable':''?> type_1">
			<? foreach($data as $d_id=>$value):?>
				<li data-id="<?=$d_id?>" class="link ids">
					<div class="act_block">
					<? if(!$value->active): ?>
						<? if(count($value->img)): ?>
						<a href="/admin.php?r=/banner/default/active&id=<?=$d_id?>" class="activate">Активировать</a>
						<? else: ?>
						<span style="font-size:.75em">неактивный</a>
						<? endif; ?>
					<? else: ?>
						<? if(count($value->img)): ?>
						<a href="/admin.php?r=/banner/default/deactive&id=<?=$d_id?>" class="deactivate">Деактивировать</a>
						<? else: ?>
						<span style="font-size:.75em; color:green">активный</span><span style="font-size:.75em">,<br>но не в ротации,<br>т.к. нет фото</span>
						<? endif; ?>
					<? endif; ?>
					</div>
					<a href="/admin.php?r=/banner/default/update&id=<?=$d_id?>" class="alert_title"><?=$value->title;?></a>&nbsp;&nbsp;&nbsp;<a href="/admin.php?r=/<?=$this->module->id?>/default/delete&id=<?=$d_id?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
					<div class="clear"></div>
				</li>
			<? endforeach;?>
			</ul>
			<? if(count($data)>1): ?>
			<form class="sortable_form" method="POST" action="/admin.php?r=/banner/default/">
				<input type="hidden" name="type" value="banner">
				<input type="hidden" name="ids" value="">
				<input type="submit" value="Сохранить порядок сортировки" style="margin-bottom:20px;">
			</form>
				<? if($save_order):?>
				<p style="color:green">Порядок сортировки сохранён</p>
				<? endif; ?>
			<? endif;?>
		<? else:?>
			<p style="color:grey;"><i>Баннеров пока нет</i></p>
		<? endif;?>
	</div>
</fieldset>