<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'module-actions-category-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="tabs">
        <!-- Это сами вкладки -->
        <ul class="cf tabNavigation">
            <li class="tab_st"><a href="#first">Основные параметры</a></li>
            <li class="tab_st"><a href="#second">Краткое описание</a></li>
            <li class="tab_st"><a href="#third">Детальное описание</a></li>
        </ul>
        <!-- Это контейнеры содержимого -->
        <div id="first">
            <fieldset>
                <div class="row2 cf">

                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'name'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'name',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <?php echo $form->error($model,'name'); ?>
                    </div>

                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'code'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'code',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <?php echo $form->error($model,'code'); ?>
                    </div>

                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'active'); ?>
                        <?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'active'); ?>
                    </div>

                </div>
            </fieldset>
        </div>
        <div id="second">

            <div class="edit_line">
                <?php echo $form->labelEx($model,'short', array()); ?>
                <div class="inpC">
                    <?php echo $form->textArea($model,'short', array('rows'=> '5', 'class'=>'inp')); ?>
                </div>
                <?php echo $form->error($model,'short'); ?>
            </div>

        </div>
        <div id="third">
            <div class="edit_line">
                <?php echo $form->labelEx($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
                <?php echo $form->error($model,'text'); ?>
            </div>
        </div>

    </div>


    <div style="display: none;">
        <?php echo $form->textField($model,'mpage_id', array('value' => ModulesInPages::model()->getLink($page_id, $this->module->id))); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->