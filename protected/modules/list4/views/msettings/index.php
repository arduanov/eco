<h1 class="pTitle">Настройки модуля «<?=$module_settings->title?>»</h1>
<div class="actionsList">
	&larr; <a href="<?= Yii::app()->baseUrl; ?>?r=pages/update&id=<?= $page_id; ?>&/#!/tab_<?= $this->module->id ?>">Назад к редактированию страницы</a>
</div>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'module-product-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

            <fieldset>
                <div class="row2 cf">

					<div class="edit_line">
						<?php echo $form->labelEx($model, 'title'); ?>
						<div class="inpC">
							<?php echo $form->textField($model, 'title', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
						</div>
						<?php echo $form->error($model, 'title'); ?>
					</div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'order_by_title', array('checked' =>($model->isNewRecord)?'checked':$model->order_by_title)); ?>
                        <?php echo $form->labelEx($model,'order_by_title', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'order_by_title'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'btn_order', array('checked' =>($model->isNewRecord)?'checked':$model->btn_order)); ?>
                        <?php echo $form->labelEx($model,'btn_order', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'btn_order'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'news_type', array('checked' =>($model->isNewRecord)?'checked':$model->news_type)); ?>
                        <?php echo $form->labelEx($model,'news_type', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'news_type'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'maps_fields', array('checked' =>($model->isNewRecord)?'checked':$model->maps_fields)); ?>
                        <?php echo $form->labelEx($model,'maps_fields', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'maps_fields'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'ymaps', array('checked' =>($model->isNewRecord)?'checked':$model->ymaps)); ?>
                        <?php echo $form->labelEx($model,'ymaps', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'ymaps'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'edit_type', array('checked' =>($model->isNewRecord)?'checked':$model->edit_type)); ?>
                        <?php echo $form->labelEx($model,'edit_type', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'edit_type'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'import_csv', array('checked' =>($model->isNewRecord)?'checked':$model->import_csv)); ?>
                        <?php echo $form->labelEx($model,'import_csv', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'import_csv'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'export_csv', array('checked' =>($model->isNewRecord)?'checked':$model->export_csv)); ?>
                        <?php echo $form->labelEx($model,'export_csv', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'export_csv'); ?>
                    </div>
					<div class="edit_line">
						<?php echo $form->labelEx($model, 'pagination'); ?>
						<div class="inpC">
							<?php echo $form->textField($model, 'pagination', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
						</div>
						<?php echo $form->error($model, 'pagination'); ?>
					</div>
					<div class="edit_line">
						<?php echo $form->labelEx($model,'list_view', array()); ?>
						<div class="inpC">
							<?php echo $form->dropDownList($model, 'list_view', array(
								1=>'Название',
								2=>'Название, краткое описание',
								3=>'Название (__ADDRESS__)',
							), array('class'=>'inp', 'options' => array(1  => array('selected'=>true)))); ?>
						</div>
						<?php echo $form->error($model,'list_view'); ?>
					</div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'btn_add', array('checked' =>($model->isNewRecord)?'checked':$model->btn_add)); ?>
                        <?php echo $form->labelEx($model,'btn_add', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'btn_add'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'btn_delete', array('checked' =>($model->isNewRecord)?'checked':$model->btn_delete)); ?>
                        <?php echo $form->labelEx($model,'btn_delete', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'btn_delete'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'btn_params', array('checked' =>($model->isNewRecord)?'checked':$model->btn_params)); ?>
                        <?php echo $form->labelEx($model,'btn_params', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'btn_params'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'btn_active', array('checked' =>($model->isNewRecord)?'checked':$model->btn_active)); ?>
                        <?php echo $form->labelEx($model,'btn_active', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'btn_active'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'edit_short', array('checked' =>($model->isNewRecord)?'checked':$model->edit_short)); ?>
                        <?php echo $form->labelEx($model,'edit_short', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'edit_short'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'edit_text', array('checked' =>($model->isNewRecord)?'checked':$model->edit_text)); ?>
                        <?php echo $form->labelEx($model,'edit_text', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'edit_text'); ?>
                    </div>
                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'edit_img', array('checked' =>($model->isNewRecord)?'checked':$model->edit_img)); ?>
                        <?php echo $form->labelEx($model,'edit_img', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'edit_img'); ?>
                    </div>

                </div>

            </fieldset>


    <div style="display: none;">
        <?php echo $form->textField($model,'mpage_id', array('value' => ModulesInPages::model()->getLink($page_id, $this->module->id))); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>
	
	<?
	if(Yii::app()->user->hasFlash('message')){
		echo Yii::app()->user->getFlash('message');
	}
	?>

    <?php $this->endWidget(); ?>

</div><!-- form -->