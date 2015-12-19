<h1 class="pTitle">Редактирование новости</h1>
<div class="actionsList">
	&larr; <a href="<?=Yii::app()->baseUrl; ?>?r=pages/update&id=<?=$page_id;?>&/#!/tab_<?=$this->module->id?>">Назад к редактированию страницы</a>
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