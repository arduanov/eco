<?php

class MainController extends BackEndController
{

    public $layout = 'main';

	public function actionIndex()
	{
		$this->render('index',$data);
	}

    public function actionUpdate($page_id = null, $id = null) {
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
            $model = ModuleHelper::model()->findByAttributes(array('mpage_id' => $link_id,'id' => $id));
            if (is_null($model)) {
                $this->redirect(Yii::app()->request->scriptUrl);
            }
            $post = Yii::app()->request->getPost('ModuleHelper');
            if (!is_null($post)) {
                $model->attributes = $post;
                if ($model->parent_id == 0) $model->parent_id = NULL;
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
                    } else {
                        Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка сохранения</p>');
                    }
                } else {
                    Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
                }
            }
            $data['model'] = $model;
            $data['page_id'] = $page_id;
            $data['tree'] = ModuleHelper::model()->getTree();
            $data['dropdown'] = ModuleHelper::model()->getDropDown($data['tree']);
            $this->render('update',$data);
            //$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionDelete($page_id = null, $id = null) {
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
            if(ModuleHelper::model()->deleteAllByAttributes(array('mpage_id' => $link_id,'id' => $id))) {
                Yii::app()->user->setFlash('message','<p style="color:green;">Удалено</p>');
            }
            else {
                Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка удаления</p>');
            }
            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionActivation($page_id = null){
        // доступно для пользователей первой роли (например, «Реактиву»)
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id)){
            ModulesInPages::model()->addLink($this->module_id, $page_id);
        }
        $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
    }

    /* Деактивация модуля */
    public function actionDeactivation($page_id = null){
        $result = false;
        // доступно для пользователей первой роли (например, «Реактиву»)
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
            if($link_id) $result = ModuleHelper::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
        else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }
}