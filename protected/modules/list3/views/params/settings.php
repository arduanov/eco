<h1 class="pTitle">Настройки параметра «<?=$model->title?>»</h1>
<div class="actionsList">
	&larr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/index&page_id=<?= $page_id ?>">Назад к списку параметров</a>
	<? if(in_array($model->data_type_id,array(5,6))): ?>
	&uarr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/update&page_id=<?= $page_id ?>&id=<?= $id ?>">Возможные значения</a>
	<? endif; ?>
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