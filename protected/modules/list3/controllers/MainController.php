<?php

class MainController extends BackEndController
{
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList3::model()->existsItem($mpage_id,$id)){
				
				// обработка параметров с одним значением
				if(isset($_POST['ModuleList3Values']) && is_array($_POST['ModuleList3Values']) && count($_POST['ModuleList3Values'])){
					foreach($_POST['ModuleList3Values'] as $key => $value){
						ModuleList3Values::model()->new_value($id, (int)$key, '0');
						if(ModuleList3Values::model()->existsItem($id, (int)$key)){
							$params_value = ModuleList3Values::model()->getItem($id, (int)$key);
							$params_value->attributes = array('value' => $value);
							$params_value->save();
							$criteria = new CDbCriteria();
							$criteria->condition = 'param_id = :param_id AND item_id = :item_id AND id <> :id';
							$criteria->params = array('param_id' => (int)$key, 'item_id' => $id, 'id' => $params_value->id);
							ModuleList3Values::model()->deleteAll($criteria);
						}else{
							$params_value = new ModuleList3Values();
							$params_value->attributes = array(
								'param_id' => (int)$key,
								'item_id' => $id,
								'value' => $value
							);
							$params_value->save();
						}
					}
				}
				// обработка параметров с несколькими значениями
                if(isset($_POST['ModuleList3Files'])) {
                    $list3file = new ModuleList3Files();
                    $list3file->short = $_POST['ModuleList3Files']['short'];
                    $list3file->file_id = $_POST['ModuleList3Files']['file_id'];
                    $list3file->item_id = $id;
                    if ($list3file->save()) {
                        Files::model()->saveTempFile((int)$list3file->file_id);
                    }
                    else {
                        Files::model()->deleteFile($list3file->file_id,$this->module->id);
                        Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
                    }
                }
				if(isset($_POST['ModuleList3ValuesMultiply']) && is_array($_POST['ModuleList3ValuesMultiply']) && count($_POST['ModuleList3ValuesMultiply'])){
					foreach($_POST['ModuleList3ValuesMultiply'] as $key => $value){
						ModuleList3Values::model()->new_value($id, (int)$key, '0');
						foreach($value as $key2 => $value2){
							if(ModuleList3Values::model()->existsItem($id, (int)$key, '0')){
								$params_value = ModuleList3Values::model()->getItem($id, (int)$key, '0');
								$params_value->attributes = array('value' => $value2);
								$params_value->save();
							}else{
								$params_value = new ModuleList3Values();
								$params_value->attributes = array(
									'param_id' => (int)$key,
									'item_id' => $id,
									'value' => $value2
								);
								$params_value->save();
							}
						}
					}
				}
				
				$model = ModuleList3::model()->findByPk($id);
				if(isset($_POST['ModuleList3'])){
					$old_file_id = $model->img_id;
					if($_POST['ModuleList3']['img_id']=='NULL') $_POST['ModuleList3']['img_id'] = '';
					$model->attributes = $_POST['ModuleList3'];
					if((int)$_POST['ModuleList3']['img_id']) Files::model()->saveTempFile((int)$_POST['ModuleList3']['img_id']);
						elseif($_POST['ModuleList3']['img_id']=='') Files::model()->deleteFile($old_file_id,$this->module->id);
                    if($model->save()){
						if($old_file_id!=$model->img_id) Files::model()->deleteFile($old_file_id,$this->module->id);
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleList3::model()->getItem($id,$mpage_id);
				if($mpage_id==5) $mpage_id = 4;
				if($mpage_id==54) $mpage_id = 4;
				if($mpage_id==56) $mpage_id = 4;
				if($mpage_id==58) $mpage_id = 4;
				$params_list = ModuleList3Params::model()->getList($mpage_id);
				$params_values_list = ModuleList3Values::model()->getList($id);
                $files = ModuleList3Files::model()->getList($id);
				$this->render('update', array(
					'page_id' => $page_id,
					'params_list' => $params_list,
					'params_values_list' => $params_values_list,
					'model' => $model,
                    'files' => $files,
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			};
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionDelete($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(ModuleList3::model()->deleteItem($link_id,$id,$this->module->id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		};
    }

	/* Публикация новости */
    public function actionActivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList3::model()->existsItem($link_id,$id)) ModuleList3::model()->updateByPk($id,array('active'=>1));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

	/* Снятие с публикации новости */
    public function actionDeactivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList3::model()->existsItem($link_id,$id)) ModuleList3::model()->updateByPk($id,array('active'=>0));
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
            if($link_id) $result = ModuleList3::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
			else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }
}