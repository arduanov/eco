<?php

class ParamsController extends BackEndController
{
	public function actionIndex($page_id = null){
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			if($mpage_id>0){
				$model = new ModuleList3Params();
				if($role_id<2){
					if(isset($_POST['ModuleList3Params'])){
						$_POST['ModuleList3Params']['mpage_id'] = $mpage_id;
						$model->attributes = $_POST['ModuleList3Params'];
						if($model->save()){
							Yii::app()->user->setFlash($this->module->id.'_add_message','<p style="color:green;">Добавлено</p>');
							$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/index&page_id='.$page_id);
						}else{
							Yii::app()->user->setFlash($this->module->id.'_add_message','<p style="color:red;">Ошибка</p>');
						}
					}
					if(isset($_POST['type']) && $_POST['type']==$this->module->id){
						foreach(array('ids'=>'rktv_module_'.$this->module->id.'_params') as $k=>$v){
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
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/index&page_id='.$page_id);
					}
				}
				$list = ModuleList3Params::model()->getList($mpage_id);
				$data_type_drop_down_list = DataType::model()->getDropDownList();
				$this->render('index', array(
					'model' => $model,
					'data_type_drop_down_list' => $data_type_drop_down_list,
					'list' => $list,
					'page_id' => $page_id,
					'role_id' => $role_id
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
	}
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			if(!is_null($id) && ModuleList3Params::model()->existsItem($mpage_id,$id)){
				$model = new ModuleList3ParamsValues();
				if(isset($_POST['ModuleList3ParamsValues'])){
					$_POST['ModuleList3ParamsValues']['param_id'] = $id;
					$model->attributes = $_POST['ModuleList3ParamsValues'];
					if($model->save()){
						Yii::app()->user->setFlash($this->module->id.'_add_message','<p style="color:green;">Добавлено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash($this->module->id.'_add_message','<p style="color:red;">Ошибка</p>');
					}
				}
				if(isset($_POST['type']) && $_POST['type']==$this->module->id){
					foreach(array('ids'=>'rktv_module_'.$this->module->id.'_params_values') as $k=>$v){
						if(isset($_POST[$k]) && !empty($_POST[$k])){
							$out = "UPDATE $v SET order_id= CASE";
							$id0 = $_POST[$k];
							$id0 = explode(',',$id0);
							for($i=count($id0); $i>0; $i--){
								$out .= " WHEN id='".intval($id0[count($id0)-$i])."' THEN '$i'";
							}
							$out .= " ELSE order_id END";
							$connection = Yii::app()->db;
							$command = $connection->createCommand($out);
							$out = $command->execute();
						}
					}
					Yii::app()->user->setFlash($this->module->id.'_order_message','<p style="color:green;">Сохранено</p>');
					$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/update&page_id='.$page_id.'&id='.$id);
				}
				$list = ModuleList3ParamsValues::model()->getList($id);
				$item = ModuleList3Params::model()->getItem($id);
				$this->render('update', array(
					'model' => $model,
					'item' => $item,
					'list' => $list,
					'page_id' => $page_id,
					'id' => $id
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
    public function actionSettings($page_id = null, $id = null){
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			if(!is_null($id) && ModuleList3Params::model()->existsItem($mpage_id,$id)){
				$model = ModuleList3Params::model()->findByPk($id);
				if(isset($_POST['ModuleList3Params'])){
					$model->attributes = $_POST['ModuleList3Params'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/settings&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleList3Params::model()->getItem($id);
				$data_type_drop_down_list = DataType::model()->getDropDownList();
				$this->render('settings', array(
					'model' => $model,
					'data_type_drop_down_list' => $data_type_drop_down_list,
					'page_id' => $page_id,
					'id' => $id
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
    public function actionUpdate_value($page_id = null, $param_id = null, $id = null){
		if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			if(!is_null($id) && ModuleList3Params::model()->existsItem($mpage_id,$param_id) && ModuleList3ParamsValues::model()->existsItem($param_id,$id)){
				$model = ModuleList3ParamsValues::model()->findByPk($id);
				if(isset($_POST['ModuleList3ParamsValues'])){
					$model->attributes = $_POST['ModuleList3ParamsValues'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/update_value&page_id='.$page_id.'&param_id='.$param_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleList3ParamsValues::model()->getItem($id);
				$item = ModuleList3Params::model()->getItem($param_id);
				$this->render('update_value', array(
					'model' => $model,
					'item' => $item,
					'page_id' => $page_id,
					'param_id' => $param_id,
					'id' => $id
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionDelete($page_id = null, $id = null){
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			if(ModuleList3Params::model()->deleteItem($mpage_id, $id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/index&page_id='.$page_id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }

    public function actionDelete_value($page_id = null, $param_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			if(ModuleList3Params::model()->existsItem($mpage_id,$param_id) && ModuleList3ParamsValues::model()->deleteItem($param_id, $id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/update&page_id='.$page_id.'&id='.$param_id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }
}