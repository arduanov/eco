<div id="enter">   
	<div class="form loginForm">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableAjaxValidation'=>true,
	)); ?>
		<fieldset>
			<div class="edit_line">
				<?php echo $form->labelEx($model,'username', array('label'=>'Имя пользователя')); ?>
				<div class="inpC">
					<?php echo $form->textField($model,'username', array('class'=>'inp')); ?>
				</div>
				<?php echo $form->error($model,'username'); ?>
			</div>

			<div class="edit_line">
				<?php echo $form->labelEx($model,'password', array('label'=>'Пароль')); ?>
				<div class="inpC">
					<?php echo $form->passwordField($model,'password', array('class'=>'inp')); ?>
				</div>
				<?php echo $form->error($model,'password'); ?>
			</div>

			<div class="edit_line rememberMe">
				<?php echo $form->checkBox($model,'rememberMe'); ?>
				<?php echo $form->label($model,'rememberMe'); ?>
				<?php echo $form->error($model,'rememberMe'); ?>
			</div>

			<div class="edit_line submit lastLine">
				<?php echo CHtml::submitButton('Вход'); ?>
			</div>
		</fieldset>
	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>