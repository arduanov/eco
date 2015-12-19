<?php

class MainController extends BackEndController
{

	/* Удаление элемента списка */
    public function actionDelete($page_id = null, $id = null){
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(ModuleFieldsFiles::model()->deleteItem($link_id,$id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
		}else{
			$this->redirect(Yii::app()->request->scriptUrl);
		};
    }
	
	/* Обновление элемента списка */
    public function actionUpdate($page_id = null, $id = null){
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleFieldsFiles::model()->existsItem($link_id,$id)){
				$model = ModuleFieldsFiles::model()->findByPk($id);
				if(isset($_POST['ModuleFieldsFiles'])){
					$model->attributes = $_POST['ModuleFieldsFiles'];
					if($model->save()){
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$this->render('update', array('page_id' => $page_id, 'model' => $model));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			};
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
            if($link_id) $result = ModuleFieldsFiles::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
			else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }
}