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
			if(!is_null($id) && ModuleGmapsCategories::model()->existsItem($link_id,$id)){
				$model = new ModuleGmaps();
				if(isset($_POST['ModuleGmaps'])){
					$post = $_POST['ModuleGmaps'];
					$post['category_id'] = $id;
					$model->attributes = $post;
					if($model->save()){
						
						$point_id = $model->primaryKey;
						// обработка input-параметров
						if(isset($_POST['ModuleGmapsParams']) && is_array($_POST['ModuleGmapsParams']) && count($_POST['ModuleGmapsParams'])){
							foreach($_POST['ModuleGmapsParams'] as $key => $value){
								$params_value = new ModuleGmapsValues();
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
				$point_list = ModuleGmaps::model()->getList($id);
				$model = ModuleGmapsCategories::model()->getItem($id,$link_id);
				$params_list = ModuleGmapsParams::model()->getList();
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
				if(isset($_POST['ModuleGmapsParams']) && is_array($_POST['ModuleGmapsParams']) && count($_POST['ModuleGmapsParams'])){
					foreach($_POST['ModuleGmapsParams'] as $key => $value){
						if(ModuleGmapsValues::model()->existsItem((int)$key,$id)){
							$params_value = ModuleGmapsValues::model()->getItem((int)$key,$id);
							$params_value->attributes = array('value' => $value);
							$params_value->save();
						}else{
							$params_value = new ModuleGmapsValues();
							$params_value->attributes = array(
								'param_id' => (int)$key,
								'point_id' => $id,
								'value' => $value
							);
							$params_value->save();
						}
					}
				}
				
				$model = ModuleGmaps::model()->findByPk($id);
				if(isset($_POST['ModuleGmaps'])){
					$post = $_POST['ModuleGmaps'];
					unset($post['category_id']);
					$model->attributes = $post;
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/show&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				
				$point_list = ModuleGmaps::model()->getList($model->category_id);
				$params_list = ModuleGmapsParams::model()->getList();
				$params_values_list = ModuleGmapsValues::model()->getInputList($id);
				
				//$model = ModuleGmaps::model()->getItem($id,$link_id);
				if(ModuleGmapsCategories::model()->existsItem($link_id,$model->category_id)){
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
			if(!is_null($id) && ModuleGmapsCategories::model()->existsItem($link_id,$id)){
				$model = ModuleGmapsCategories::model()->findByPk($id);
				if(isset($_POST['ModuleGmapsCategories'])){
					$model->attributes = $_POST['ModuleGmapsCategories'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/settings&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleGmapsCategories::model()->getItem($id,$link_id);
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
			if($id > 0 && ModuleGmapsCategories::model()->deleteItem($link_id,$id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
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
			if($id > 0 && ModuleGmapsCategories::model()->existsItem($link_id, $id))
				ModuleGmapsCategories::model()->updateByPk($id, array('active' => 1));
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
			if($id > 0 && ModuleGmapsCategories::model()->existsItem($link_id, $id))
				ModuleGmapsCategories::model()->updateByPk($id, array('active' => 0));
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
			if($category_id > 0 && $id > 0 && ModuleGmaps::model()->deleteItem($link_id,$category_id,$id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
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
			if($category_id > 0 && $id > 0 && ModuleGmapsCategories::model()->existsItem($link_id, $category_id) && ModuleGmaps::model()->existsItem($category_id, $id))
				ModuleGmaps::model()->updateByPk($id, array('active' => 1));
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
			if($category_id > 0 && $id > 0 && ModuleGmapsCategories::model()->existsItem($link_id, $category_id) && ModuleGmaps::model()->existsItem($category_id, $id))
				ModuleGmaps::model()->updateByPk($id, array('active' => 0));
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
				$result = ModuleGmapsCategories::model()->deactivation($link_id, $this->module->id);
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