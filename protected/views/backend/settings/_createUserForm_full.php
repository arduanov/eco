<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'createUser-form',
	'enableAjaxValidation'=>false,
    'action'=>Yii::app()->request->baseUrl.'admin.php?r=settings/createUser',
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <div class="edit_line">
        <?php echo $form->labelEx($model,'username', array()); ?>
        <div class="inpC">
            <?php echo $form->textField($model,'username',array('maxlength'=>255, 'class'=>'inp')); ?>
        </div>
        <?php echo $form->error($model,'username'); ?>
    </div>
    <div class="edit_line">
        <?php echo $form->labelEx($model,'login', array()); ?>
        <div class="inpC">
            <?php echo $form->textField($model,'login',array('maxlength'=>255, 'class'=>'inp')); ?>
        </div>
        <?php echo $form->error($model,'login'); ?>
    </div>

        <div class="edit_line lastLine">
            <?php echo $form->labelEx($model,'role_id', array()); ?>
            <div class="inpC">
                <?php echo $form->dropDownList($model, 'role_id', $roles ,array('class'=>'inp', 'options' => array())); ?>
            </div>
            <?php echo $form->error($model,'role_id'); ?>
        </div>
        <div class="edit_line checkboxLine">
            <?php echo $form->checkBox($model,'state'); ?>
            <?php echo $form->labelEx($model,'state', array('class'=>'labelCheckbox')); ?>
            <?php echo $form->error($model,'state'); ?>
        </div>

    <?php if(!$model->isNewRecord):?>
        <dl class="slideRow">
            <dt><a href="javascript://void(0)" class="onPage"><span>Изменение пароля</span></a></dt>
            <dd>
                <fieldset>
                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'old_password', array()); ?>
                        <div class="inpC">
                            <?php echo $form->passwordField($model,'old_password',array('maxlength'=>255, 'class'=>'inp')); ?>
                        </div>
                        <?php echo $form->error($model,'old_password'); ?>
                    </div>
                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'password', array()); ?>
                        <div class="inpC">
                            <?php echo $form->passwordField($model,'password',array('maxlength'=>255, 'class'=>'inp')); ?>
                        </div>
                        <?php echo $form->error($model,'password'); ?>
                    </div>
                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'password_replace', array()); ?>
                        <div class="inpC">
                            <?php echo $form->passwordField($model,'password_replace',array('maxlength'=>255, 'class'=>'inp')); ?>
                        </div>
                        <?php echo $form->error($model,'password_replace'); ?>
                    </div>
                </fieldset>
            </dd>
        </dl>
    <?else:?>
        <div class="edit_line">
            <?php echo $form->labelEx($model,'password', array()); ?>
            <div class="inpC">
                <?php echo $form->passwordField($model,'password',array('maxlength'=>255, 'class'=>'inp')); ?>
            </div>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <div class="edit_line">
            <?php echo $form->labelEx($model,'password_replace', array()); ?>
            <div class="inpC">
                <?php echo $form->passwordField($model,'password_replace',array('maxlength'=>255, 'class'=>'inp')); ?>
            </div>
            <?php echo $form->error($model,'password_replace'); ?>
        </div>
    <?endif;?>

    <dl class="slideRow">
        <dt><a href="javascript://void(0)" class="onPage"><span>Дополнительные Параметры</span></a></dt>
        <dd>
            <fieldset>
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'email', array()); ?>
                    <div class="inpC">
                        <?php echo $form->textField($model,'email',array('maxlength'=>255, 'class'=>'inp')); ?>
                    </div>
                    <?php echo $form->error($model,'email'); ?>
                </div>
            </fieldset>
        </dd>
    </dl>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Обновить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
