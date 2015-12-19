<fieldset>
	<div class="js_tabs">
		<a href="#add_catalog"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?' class="active"':''?>>Добавить</a>
		<div class="js_tabs_container" id="add_catalog"<?=(Yii::app()->user->hasFlash($this->module_id.'_add_message'))?'':' style="display:none"'?>>

		<p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'module-catalog-form',
			'action'=>'/admin.php?r=/pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id,
			'enableAjaxValidation'=>false,
		)); ?>
			<div class="edit_line">
                <?php echo $form->labelEx($model,'title'); ?>
                <div class="inpC">
                    <?php echo $form->textField($model,'title',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
                </div>
                <?php echo $form->error($model,'title'); ?>
            </div>

            <div class="edit_line">
                <?php echo $form->labelEx($model,'link'); ?>
                <div class="inpC">
                    <?php echo $form->textField($model,'link',array('class'=>'inp', 'size'=>60,'maxlength'=>255)); ?>
                </div>
                <?php echo $form->error($model,'link'); ?>
            </div>

            <div class="edit_line">
                <?php echo $form->labelEx($model,'parent_id'); ?>
                <div class="inpC">
                    <?php echo $form->dropDownList($model,'parent_id',$dropdown,array('class' => 'inp')); ?>
                </div>
                <?php echo $form->error($model,'parent_id'); ?>
            </div>

			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
			</div>
			<?
			if(Yii::app()->user->hasFlash($this->module_id.'_add_message')){
				echo Yii::app()->user->getFlash($this->module_id.'_add_message');
			}
			?>
		<?php $this->endWidget(); ?>
		</div>
	</div>
	<div class="catalog">
    <?
        foreach ($dropdown as $key => $item) {
            if ($key == 0) continue;
            $i = 0;
            $str = preg_replace('/^——/','',$item,-1,$count);
            if ($count > 0) {
                while ($count > 0) {
                    $str =preg_replace('/^——/','',$str,-1,$count);
                    $i++;
                }
            }
        ?>
                <div style="margin-left: <?=45*$i?>px;">
                    <a href="/admin.php?r=/helper/main/update&page_id=<?=$page_id?>&id=<?=$key?>" class="alert_title"><img src="/admin/pics/i/edit.png" alt="Редактировать"></a>
                    <a href="/admin.php?r=/helper/main/delete&page_id=<?=$page_id?>&id=<?=$key?>" class="delete" style="display: inline;"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a>
                    <span class="alert_title"><?=$str?></span>
                </div>
        <?
        }
    ?>
        </ul>
	</div>
</fieldset>