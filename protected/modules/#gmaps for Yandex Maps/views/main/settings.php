<h1 class="pTitle">Настройки: «<?=$model->title?>»</h1>
<div class="actionsList">
	&larr; <a href="<?=Yii::app()->baseUrl; ?>?r=pages/update&id=<?=$page_id;?>&/#!/tab_<?=$this->module->id?>">Назад к редактированию страницы</a>
	&uarr; <a href="<?=Yii::app()->baseUrl; ?>?r=/<?= $this->module->id ?>/main/update&page_id=<?=$page_id;?>&id=<?=$model->id?>">Карта</a>
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
                        <?php echo $form->labelEx($model,'title'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'title',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <?php echo $form->error($model,'title'); ?>
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