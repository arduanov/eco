<? $role_id = 2; ?>

<h1 class="pTitle">Редактирование «<?=$model->title?>»</h1>
<div class="actionsList">
	&larr; <a href="<?=Yii::app()->baseUrl; ?>?r=pages/update&id=<?=$page_id;?>&/#!/tab_<?=$this->module->id?>">Назад к редактированию страницы</a>
</div>

<div class="form">

    <?php
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'page-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data','data-action'=>$_SERVER['REQUEST_URI'])
	));
	?>

    <p class="note">Поля помеченные  <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="tabs">
        <!-- Это сами вкладки -->
        <ul class="cf tabNavigation">
            <li class="tab_st"><a href="#first">Основные параметры</a></li>
            <li class="tab_st"><a href="#second">Дополнительные параметры</a></li>
            <? if($page_id == 37): ?><li class="tab_st"><a href="#third">Файлы</a></li><? endif; ?>
        </ul>
        <!-- Это контейнеры содержимого -->
        <div id="first">
			
            <fieldset>
                <div class="row2 cf">

                    <div class="edit_line">
                        <?php echo $form->labelEx($model,'title'); ?>
                        <div class="inpC">
                            <?php echo $form->textField($model,'title',array('class'=>'inp' , 'size'=>60,'maxlength'=>255)); ?>
                        </div>
                        <?php echo $form->error($model,'title'); ?>
                    </div>


                    <div class="edit_line checkboxLine">
                        <?php echo $form->checkBox($model,'active', array('checked' =>($model->isNewRecord)?'checked':$model->active)); ?>
                        <?php echo $form->labelEx($model,'active', array('class'=>'labelCheckbox')); ?>
                        <?php echo $form->error($model,'active'); ?>
                    </div>


		            <div class="edit_line">
		                <?php echo $form->labelEx($model,'short', array()); ?>
		                <div class="inpC">
		                    <?php echo $form->textArea($model,'short', array('rows'=> '5', 'class'=>'inp')); ?>
		                </div>
		                <?php echo $form->error($model,'short'); ?>
		            </div>


                	<div class="edit_line">
		                <?php echo $form->labelEx($model,'text'); ?>
		                <?php echo $form->textArea($model,'text',array('class'=>'mceEditor inp', 'rows'=> '25')); ?>
		                <?php echo $form->error($model,'text'); ?>
		            </div>

                	<?php echo $form->HiddenField($model,'img_id',array('id'=>'smallImage')); ?>

	                <div style="margin-top: 20px;">
	                    <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
	                    array(
	                        'id'=>'uploadSmallImage',
	                        'config'=>array(
	                            'action'=>'/admin.php?r=Files/uploadImage&module='.$this->module->id,
	                            'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
	                    		'button_text' => 'Загрузить изображение',
	                            'sizeLimit' => '40960000',
	                            'onComplete'=>"js:function(id, fileName, responseJSON){ $('#smallImg').html('<img src=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#smallImage').val(responseJSON.image_id); $('.delete_image').show();}",
	                        ),
	                    ));
	                    ?>
	                </div>

	                <div id='smallImg'>
						<? if(count($model->img)): ?>
	                       <img src="<?=$model->img[1]?>">
	                    <?endif;?>
	                </div>
					<span class="delete_image" <?=($model->img_id)?'':'style="display:none;"'?> data-url="" data-img="smallImg" data-input="smallImage">Удалить картинку</span>
					
					
					
            </fieldset>
		</div>
        <div id="second">
			
            <fieldset>
					
			
					<? foreach($params_list as $key => $value): ?>
						<? if($role_id<2 || (($key<28 || $key>63)&($key<82 || $key>109) && $key!=25 && !((!isset($params_values_list[25]) || $params_values_list[25]['value']!=1) && $key==27))): ?>
							<? if($value['data_type_id']==1): ?>
								<div class="edit_line">
									<label for="ModuleList3Values_<?=$value['code']?>" class="required"><?=$value['title']?></label>
									<div class="inpC">
										<input class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
									</div>
								</div>
							<? endif; ?>
							<? if($value['data_type_id']==2): ?>
								<div class="edit_line checkboxLine">
									<input id="ytModuleList3Values_<?=$value['code']?>" type="hidden" value="0" name="ModuleList3Values[<?=$value['id']?>]">
									<input name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" value="1" type="checkbox" <?=(isset($params_values_list[$value['id']]) && $params_values_list[$value['id']]['value']==1)?'checked':''?>>
									<label class="labelCheckbox" for="ModuleList3Values_<?=$value['code']?>"><?=$value['title']?></label>
								</div>
							<? endif; ?>
							<? if($value['data_type_id']==3): ?>
								<div class="edit_line">
									<label for="ModuleList3Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
									<div class="inpC">
										<textarea rows="5" class="inp" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>"><?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?></textarea>
									</div>
								</div>
							<? endif; ?>
							<? if($value['data_type_id']==4): ?>
								<div class="edit_line">
									<label for="ModuleList3Values_<?=$value['code']?>" class=""><?=$value['title']?></label>
									<textarea class="mceEditor inp" rows="25" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>"><?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?></textarea>
								</div>
							<? endif; ?>
							<? if($value['data_type_id']==5): ?>
								<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
									<label><strong><?=$value['title']?></strong></label>
									<?
									$params_values = ModuleList3ParamsValues::model()->getList($value['id']);
									foreach($params_values as $key2 => $value2):
									?>
										<div class="edit_line checkboxLine">
											<input name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="radio" <?=(isset($params_values_list[$value['id']]) && $params_values_list[$value['id']]['value']==$value2['id'])?'checked':''?>>
											<label class="labelCheckbox" for="ModuleList3Values_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
										</div>
									<? endforeach; ?>
									</div>
							<? endif; ?>
							<? if($value['data_type_id']==6): ?>
								<div style="border: 1px solid #CECECE; padding: 5px; margin-bottom: 5px;">
									<label><strong><?=$value['title']?></strong></label>
									<?
									$params_values = ModuleList3ParamsValues::model()->getList($value['id']);
									$i = 0;
									foreach($params_values as $key2 => $value2):
											$i++;
											$exist_params_values = ModuleList3Values::model()->exist_value($model->id, $value['id'], $value2['id']);
									?>
										<div class="edit_line checkboxLine">
											<input id="ytModuleList3ValuesMultiply_<?=$value['code']?><?=$value2['id']?>" type="hidden" value="0" name="ModuleList3ValuesMultiply[<?=$value['id']?>][<?=$i?>]">
											<input name="ModuleList3ValuesMultiply[<?=$value['id']?>][<?=$i?>]" id="ModuleList3ValuesMultiply_<?=$value['code']?><?=$value2['id']?>" value="<?=$value2['id']?>" type="checkbox" <?=($exist_params_values)?'checked':''?>>
											<label class="labelCheckbox" for="ModuleList3ValuesMultiply_<?=$value['code']?><?=$value2['id']?>"><?=$value2['title']?></label>
										</div>
									<? endforeach; ?>
									</div>
							<? endif; ?>
						<? endif; ?>
					<? endforeach; ?>
		
		<? if($page_id == 37 && $role_id>1): ?>
			<style>
				.table-inputs .td-first div {height: 22px;}
			</style>
            <p>Ставки (обе таблицы должны быть заполнены)</p>
			<p>Декларируемая ставка</p>
			<table class="table-inputs">
				<thead>
					<tr>
						<? if(isset($params_values_list[25]) && $params_values_list[25]['value']==1): ?>
							<th style="width: 70px;">Срок</th>
							<th>RUR ( < <?=(isset($params_values_list[27]))? Yii::app()->numberFormatter->format('#,##0.',floor($params_values_list[27]['value'])):'0'?> )</th>
							<th>RUR ( &ge; <?=(isset($params_values_list[27]))? Yii::app()->numberFormatter->format('#,##0.',floor($params_values_list[27]['value'])):'0'?> )</th>
						<? else: ?>
							<th style="width: 70px;">Срок</th>
							<th>RUR</th>
							<th>USD</th>
							<th>EUR</th>
						<? endif; ?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="td-first">
							<div>31 день</div>
							<div>91 день</div>
							<div>181 день</div>
							<div>271 день</div>
							<div>370 дней</div>
							<div>740 дней</div>
							<div>1110 дней</div>
							<div>1480 дней</div>
							<div>1850 дней</div>
						</td>
						<td>
			<? if(isset($params_values_list[25]) && $params_values_list[25]['value']==1): ?>
				<?
					for($i = 28; $i < 37; $i++){
						$value = $params_list[$i];
						?>
						<? if($value['data_type_id']==1): ?>
							<div class="inpC" style="padding: 0;">
								<input style="width: 150px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
							</div>
						<? endif; ?>
				<?
					}
				?>
						</td><td>
				<?
					for($i = 55; $i < 64; $i++){
						$value = $params_list[$i];
						?>
						<? if($value['data_type_id']==1): ?>
							<div class="inpC" style="padding: 0;">
								<input style="width: 150px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
							</div>
						<? endif; ?>
				<?
					}
				?>
			<? else: ?>
				<?
					for($i = 28; $i < 55; $i++){
						$value = $params_list[$i];
						?>
						<? if($value['data_type_id']==1): ?>
							<div class="inpC" style="padding: 0;">
								<input style="width: 100px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
							</div>
						<? endif; ?>
						<?
						if($i==36 || $i==45) echo '</td><td>';
					}
				?>
			<? endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		<? endif; ?>

    <? if($page_id == 37 && $role_id>1): ?>
                <style>
                    .table-inputs .td-first div {height: 22px;}
                </style>
                <p>Эффективная ставка</p>
                <table class="table-inputs">
                    <thead>
                        <tr>
                            <? if(isset($params_values_list[25]) && $params_values_list[25]['value']==1): ?>
                                <th style="width: 70px;">Срок</th>
                                <th>RUR ( < <?=(isset($params_values_list[27]))? Yii::app()->numberFormatter->format('#,##0.',floor($params_values_list[27]['value'])):'0'?> )</th>
                                <th>RUR ( &ge; <?=(isset($params_values_list[27]))? Yii::app()->numberFormatter->format('#,##0.',floor($params_values_list[27]['value'])):'0'?> )</th>
                            <? else: ?>
                                <th style="width: 70px;">Срок</th>
                                <th>RUR</th>
                                <th>USD</th>
                                <th>EUR</th>
                            <? endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-first">
                                <div>31 день</div>
                                <div>91 день</div>
                                <div>181 день</div>
                                <div>271 день</div>
                                <div>370 дней</div>
                                <div>740 дней</div>
                                <div>1110 дней</div>
                                <div>1480 дней</div>
                                <div>1850 дней</div>
                            </td>
                            <td>
                <? if(isset($params_values_list[25]) && $params_values_list[25]['value']==1): ?>
                    <?
                        for($i = 28; $i < 37; $i++){
                            $value = $params_list[$i];
                            ?>
                            <? if($value['data_type_id']==1): ?>
                                <div class="inpC" style="padding: 0;">
                                    "<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
                                </div>
                            <? endif; ?>
                    <?
                        }
                    ?>
                            </td><td>
                    <?
                        for($i = 55; $i < 64; $i++){
                            $value = $params_list[$i];
                            ?>
                            <? if($value['data_type_id']==1): ?>
                                <div class="inpC" style="padding: 0;">
                                    <input style="width: 150px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
                                </div>
                            <? endif; ?>
                    <?
                        }
                    ?>
                <? else: ?>
                    <?
                        for($i = 82; $i < 109; $i++){
                            $value = $params_list[$i];
                            ?>
                            <? if($value['data_type_id']==1): ?>
                                <div class="inpC" style="padding: 0;">
                                    <input style="width: 100px;" class="inp" size="60" maxlength="255" name="ModuleList3Values[<?=$value['id']?>]" id="ModuleList3Values_<?=$value['code']?>" type="text" value="<?=(isset($params_values_list[$value['id']]))?$params_values_list[$value['id']]['value']:''?>">
                                </div>
                            <? endif; ?>
                            <?
                            if($i==90 || $i==99) echo '</td><td>';
                        }
                    ?>
                <? endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <? endif; ?>

                </div>
        <div id="third">
            <fieldset>
                <div class="row2 cf">
                    <div style="margin-top: 20px;">
                        <div class="catalog">
                        <?
                        if (!$files) {
                            ?> <h3>Нет файлов.</h3> <?
                        } else {?>
                                <h3>Список файлов.</h3><ul class="type_1">
                            <?

                            foreach ($files as $key=>$file) {
                                ?>
                                <li class="link ids"><a href="/admin.php?r=/<?= $this->module->id ?>/files/update&page_id=<?= $page_id ?>&item_id=<?=$model->id?>&id=<?= $key ?>" class="alert_title"><?=$file['short']?></a>
                                <a href="/admin.php?r=/<?= $this->module->id ?>/files/delete&page_id=<?= $page_id ?>&item_id=<?=$model->id?>&id=<?= $key ?>" class="delete"><img src="/admin/pics/i/del-small.png" alt="Удалить"></a><br></li>
                                <?
                            }
                            ?> </ul> <?
                        }

?>
                    </div>
                        <h3>Загрузить файл</h3>
                        <div class="edit_line">
                            <label for="ModuleList3Files_short" class="required">Описание</label>
                            <div class="inpC">
                                <input class="inp" size="60" maxlength="255" name="ModuleList3Files[short]" id="ModuleList3Files_short" type="text"">
                            </div>
                            <input name="ModuleList3Files[file_id]" id="ModuleList3Files_file" type="hidden"">
                        </div>
                        <? $this->widget('ext.EAjaxUpload.EAjaxUpload',
                        array(
                            'id'=>'uploadFile',
                            'config'=>array(
                                'action'=>'/admin.php?r=Files/uploadFile&module='.$this->module->id,
                                'allowedExtensions'=>array("pdf","doc", "docx", "xls", "xlsx"),
                                'button_text' => 'Загрузить файл',
                                'sizeLimit' => '40960000',
                                'onComplete'=>"js:function(id, fileName, responseJSON){ $('#ModuleList3Files_file').html('<a href=\'/upload/".md5($this->module->id)."/'+responseJSON.filename+'\' />'); $('#ModuleList3Files_file').val(responseJSON.image_id); }"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </fieldset>
        </div>
            </fieldset>
		</div>
	</div>

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