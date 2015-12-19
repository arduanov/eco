<?php

class MainController extends BackEndController{

	public function actionIndex($page_id = null){
		if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$data = array();
			$link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
			if($link_id){
				$data = ModuleProjects::model()->getList($link_id);
			}
			$this->render('index', array('page_id' => $page_id, 'data' => $data, 'module_id' => $this->module->id));
		}
	}
	
	/**
	 *
	 * @param type $page_id
	 * @param type $id 
	 */
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleYmapsCategories::model()->existsItem($link_id,$id)){
				$model = new ModuleYmaps();
				if(isset($_POST['ModuleYmaps'])){
					$post = $_POST['ModuleYmaps'];
					$post['category_id'] = $id;
					$model->attributes = $post;
					if($model->save()){
						
						$point_id = $model->primaryKey;
						// обработка input-параметров
						if(isset($_POST['ModuleYmapsParams']) && is_array($_POST['ModuleYmapsParams']) && count($_POST['ModuleYmapsParams'])){
							foreach($_POST['ModuleYmapsParams'] as $key => $value){
								$params_value = new ModuleYmapsValues();
								$params_value->attributes = array(
									'param_id' => (int)$key,
									'point_id' => $point_id,
									'value' => $value
								);
								$params_value->save();
							}
						}

						Yii::app()->user->setFlash('message','<p style="color:green;">Добавлено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				// сохранение порядка
				if(isset($_POST['type']) && $_POST['type']==$this->module->id){
					foreach(array('ids'=>'rktv_module_'.$this->module->id) as $k=>$v){
						if(isset($_POST[$k]) && !empty($_POST[$k])){
							$out = "UPDATE $v SET order_id= CASE";
							$poin_id = $_POST[$k];
							$poin_id = explode(',',$poin_id);
							for($i=count($poin_id); $i>0; $i--){
								$out .= " WHEN id='".intval($poin_id[count($poin_id)-$i])."' THEN '$i'";
							}
							$out .= " ELSE order_id END";
							$connection = Yii::app()->db;
							$command = $connection->createCommand($out);
							$out = $command->execute();
						}
					}
					Yii::app()->user->setFlash($this->module->id.'_order_message','<p style="color:green;">Сохранено</p>');
					$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
				}
				$point_list = ModuleYmaps::model()->getList($id);
				$model = ModuleYmapsCategories::model()->getItem($id,$link_id);
				$params_list = ModuleYmapsParams::model()->getList();
				$this->render('update', array(
					'page_id' => $page_id,
					'model' => $model,
					'point_list' => $point_list,
					'params_list' => $params_list
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
	
	/**
	 *
	 * @param type $page_id
	 * @param type $id 
	 */
    public function actionShow($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id)){
				
				// обработка input-параметров
				if(isset($_POST['ModuleYmapsParams']) && is_array($_POST['ModuleYmapsParams']) && count($_POST['ModuleYmapsParams'])){
					foreach($_POST['ModuleYmapsParams'] as $key => $value){
						if(ModuleYmapsParams::model()->existsItem((int)$key)){
							$data_type_id = ModuleYmapsParams::model()->findByPk((int)$key)->data_type_id;
							if(ModuleYmapsValues::model()->existsItem((int)$key,$id)){
								$params_value = ModuleYmapsValues::model()->getItem((int)$key,$id);
								if($data_type_id==7){
									$old_file_id = (int)$params_value->value;
								}
								$params_value->attributes = array('value' => $value);
								if($params_value->save() && $data_type_id==7){
									$file_id = (int)$value;
									if($file_id>0) Files::model()->saveTempFile($file_id);
									if($old_file_id!=$file_id) Files::model()->deleteFile($old_file_id,$this->module->id);
								}
							}else{
								$params_value = new ModuleYmapsValues();
								$params_value->attributes = array(
									'param_id' => (int)$key,
									'point_id' => $id,
									'value' => $value
								);
								if($params_value->save() && $data_type_id==7){
									$file_id = (int)$value;
									if($file_id>0) Files::model()->saveTempFile($file_id);
								}
							}
						}
					}
				}
				
				$model = ModuleYmaps::model()->findByPk($id);
				if(isset($_POST['ModuleYmaps'])){
					$post = $_POST['ModuleYmaps'];
					unset($post['category_id']);
					$model->attributes = $post;
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/show&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				
				$point_list = ModuleYmaps::model()->getList($model->category_id);
				$params_list = ModuleYmapsParams::model()->getList();
				$params_values_list = ModuleYmapsValues::model()->getInputList($id);
				
				//$model = ModuleYmaps::model()->getItem($id,$link_id);
				if(ModuleYmapsCategories::model()->existsItem($link_id,$model->category_id)){
					$this->render('show', array(
						'page_id' => $page_id,
						'model' => $model,
						'point_list' => $point_list,
						'params_list' => $params_list,
						'params_values_list' => $params_values_list
					));
				}
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
	
	/**
	 *
	 * @param type $page_id
	 * @param type $id 
	 */
    public function actionSettings($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleYmapsCategories::model()->existsItem($link_id,$id)){
				$model = ModuleYmapsCategories::model()->findByPk($id);
				if(isset($_POST['ModuleYmapsCategories'])){
					$model->attributes = $_POST['ModuleYmapsCategories'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/settings&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleYmapsCategories::model()->getItem($id,$link_id);
				$this->render('settings', array('page_id' => $page_id, 'model' => $model));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

	/**
	 *
	 * @param integer $page_id
	 * @param integer $id 
	 */
    public function actionDelete($page_id = 0, $id = 0){
		$page_id = (int)$page_id;
        if($page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($id > 0 && ModuleYmapsCategories::model()->deleteItem($link_id,$id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		};
    }

	/**
	 * Публикация группы точек
	 * @param integer $page_id ID страницы
	 * @param integer $id ID категории
	 */
	public function actionActivate($page_id = 0, $id = 0){
		$page_id = (int)$page_id;
		if($page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($id > 0 && ModuleYmapsCategories::model()->existsItem($link_id, $id))
				ModuleYmapsCategories::model()->updateByPk($id, array('active' => 1));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
		}else{
			$this->redirect(Yii::app()->request->scriptUrl);
		}
	}

	/**
	 * Снятие с публикации группы точек
	 * @param integer $page_id ID страницы
	 * @param integer $id ID категории
	 */
	public function actionDeactivate($page_id = 0, $id = 0){
		$page_id = (int)$page_id;
		if($page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($id > 0 && ModuleYmapsCategories::model()->existsItem($link_id, $id))
				ModuleYmapsCategories::model()->updateByPk($id, array('active' => 0));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
		}else{
			$this->redirect(Yii::app()->request->scriptUrl);
		}
	}

	/**
	 *
	 * @param integer $page_id
	 * @param integer $id 
	 */
    public function actionDelete_point($page_id = 0, $category_id = 0, $id = 0){
		$page_id = (int)$page_id;
        if($page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($category_id > 0 && $id > 0 && ModuleYmaps::model()->deleteItem($link_id,$category_id,$id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$category_id.'');
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		};
    }

	/**
	 * Публикация группы точек
	 * @param integer $page_id ID страницы
	 * @param integer $id ID категории
	 */
	public function actionActivate_point($page_id = 0, $category_id = 0, $id = 0){
		$page_id = (int)$page_id;
		if($page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($category_id > 0 && $id > 0 && ModuleYmapsCategories::model()->existsItem($link_id, $category_id) && ModuleYmaps::model()->existsItem($category_id, $id))
				ModuleYmaps::model()->updateByPk($id, array('active' => 1));
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$category_id.'');
		}else{
			$this->redirect(Yii::app()->request->scriptUrl);
		}
	}

	/**
	 * Снятие с публикации группы точек
	 * @param integer $page_id ID страницы
	 * @param integer $id ID категории
	 */
	public function actionDeactivate_point($page_id = 0, $category_id = 0, $id = 0){
		$page_id = (int)$page_id;
		if($page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($category_id > 0 && $id > 0 && ModuleYmapsCategories::model()->existsItem($link_id, $category_id) && ModuleYmaps::model()->existsItem($category_id, $id))
				ModuleYmaps::model()->updateByPk($id, array('active' => 0));
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$category_id.'');
		}else{
			$this->redirect(Yii::app()->request->scriptUrl);
		}
	}

	/**
	 * Деактивация модуля
	 * @param integer $page_id ID страницы
	 */
	public function actionDeactivation($page_id = 0){
		$page_id = (int)$page_id;
		$result = false;
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
		if($role_id < 2 && $page_id > 0 && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
			if($link_id)
				$result = ModuleYmapsCategories::model()->deactivation($link_id, $this->module->id);
		}
		if($result)
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
		else
			$this->redirect(Yii::app()->request->baseUrl.'/admin.php');
	}

	/**
	 * Активация модуля
	 * @param integer $page_id ID страницы
	 */
	public function actionActivation($page_id = 0){
		$page_id = (int)$page_id;
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
		if($role_id < 2 && $page_id > 0)
			ModulesInPages::model()->addLink($this->module_id, $page_id);
		if($page_id > 0)
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
		else
			$this->redirect(Yii::app()->request->baseUrl.'/admin.php');
	}

}