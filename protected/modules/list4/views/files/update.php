<h1>Редактирование файла</h1>
<div class="actionsList">
    &larr; <a href="<?= Yii::app()->baseUrl; ?>?r=<?=$this->module->id?>/main/update&page_id=<?= $page_id; ?>&id=<?=$item_id?>&/#!/tab_third">Назад к редактированию элемента</a>
</div>
    <div class="form">
        <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
        <fieldset>

    <?php
	$form = $this->beginWidget('CActiveForm', array(
        'id'=>'page-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype'=>'multipart/form-data','data-action'=>$_SERVER['REQUEST_URI'])
    ));
	?>
            <div class="edit_line">
                <?php echo $form->labelEx($model, 'short'); ?>
                <div class="inpC">
                    <?php echo $form->textField($model, 'short', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
                </div>
                <?php echo $form->error($model, 'short'); ?>
            </div>
            <h3>Заменить файл</h3>
            <div class="edit_line">
                <?php echo $form->hiddenField($model, 'file_id'); ?>
            </div>
            <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
            array(
                'id'=>'uploadFile',
                'config'=>array(
                    'action'=>'/admin.php?r=Files/uploadFile&module='.$this->module->id,
                    'allowedExtensions'=>array("pdf","doc", "docx", "xls", "xlsx"),
                    'button_text' => 'Загрузить файл',
                    'sizeLimit' => '40960000',
                    'onComplete'=>"js:function(id, fileName, responseJSON){ $('#ModuleList4Files_file_id').html('<a href=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#ModuleList4Files_file_id').val(responseJSON.image_id); }"
                ),
            ));
            ?>
            </div>
            <div class="row buttons">
                <?php echo CHtml::submitButton('Сохранить'); ?>
            </div>

            <?
            if(Yii::app()->user->hasFlash('message')){
                echo Yii::app()->user->getFlash('message');
            }
            ?>
            <?php $this->endWidget(); ?>
            </fieldset>
        </div>