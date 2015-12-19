<?php

class MainController extends BackEndController
{
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleGallery::model()->existsItem($link_id,$id)){
				$model = ModuleGallery::model()->findByPk($id);
				if(isset($_POST['ModuleGallery'])){
					$old_file_id = $model->photo_id;
					if($_POST['ModuleGallery']['photo_id']=='NULL') $_POST['ModuleGallery']['photo_id'] = '';
					$model->attributes = $_POST['ModuleGallery'];
					if((int)$_POST['ModuleGallery']['photo_id']) Files::model()->saveTempFile((int)$_POST['ModuleGallery']['photo_id']);
						elseif($_POST['ModuleGallery']['photo_id']=='') Files::model()->deleteFile($old_file_id,$this->module->id);
					if($model->save()){
						if($old_file_id!=$model->photo_id) Files::model()->deleteFile($old_file_id,$this->module->id);
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleGallery::model()->getItem($id,$link_id);
				$this->update_order($page_id,$id);
				$this->render('update', array('page_id' => $page_id, 'model' => $model));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
	
	/* Обнвление порядка сортировки */
	protected function update_order($page_id = null, $gallery_id = null){
		$controller = Yii::app()->getController();
		if(isset($_POST['type']) && $_POST['type']==$this->module->id){
			foreach(array('ids'=>'rktv_module_'.$this->module->id.'_photos') as $k=>$v){
				if(isset($_POST[$k]) && !empty($_POST[$k])){
					$out = "UPDATE $v SET order_id= CASE";
					$id = $_POST[$k];
					$id = explode(',',$id);
					for($i=count($id); $i>0; $i--){
						$out .= " WHEN id='".intval($id[count($id)-$i])."' THEN '$i'";
					}
					$out .= " ELSE order_id END";
					$connection = Yii::app()->db;
					$command = $connection->createCommand($out);
					$out = $command->execute();
				}
			}
			Yii::app()->user->setFlash($this->module->id.'_order_message','<p style="color:green;">Сохранено</p>');
			$controller->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$gallery_id);
		}
	}
	
    public function actionUpdate_settings($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleGallery::model()->existsItem($link_id,$id)){
				$model = ModuleGallery::model()->findByPk($id);
				if(isset($_POST['ModuleGallery'])){
					$model->attributes = $_POST['ModuleGallery'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update_settings&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleGallery::model()->getItem($id,$link_id);
				$this->render('update_settings', array('page_id' => $page_id, 'model' => $model));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update_settings&page_id='.$page_id.'&id='.$id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
	
    public function actionUpload($gallery_id = null, $page_id = null, $width = null, $height = null, $resize = false, $compare_width = null, $compare_height = null){
		$out = array();
		$module = $this->module->id;
		if(!is_null($gallery_id) && !is_null($page_id) && !is_null($module)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $module);
			if(!is_null($gallery_id) && ModuleGallery::model()->existsItem($link_id,$gallery_id)){
				$out = Files::model()->imageUpload($module, $width, $height, $resize, $compare_width, $compare_height);
				if(!isset($out['error']) && isset($out['filename']) && isset($out['image_id'])){
					// добавление фотки
					$image_name = $out['filename'];
					$image_id = $out['image_id'];
					Files::model()->saveTempFile((int)$image_id);
					$model = new ModuleGalleryPhotos();
					$data = 
					$model->attributes = array(
						'title'=>$image_name,
						'gallery_id'=>$gallery_id,
						'file_id'=>$image_id
					);
					$model->save();
					$img = ModuleGalleryPhotos::model()->getImageById($image_id);
					$out['html'] = '
								<li data-id="'.$model->id.'" class="link ids" id="gallery_photo_'.$model->id.'">
									<figure class="thumb" style="margin:0; min-width:0; background:#FFF; padding:7px 7px 0 7px; border:1px solid #CECECE;">
										<div style="min-width:0; background:#FFF; overflow:hidden; position:relative; padding-bottom:30px; text-align:center;">
											<div class="thumb_img" style="text-align:center; width:auto;">
												<img src="'.$img[0].'">		
											</div>
											<p class="note" style="position:absolute; margin:5px 0 0 0;">'.$model->title.'</p>
										</div>
										<figcaption>
											<div class="bg"></div>
											<div class="thumb_controls">
												<ul>
													<li class="tEnlarge"><a href="'.$img[1].'" rel="gal">Увеличить</a></li>
													<li class="tDelete"><a href="javascript:void(0)" data-id="'.$model->id.'">Удалить</a></li>
												</ul>
											</div>
										</figcaption>
									</figure>
								</li>
					';
				}
			}
		}
		echo json_encode($out);
    }
	
	public function actionDelete_photo($id = null){
		$out = '';
		if(ModuleGalleryPhotos::model()->deleteItem($id,$this->module->id)) $out = '0';
			else $out = '1';
		echo $out;
	}

    public function actionDelete($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(ModuleGallery::model()->deleteItem($link_id,$id,$this->module->id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }

	/* Публикация альбома */
    public function actionActivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleGallery::model()->existsItem($link_id,$id)) ModuleGallery::model()->updateByPk($id,array('active'=>1));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

	/* Снятие с публикации альбома */
    public function actionDeactivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleGallery::model()->existsItem($link_id,$id)) ModuleGallery::model()->updateByPk($id,array('active'=>0));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
	
	/* Активация модуля */
    public function actionActivation($page_id = null){
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id)) ModulesInPages::model()->addLink($this->module_id, $page_id);
        $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
    }	
    
    /* Деактивация модуля */
    public function actionDeactivation($page_id = null){
        $result = false;
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
            if($link_id) $result = ModuleGallery::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
			else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }
}