<?php

class MainController extends BackEndController
{
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleFiles::model()->existsItem($link_id,$id)){
				$model = ModuleFiles::model()->findByPk($id);
				if(isset($_POST['ModuleFiles'])){
					$old_file_id = $model->file_id;
					if($_POST['ModuleFiles']['file_id']=='NULL') $_POST['ModuleFiles']['file_id'] = '';
					if((int)$old_file_id && (int)$old_file_id!=(int)$_POST['ModuleFiles']['file_id']){
						$_POST['ModuleFiles']['link'] = NULL;
						$_POST['ModuleFiles']['extension'] = NULL;
						$_POST['ModuleFiles']['size'] = 0;
						Files::model()->deleteFile($old_file_id,$this->module->id);
					};
					if((int)$_POST['ModuleFiles']['file_id']){
						$file_name = Files::model()->findByPk($_POST['ModuleFiles']['file_id'])->file_name;
						$_POST['ModuleFiles']['link'] = '/upload/'.md5($this->module->id).'/'.$file_name;
						$_POST['ModuleFiles']['extension'] = explode('.',$file_name);
						$_POST['ModuleFiles']['extension'] = $_POST['ModuleFiles']['extension'][count($_POST['ModuleFiles']['extension'])-1];
						$_POST['ModuleFiles']['size'] = round(filesize($_SERVER['DOCUMENT_ROOT'].rawurldecode($_POST['ModuleFiles']['link']))/1024);
						Files::model()->saveTempFile((int)$_POST['ModuleFiles']['file_id']);
					};
					if(isset($_POST['ModuleFiles']['group_id']) && empty($_POST['ModuleFiles']['group_id'])) $_POST['ModuleFiles']['group_id'] = NULL;
					$model->attributes = $_POST['ModuleFiles'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleFiles::model()->getItem($id,$link_id);
				$this->render('update', array('page_id' => $page_id, 'model' => $model));
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
			if(ModuleFiles::model()->deleteItem($link_id,$id,$this->module->id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
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
			if(!is_null($id) && ModuleFiles::model()->existsItem($link_id,$id)) ModuleFiles::model()->updateByPk($id,array('active'=>1));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

	/* Снятие с публикации новости */
    public function actionDeactivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleFiles::model()->existsItem($link_id,$id)) ModuleFiles::model()->updateByPk($id,array('active'=>0));
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
            if($link_id) $result = ModuleFiles::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
			else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }
}