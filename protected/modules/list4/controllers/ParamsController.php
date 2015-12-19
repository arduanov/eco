<?php

class ParamsController extends BackEndController
{
	public function actionIndex($page_id = null){
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id>0){
				$model = new ModuleList4Params();
				if($role_id<2){
					if(isset($_POST['ModuleList4Params'])){
						$_POST['ModuleList4Params']['mpage_id'] = $mpage_id;
						$model->attributes = $_POST['ModuleList4Params'];
						if($model->save()){
							$param_id = $model->primaryKey;
							// активация (создание) альбомов для элементов списка
							if($model->data_type_id==8){
								$data = ModuleList4::model()->getList($mpage_id);
								if(count($data)){
									foreach($data as $key => $value){
										$id = $value->id;
										$param_value = ModuleList4Values::model()->getItem($id, $param_id);
										if(count($param_value)==0 || is_null(ModuleGallery::model()->findByPk((int)$param_value['value']))){
											$gallery = new ModuleGallery();
											$gallery->attributes = array(
												'title' => 'list4 # param_id = '.$param_id.', item_id = '.$id,
												'date' => date('Y-m-d'),
												'active' => 1
											);
											if($gallery->save()){
												if(count($param_value)==0){
													$model = new ModuleList4Values();
													$model->attributes = array(
														'param_id' => $param_id,
														'item_id' => $id,
														'value' => $gallery->primaryKey
													);
													$model->save();
												}else{
													ModuleList4Values::model()->new_value($id, $param_id, $gallery->primaryKey);
												}
											}
										}
									}
								}
							}
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
				$list = ModuleList4Params::model()->getList($mpage_id);
				$data_type_drop_down_list = DataType::model()->getDropDownList();
                $module_settings = ModuleList4Settings::model()->getItem($mpage_id);
                $this->pageTitle = $module_settings->title.' — Список параметров';
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
			if(!is_null($id) && ModuleList4Params::model()->existsItem($mpage_id,$id)){
				$model = new ModuleList4ParamsValues();
				if(isset($_POST['ModuleList4ParamsValues'])){
					$_POST['ModuleList4ParamsValues']['param_id'] = $id;
					$model->attributes = $_POST['ModuleList4ParamsValues'];
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
				$list = ModuleList4ParamsValues::model()->getList($id);
				$item = ModuleList4Params::model()->getItem($id);
                $module_settings = ModuleList4Settings::model()->getItem($mpage_id);
                $this->pageTitle = $module_settings->title.' — Возможные значения параметра «'.$item->title.'»';
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
    public function actionList4($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList4Params::model()->existsItem($mpage_id,$id)){
				$model = new ModuleList4ParamsList4();
				$save = false;
				if(isset($_POST['type']) && $_POST['type']=='save'){
					ModuleList4ParamsList4::model()->deleteAllByAttributes(array('param_id'=>$id));
					if(isset($_POST['ModuleList4ParamsList4']) && is_array($_POST['ModuleList4ParamsList4']) && count($_POST['ModuleList4ParamsList4'])){
						foreach($_POST['ModuleList4ParamsList4'] as $mpage_id => $v){
							if($v!='0'){
								$mpage_id = (int)$mpage_id;
								$model = new ModuleList4ParamsList4();
								$model->attributes = array('mpage_id'=>$mpage_id, 'param_id'=>$id);
								if($model->save()) $save = true;
							}
						}
						if($save){
							Yii::app()->user->setFlash($this->module->id.'_add_message','<p style="color:green;">Добавлено</p>');
							$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/list4&page_id='.$page_id.'&id='.$id);
						}
					}
				}
				// $list = ModuleList4ParamsValues::model()->getList($id);
				$item = ModuleList4Params::model()->getItem($id);
                $module_settings = ModuleList4Settings::model()->getItem($mpage_id);
                $this->pageTitle = $module_settings->title.' — Связанные модули «List4» в параметре «'.$item->title.'»';
				$this->render('list4', array(
					// 'model' => $model,
					'item' => $item,
					// 'list' => $list,
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
			if(!is_null($id) && ModuleList4Params::model()->existsItem($mpage_id,$id)){
				$model = ModuleList4Params::model()->findByPk($id);
				if(isset($_POST['ModuleList4Params'])){
                    $model->attributes = $_POST['ModuleList4Params'];
                    $model->settings = array();
                    foreach ($model->defaultSettings['list4'] as $code=>$setting) {
                        switch ($setting['type']) {
                            case 'checkbox':
                                $sValue = isset($_POST['ModuleList4Params']['settings'][$code]) ? true : false;
                                $model->settings = array_merge($model->settings, array($code => $sValue));
                                break;
                            case 'string':
                                if (isset($_POST['ModuleList4Params']['settings'][$code])) {
                                    $sValue = trim($_POST['ModuleList4Params']['settings'][$code]);
                                } else {
                                    $sValue = $setting['value'];
                                }
                                $model->settings = array_merge($model->settings, array($code => $sValue));
                                break;
                            default:
                                break;
                        }
                    }
                    if (!is_null($model->settings)) $model->settings = serialize($model->settings);
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/settings&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleList4Params::model()->getItem($id);
				$data_type_drop_down_list = DataType::model()->getDropDownList();
                $module_settings = ModuleList4Settings::model()->getItem($mpage_id);
                $this->pageTitle = $module_settings->title.' — Настройки параметра «'.$model->title.'»';
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
			if(!is_null($id) && ModuleList4Params::model()->existsItem($mpage_id,$param_id) && ModuleList4ParamsValues::model()->existsItem($param_id,$id)){
				$model = ModuleList4ParamsValues::model()->findByPk($id);
				if(isset($_POST['ModuleList4ParamsValues'])){
					$model->attributes = $_POST['ModuleList4ParamsValues'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/update_value&page_id='.$page_id.'&param_id='.$param_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleList4ParamsValues::model()->getItem($id);
				$item = ModuleList4Params::model()->getItem($param_id);
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
			if(ModuleList4Params::model()->deleteItem($mpage_id, $id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/index&page_id='.$page_id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }

    public function actionDelete_value($page_id = null, $param_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(ModuleList4Params::model()->existsItem($mpage_id,$param_id) && ModuleList4ParamsValues::model()->deleteItem($param_id, $id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/params/update&page_id='.$page_id.'&id='.$param_id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }
}