<h1 class="pTitle">Фотокарточки альбома «<?=$model->title?>»</h1>
<div class="actionsList">
	<b>&larr;</b>&nbsp;<a href="<?=Yii::app()->baseUrl?>?r=pages/update&id=<?=$page_id;?>&/#!/tab_<?=$this->module->id?>">Назад к редактированию страницы</a>
	<b>&darr;</b>&nbsp;<a href="/admin.php?r=/<?=$this->module->id?>/main/update_settings&page_id=<?=$page_id?>&id=<?=$model->id?>">Настройки</a>
</div>




<div style="margin-top: 20px;">
	<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
	array(
		'id'=>'uploadSmallImage',
		'config'=>array(
			'multiple'=>true,
			'action'=>'/admin.php?r=/'.$this->module->id.'/main/upload&gallery_id='.$model->id.'&resize=1&width=1300&height=1300&page_id='.$page_id,
			'allowedExtensions'=>array("jpeg","jpg", "png", "gif", "bmp"),
			'button_text' => 'Загрузить изображения',
			'sizeLimit' => '40960000',
			'onComplete'=>"js:function(id, fileName, responseJSON){
				$('#gallery').append($(responseJSON.html));
				if($('#gallery > li').length>1) $('.sortable_form').show();
			}",
		),
	));
	?>
</div>




	<p class="note"><?=$model->short?></p>

            <fieldset>
                <div class="row2 cf">
					
					
					
					<?
					$photos = new ModuleGalleryPhotos;
					$photos = $photos->getList($model->id);
					?>
					<p id="gallery_note_message" style="<?=(count($photos))?'display:none;':''?>">Фотокарточек пока нет. Для того, чтобы загрузить фотокарточки, нажмите на кнопку «Загрузить изображения» и выберите одну или несколько файлов. По мере того, как файлы будут загружаться, фотокарточки будут появляться ниже.</p>
					
					<div id="edit_gallery" class="thumbs clearfix">
						<ul class="<?=(count($photos)>1)?'sortable':'sortable'?> type_3" id="gallery">
							<?php foreach($photos as $value):?>
								<li data-id="<?=$value->id?>" class="link ids" id="gallery_photo_<?=$value->id?>">
									<figure class="thumb" style="margin:0; min-width:0; background:#FFF; padding:7px 7px 0 7px; border:1px solid #CECECE;">
										<div style="min-width:0; background:#FFF; overflow:hidden; position:relative; padding-bottom:30px; text-align:center;">
											<div class="thumb_img" style="text-align:center; width:auto;">
												<img src="<?=$value->img[0]?>">		
											</div>
											<p class="note" style="position:absolute; margin:5px 0 0 0;"><?=$value->title?></p>
										</div>
										<figcaption>
											<div class="bg"></div>
											<div class="thumb_controls">
												<ul>
													<li class="tEnlarge"><a href="<?=$value->img[1]?>" rel="gal">Увеличить</a></li>
													<li class="tDelete"><a href="javascript:void(0)" data-id="<?=$value->id?>">Удалить</a></li>
												</ul>
											</div>
										</figcaption>
									</figure>
								</li>
							<?endforeach;?>
						</ul>
					</div>
					
					
					
					

                </div>

            </fieldset>


						<? if(count($photos) > 1 || true): ?>
							<form class="sortable_form" method="POST" action="/admin.php?r=/<?=$this->module->id?>/main/update&page_id=<?=$page_id?>&id=<?=$model->id?>" style="<?=(count($photos)>1)?'':'display:none;'?>">
								<input type="hidden" name="type" value="<?=$this->module->id?>">
								<input type="hidden" name="ids" value="">
								<input type="submit" value="Сохранить порядок сортировки" style="margin-bottom:20px;">
							</form>
							<?
							if(Yii::app()->user->hasFlash($this->module->id.'_order_message')){
								echo Yii::app()->user->getFlash($this->module->id.'_order_message');
							}
							?>
						<? endif; ?>
	
	<?
	if(Yii::app()->user->hasFlash('message')){
		echo Yii::app()->user->getFlash('message');
	}
	?>


</div><!-- form -->