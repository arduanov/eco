<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'main-form',
    'action'=>Yii::app()->request->baseUrl.'admin.php?r=settings/mainUpdate',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>


<div class="edit_line">
    <?php echo $form->labelEx($model,'mail', array()); ?>
    <div class="inpC">
        <?php echo $form->textField($model,'mail',array('maxlength'=>255, 'class'=>'inp')); ?>
    </div>
    <?php echo $form->error($model,'mail'); ?>
</div>


    <div class="edit_line">
        <?php echo $form->labelEx($model,'mail2', array()); ?>
        <div class="inpC">
            <?php echo $form->textField($model,'mail2',array('maxlength'=>255, 'class'=>'inp')); ?>
        </div>
        <?php echo $form->error($model,'mail2'); ?>
    </div>

	<div class="edit_line">
		<?php echo $form->labelEx($model,'mail3', array()); ?>
		<div class="inpC">
			<?php echo $form->textField($model,'mail3',array('maxlength'=>255, 'class'=>'inp')); ?>
		</div>
		<?php echo $form->error($model,'mail3'); ?>
	</div>

<div class="edit_line buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Обновить настройки'); ?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->