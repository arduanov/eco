<h1 class="pTitle">Редактирование значения параметра «<?=$item->title?>»</h1>
<div class="actionsList">
	&larr; <a href="/admin.php?r=/<?= $this->module->id ?>/params/update&page_id=<?= $page_id ?>&id=<?=$param_id?>">Назад к списку значений параметра</a>
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

                    <?php echo $form->errorSummary($model); ?>
					<div class="edit_line">
						<?php echo $form->labelEx($model, 'title'); ?>
						<div class="inpC">
							<?php echo $form->textField($model, 'title', array('class' => 'inp', 'size' => 60, 'maxlength' => 255)); ?>
						</div>
						<?php echo $form->error($model, 'title'); ?>
					</div>
					<? if(in_array($page_id,array(40,41,110,111,112))): ?>
                        <div class="edit_line checkboxLine">
                            <input id="ytModuleList3ParamsValues_check_1" type="hidden" value="0" name="ModuleList3ParamsValues[check_1]">
                            <input name="ModuleList3ParamsValues[check_1]" id="ModuleList3ParamsValues_check_1" value="1" type="checkbox" <?=($model->check_1=='1')?'checked':''?>>
                            <label class="labelCheckbox" for="ModuleList3ParamsValues_check_1">Скрыть для раздела «<?=Pages::model()->findByPk(40)->name?>»</label>
                        </div>
                        <div class="edit_line checkboxLine">
                            <input id="ytModuleList3ParamsValues_check_2" type="hidden" value="0" name="ModuleList3ParamsValues[check_2]">
                            <input name="ModuleList3ParamsValues[check_2]" id="ModuleList3ParamsValues_check_2" value="1" type="checkbox" <?=($model->check_2=='1')?'checked':''?>>
                            <label class="labelCheckbox" for="ModuleList3ParamsValues_check_2">Скрыть для раздела «<?=Pages::model()->findByPk(41)->name?>»</label>
                        </div>
                        <div class="edit_line checkboxLine">
                            <input id="ytModuleList3ParamsValues_check_3" type="hidden" value="0" name="ModuleList3ParamsValues[check_3]">
                            <input name="ModuleList3ParamsValues[check_3]" id="ModuleList3ParamsValues_check_3" value="1" type="checkbox" <?=($model->check_3=='1')?'checked':''?>>
                            <label class="labelCheckbox" for="ModuleList3ParamsValues_check_3">Скрыть для раздела «<?=Pages::model()->findByPk(110)->name?>»</label>
                        </div>
                        <div class="edit_line checkboxLine">
                            <input id="ytModuleList3ParamsValues_check_4" type="hidden" value="0" name="ModuleList3ParamsValues[check_4]">
                            <input name="ModuleList3ParamsValues[check_4]" id="ModuleList3ParamsValues_check_4" value="1" type="checkbox" <?=($model->check_4=='1')?'checked':''?>>
                            <label class="labelCheckbox" for="ModuleList3ParamsValues_check_4">Скрыть для раздела «<?=Pages::model()->findByPk(111)->name?>»</label>
                        </div>
                        <div class="edit_line checkboxLine">
                            <input id="ytModuleList3ParamsValues_check_5" type="hidden" value="0" name="ModuleList3ParamsValues[check_5]">
                            <input name="ModuleList3ParamsValues[check_5]" id="ModuleList3ParamsValues_check_5" value="1" type="checkbox" <?=($model->check_5=='1')?'checked':''?>>
                            <label class="labelCheckbox" for="ModuleList3ParamsValues_check_5">Скрыть для раздела «<?=Pages::model()->findByPk(112)->name?>»</label>
                        </div>
					<? endif; ?>

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