<h1 class="pTitle">Редактирование новости</h1>
<div class="actionsList">
	<a href="<?=Yii::app()->baseUrl; ?>?r=pages/update&id=<?=$page_id;?>&/#!/tab_<?=$this->module->id?>">Назад к редактированию страницы</a>
</div>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'module-product-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
    <p class="note">Доступные расширения файлов: .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .odf, .rtf, .txt, .rar, .zip, .7z, .jpeg, .jpg, .png, .gif, .bmp<br>Максимальный размер файла: 10 Mb.</p>

    <?php echo $form->errorSummary($model); ?>

            <fieldset>
                <div class="row2 cf">


                    <div class="edit_line edit_line_right_date lastLine">
                        <?php echo $form->labelEx($model,'date'); ?>
                        <div class="inpC dateInpC">
                            <input type="text" value="<?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $model->isNewRecord ? date('Y-m-d'):$model->date);?>" id="edit_date_begin" class="inp datepicker2">
                        </div>
                        <?php echo $form->error($model,'date'); ?>
                    </div>
                    <div class="edit_line lastLine" style="display:none;">
                        <?php echo $form->textField($model,'date', array('id'=>'altDateField2', 'value' => $model->isNewRecord ? date('Y-m-d'):$model->date, 'type'=>"hidden")); ?>
                    </div>

                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'title'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'title',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <?php echo $form->error($model,'title'); ?>
                    </div>
			
					<?
					$list4_mpage_id = ModulesInPages::model()->getLink($page_id,'list4');
					if($list4_mpage_id>0):
						$ModuleList4 = ModuleList4::model()->getList($list4_mpage_id);
						if(count($ModuleList4)):
							$dropdown = array(0 => 'Без группы');
							foreach($ModuleList4 as $k => $v){
								$dropdown[$k] = $v->title;
							}
					?>
					
							<div class="edit_line">
								<?php echo $form->labelEx($model,'group_id'); ?>
								<div class="inpC">
									<?php echo $form->dropDownList($model,'group_id',$dropdown,array('class' => 'inp')); ?>
								</div>
								<?php echo $form->error($model,'group_id'); ?>
							</div>
						<? endif; ?>
					<? endif; ?>


                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'checked':$model->active)); ?>
                        <?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'active'); ?>
                    </div>
			
					<div class="edit_line">
						<?php echo $form->labelEx($model,'text', array()); ?>
						<div class="inpC">
							<?php echo $form->textArea($model,'text', array('rows'=> '5', 'class'=>'inp')); ?>
						</div>
						<?php echo $form->error($model,'text'); ?>
					</div>

                	<?php echo $form->HiddenField($model,'file_id',array('id'=>'smallImage')); ?>

	                <div style="margin-top: 20px;">
	                    <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
	                    array(
	                        'id'=>'uploadSmallImage',
	                        'config'=>array(
                                'button_text'=>'Загрузить файл',
								'action'=>'/admin.php?r=Files/uploadFile&module='.$this->module->id,
	                            'allowedExtensions'=>array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "odf", "rtf", "txt", "rar", "zip", "7z", "jpeg","jpg", "png", "gif", "bmp"),
	                            'sizeLimit' => '63000000',
	                            'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg').html('<h1>'+responseJSON.filename+'</h1>'); $('#smallImage').val(responseJSON.image_id); $('.delete_image').show();}",
	                        ),
	                    ));
	                    ?>
	                </div>

	                <div id='smallImg'>
						<? if($model->file_id): ?>
                            <? $file_name = explode('/',$model->link); 
                            $file_name = $file_name[count($file_name)-1]; ?>
	                        <h1><?=$file_name?></h1>
	                    <?endif;?>
	                </div>
					<span class="delete_image" <?=($model->file_id)?'':'style="display:none;"'?> data-url="" data-img="smallImg" data-input="smallImage">Удалить файл</span>

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