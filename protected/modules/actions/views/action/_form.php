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

                    <div class="edit_line edit_line_right_date lastLine">
                        <?php echo $form->labelEx($model,'date_end'); ?>
                        <div class="inpC dateInpC">
                            <input type="text" value="<?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $model->isNewRecord ? date('Y-m-d'):$model->date_end);?>" id="edit_date_end" class="inp datepicker">
                        </div>
                        <?php echo $form->error($model,'date'); ?>
                    </div>
                    <div class="edit_line lastLine" style="display:none;">
                        <?php echo $form->textField($model,'date_end', array('id'=>'altDateField', 'value' => $model->isNewRecord ? date('Y-m-d'):$model->date_end, 'type'=>"hidden")); ?>
                    </div>


                    <div class="edit_line edit_line_right_date lastLine">
                        <?php echo $form->labelEx($model,'date_begin'); ?>
                        <div class="inpC dateInpC">
                            <input type="text" value="<?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $model->isNewRecord ? date('Y-m-d'):$model->date_begin);?>" id="edit_date_begin" class="inp datepicker2">
                        </div>
                        <?php echo $form->error($model,'date'); ?>
                    </div>
                    <div class="edit_line lastLine" style="display:none;">
                        <?php echo $form->textField($model,'date_begin', array('id'=>'altDateField2', 'value' => $model->isNewRecord ? date('Y-m-d'):$model->date_begin, 'type'=>"hidden")); ?>
                    </div>



                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'name'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'name',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <?php echo $form->error($model,'name'); ?>
                    </div>

                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'action_category_id', array()); ?>
                        <div class="inpC">
                            <?php echo $form->dropDownList($model, 'action_category_id', ModuleActions::model()->getCategoryList($page_id), array('class'=>'inp', 'options' => array(0  => array('selected'=>true)))); ?>
                        </div>
                        <?php echo $form->error($model,'action_category_id'); ?>
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

                <?php echo $form->HiddenField($model,'small_img_id',array('id'=>'smallImage')); ?>

                <div style="margin-top: 20px;">
                    <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
                    array(
                        'id'=>'uploadSmallImage',
                        'config'=>array(
                            'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id,
                            'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
                            'sizeLimit' => '40960000',
                            'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#smallImage').val(responseJSON.image_id);}",
                        ),
                    ));
                    ?>
                </div>

                <div id='smallImg'>
                    <?php if(!$model->isNewRecord && isset($images['small']) && !empty($images['small'])):?>
                        <img src="<?php echo $images['small'];?>" />
                    <?endif;?>
                </div>

            </div>
        </div>
        <div id="third">
            <div class="edit_line">
                <?php echo $form->labelEx($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
                <?php echo $form->error($model,'text'); ?>

                <?php echo $form->HiddenField($model,'large_img_id',array('id'=>'largeImage')); ?>

                <!--
                    your insert resolution is ...
                    compare_type:{
                        1 - >
                        2 - <
                        3 - =
                        4 - >=
                        5 - <=
                    }

                -->
                <div style="margin-top: 20px;">
                    <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
                    array(
                        'id'=>'uploadLargeImage',
                        'config'=>array(
                            'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id,
                            'allowedExtensions'=>array("jpeg", "jpg", "png", "gif", "bmp"),
                            'sizeLimit' => '40960000',
                            'onComplete'=>"js:function(id, fileName, responseJSON){ $('#largeImg').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#largeImage').val(responseJSON.image_id);}",
                        ),
                    ));
                    ?>
                </div>


                <div id='largeImg'>
                    <?php if(!$model->isNewRecord && isset($images['large']) && !empty($images['large'])):?>
                        <img src="<?php echo $images['large'];?>" />
                    <?endif;?>
                </div>

            </div>
        </div>
    </div>



    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->