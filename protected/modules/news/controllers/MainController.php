<?php

class MainController extends BackEndController
{
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleNews::model()->existsItem($link_id,$id)){
				$model = ModuleNews::model()->findByPk($id);
				if(isset($_POST['ModuleNews'])){
					$old_file_id = $model->photo_id;
					if($_POST['ModuleNews']['photo_id']=='NULL') $_POST['ModuleNews']['photo_id'] = '';
					$model->attributes = $_POST['ModuleNews'];
					if((int)$_POST['ModuleNews']['photo_id']) Files::model()->saveTempFile((int)$_POST['ModuleNews']['photo_id']);
						elseif($_POST['ModuleNews']['photo_id']=='') Files::model()->deleteFile($old_file_id,$this->module->id);
					if($model->save()){
						if($old_file_id!=$model->photo_id) Files::model()->deleteFile($old_file_id,$this->module->id);
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleNews::model()->getItem($id,$link_id);
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
			if(ModuleNews::model()->deleteItem($link_id,$id,$this->module->id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
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
			if(!is_null($id) && ModuleNews::model()->existsItem($link_id,$id)) ModuleNews::model()->updateByPk($id,array('active'=>1));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

	/* Снятие с публикации новости */
    public function actionDeactivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleNews::model()->existsItem($link_id,$id)) ModuleNews::model()->updateByPk($id,array('active'=>0));
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
            if($link_id) $result = ModuleNews::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
			else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }
}