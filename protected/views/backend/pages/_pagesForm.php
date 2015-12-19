<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
?>
<div class="form">
    <div class="tabs">
        <!-- Это сами вкладки -->
        <ul class="cf tabNavigation">
            <? if(!$model->isNewRecord && count($active) > 0): ?>
				<? foreach($active as $value): ?>
					<?
					if($value['code']=='list4'){
						$page_id = $model->id;
						$mpage_id = ModulesInPages::model()->getLink($page_id, $value['code']);
						$module_settings = ModuleList4Settings::model()->getItem($mpage_id);
						if(!is_null($module_settings)) $title = $module_settings->title;
							else $title = $value['name'];
					}else{
						$title = $value['name'];
					}
					?>
					<?
					if($role_id==7 && $value['code']!='quotes')
						continue;
					?>
					<li class="tab_st" ><a href="#<? echo $value['code'];?>"><?=$title?></a></li>
                <? endforeach;?>
            <? endif;?>
            <?if($role_id!=7):?>
            <li class="tab_st"><a href="#third">Детальное описание</a></li>
            <li class="tab_st"><a href="#second">Краткое описание</a></li>
            <li class="tab_st"><a href="#first">Настройка раздела</a></li>
            <?endif;?>
            <?php if(!$model->isNewRecord && Yii::app()->user->login == 'reaktive'):?>
                <li class="tab_st"><a href="#fourth">Управление модулями</a></li>
            <?php endif;?>
        </ul>
        <!-- Это контейнеры содержимого -->

		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'page-form',
			'action'=> $_SERVER['REQUEST_URI'],
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype'=>'multipart/form-data','data-action'=>$_SERVER['REQUEST_URI']),
		)); ?>
        <div id="first">
            <fieldset>
				<?php //echo $form->errorSummary($model); ?>
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'name', array()); ?>
                    <div class="inpC">
                        <?php echo $form->textField($model,'name',array('maxlength'=>255, 'class'=>'inp')); ?>
                    </div>
                    <?php echo $form->error($model,'name'); ?>
                </div>
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'sort', array()); ?>
                    <div class="inpC">
                        <?php echo $form->textField($model,'sort',array('maxlength'=>255, 'class'=>'inp')); ?>
                    </div>
                    <?php echo $form->error($model,'sort'); ?>
                </div>
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'code', array()); ?>
                    <div class="inpC">
                        <?php echo $form->textField($model,'code',array('maxlength'=>255, 'class'=>'inp')); ?>
                    </div>
                    <?php echo $form->error($model,'code'); ?>
                </div>
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'title', array()); ?>
                    <div class="inpC">
                        <?php echo $form->textField($model,'title',array('maxlength'=>255, 'class'=>'inp')); ?>
                    </div>
                    <?php echo $form->error($model,'title'); ?>
                </div>

                <?php

                $page_id_data = array('' => 'Без родителя');

                $notIn = null;
                if(!$model->isNewRecord)
                    $notIn = $model->id;

                $page_id_data = $model->getIdArray(null, $page_id_data, '', $notIn);

                ?>
                <div class="edit_line">
                    <?php echo $form->labelEx($model,'parent_id', array()); ?>
                    <div class="inpC">
                        <?php echo $form->dropDownList($model, 'parent_id', $page_id_data, array('class'=>'inp', 'options' => array(0  => array('selected'=>true)))); ?>
                    </div>
                    <?php echo $form->error($model,'parent_id'); ?>
                </div>

                <div class="edit_line checkboxLine">
                    <?php echo $form->checkBox($model,'active'); ?>
                    <?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
                    <?php echo $form->error($model,'active'); ?>
                </div>
				
				<h2>SEO-тэги</h2>
				
				<div class="edit_line">
					<?php echo $form->labelEx($model,'meta_keywords', array()); ?>
					<div class="inpC">
						<?php echo $form->textArea($model,'meta_keywords', array('rows'=> '2', 'class'=>'inp')); ?>
					</div>
					<?php echo $form->error($model,'meta_keywords'); ?>
				</div>
				<div class="edit_line">
					<?php echo $form->labelEx($model,'meta_description', array()); ?>
					<div class="inpC">
						<?php echo $form->textArea($model,'meta_description', array('rows'=> '2', 'class'=>'inp')); ?>
					</div>
					<?php echo $form->error($model,'meta_description'); ?>
				</div>
				
				<div class="edit_line buttons">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать раздел' : 'Обновить раздел'); ?>
				</div>
            </fieldset>
        </div>

        <div id="second">
            <fieldset>
				<div class="edit_line">
					<?php echo $form->labelEx($model,'short', array()); ?>
					<div class="inpC">
						<?php echo $form->textArea($model,'short', array('rows'=> '5', 'class'=>'inp')); ?>
					</div>
					<?php echo $form->error($model,'short'); ?>
				</div>
				<div class="edit_line buttons">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать раздел' : 'Обновить раздел'); ?>
				</div>
            </fieldset>
        </div>

        <div id="third">
            <fieldset>
				<div class="edit_line">
					<?php echo $form->labelEx($model,'text'); ?>
					<?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
					<?php echo $form->error($model,'text'); ?>
				</div>
				<?php echo $form->HiddenField($model,'image_id',array('id'=>'smallImage')); ?>

				
				<div style="margin-top: 20px;">
					<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
					array(
						'id'=>'uploadSmallImage',
						'config'=>array(
							'action'=>'/admin.php?r=Files/uploadImage&module=page',
							'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
							'button_text' => 'Загрузить изображение',
							'sizeLimit' => '40960000',
							'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg').html('<img src=\'/upload/".md5('page')."/'+responseJSON.filename+'\' alt=\'\'>'); $('#smallImage').val(responseJSON.image_id); $('#delete_smallImgCatalog').show();}",
						),
					));
					?>
				</div>
				<div id='smallImg'>
					<?php if(!$model->isNewRecord && isset($image) && !empty($image)):?>
						<img src="/<?php echo $image;?>" />
					<?endif;?>
				</div>
				<span class="delete_image" id="delete_smallImg" <?=(!empty($image))?'':'style="display:none;"'?> data-url="" data-img="smallImg" data-input="smallImage">Удалить картинку</span>
				
				
				<div class="edit_line buttons">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать раздел' : 'Обновить раздел'); ?>
				</div>
            </fieldset>
        </div>
		<?php $this->endWidget(); ?>
		
		
		
		
		
        <div id="fourth">
            <?if(!$model->isNewRecord):?>
                <?php $this->widget('application.components.backend.pageModules.PageModules', array('page_id'=>$model->id)); ?>
            <?endif;?>
        </div>
        <? if(!$model->isNewRecord && count($active) > 0): ?>
            <? $codeString = ''; ?>
            <? foreach($active as $value): ?>
				<?
                if($role_id==7 && $value['code']!='quotes')
                    continue;
				// print_r(Yii::app()->getController());
				$module = Yii::app()->getModule($value['code']);
				// if(!is_null($controller)) list($controller) = Yii::app()->createController($module->id.'/'.'main',$controller);
				// else list($controller) = Yii::app()->createController($module->id.'/'.'main');
				
				// $new = new CWebApplication();
				// list($controller) = Yii::app()->createController($module->id.'/'.'main');
				
				// $controller = Yii::app()->setController($module->id.'/'.'main');
				// echo $module->id;
				if($value['code']=='catalog'){
				?>
					<div id="<?=$value['code'];?>">
						<? $controller->index_for_page_update($model->id); ?>
					</div>
					<div id="<?=$value['code'];?>_item">
						<? $controller->item_for_page_update($model->id); ?>
					</div>
					<div id="<?=$value['code'];?>_accessories">
						<? $controller->accessories_for_page_update($model->id); ?>
					</div>
				<? }else{
				
					// $this->beginClip('content');
					// list($controller,$actionID)=Yii::app()->createController($module->id.'/main/index');
					// $oldController=Yii::app()->getController();
					// Yii::app()->setController($controller);
					// $controller->init();
					// $controller->actionIndex($model->id, $page);
					// Yii::app()->setController($oldController);
					// $this->endClip('content');
					// echo $this->clips['content'];
					
					// Yii::import('application.modules.'.$module->id.'.controllers.mainController');
					// mainController::actionIndex($model->id, $page);
					
					// Yii::app()->runController($module->id.'/main/index');
				?>
					<div id="<?=$value['code'];?>">
						<? //$controller->actionIndex($model->id, $page); ?>
						<?
						$this->widget('application.modules.'.$module->id.'.components.Module_'.$module->id,array('page_id'=>$model->id, 'page'=>$page));
						// $this->beginClip('content');
						// Yii::app()->runController($module->id.'/main/index');
						// $this->endClip('content');
						// echo $this->clips['content'];
						?>
					</div>
				<? };?>
            <? endforeach;?>
        <? endif;?>
		
		
		
    </div>
</div><!-- form -->