<h1 class="pTitle">Редактирование баннера</h1>
<div class="actionsList">
    <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin.php?r=/banner/default/">Назад к списку баннеров</a>
</div>

<div class="form">
    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.<br>
	Ссылка на страницу этого сайта будет формироваться автоматически, если написать так: [[make_url_##]], где ## — номер страницы.</p>
    <div class="tabs">
        <!-- Это контейнеры содержимого -->
        <div id="first">
            <fieldset>
                <div class="row2 cf">
				<?php $form = $this->beginWidget('CActiveForm', array(
					'id'=>'module-catalog_item-form',
					'enableAjaxValidation'=>false,
				)); ?>

                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'title'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'title',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
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
					
					<?php echo $form->HiddenField($model,'img_id',array('id'=>'image')); ?>

					<div style="margin-top: 20px;">
						<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
						array(
							'id'=>'uploadImage',
							'config'=>array(
								'button_text'=>'Загрузить фото',
								'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id/*.'&resize=1&width=960&height=105'*/,
								'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
								'sizeLimit' => '40960000',
								'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' alt=\'\'>'); $('#image').val(responseJSON.image_id); $('.delete_image').show();}",
							),
						));
						?>
						<div id="smallImg">
							<img src="<?=$model->img[0]?>" alt="">
						</div>
						<span class="delete_image" <?=($model->img_id)?'':'style="display:none;"'?> data-url="" data-img="smallImg" data-input="image">Удалить картинку</span>
					</div>
					<div class="row buttons">
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
					</div>
				<?php $this->endWidget(); ?>
                </div>
            </fieldset>
        </div>
    </div>
</div><!-- form -->