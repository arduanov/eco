<?php

class MsettingsController extends BackEndController
{
	public function actionIndex($page_id = null){
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if($mpage_id>0){
				$model = ModuleList4Settings::model()->findByAttributes(array('mpage_id'=>$mpage_id));
				if(!is_null($model)){
					if(isset($_POST['ModuleList4Settings'])){
						$model->attributes = $_POST['ModuleList4Settings'];
						if($model->save()){
							Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
							$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/msettings/index&page_id='.$page_id);
						}else{
							Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
						}
					}
					$model = ModuleList4Settings::model()->findByAttributes(array('mpage_id'=>$mpage_id));
                    $module_settings = ModuleList4Settings::model()->getItem($mpage_id);
                    $this->pageTitle = $module_settings->title.' — Настройки модуля';
					$this->render('index', array(
						'model' => $model,
						'module_settings' => $module_settings,
                        'page_id' => $page_id
					));
				}else{
					$model = new ModuleList4Settings();
					$model->attributes = array(
						'mpage_id' => $mpage_id
					);
					if($model->save())
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/msettings/index&page_id='.$page_id);
					else
						$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
				}
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
}