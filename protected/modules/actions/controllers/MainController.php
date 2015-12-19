<?php

class MainController extends BackEndController
{
	public function actionIndex($page_id = null)
	{

        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){

            $data = array();

            $link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);

            if($link_id){
                $data = ModuleActionsData::model()->getList($link_id);
            }


            $this->render('index', array('page_id' => $page_id, 'data' => $data, 'module_id' => $this->module->id));

        }

	}

    public function getCategoryNameById($id = null){

        $result = false;

        if(!is_null($id) && ModuleActions::model()->categoryExist($id)){
            $result = ModuleActions::model()->getCategoryNameById($id);
        }

        return $result;

    }

    /* Деактивация модуля */
    public function actionDeactivation($page_id = null){

        $result = false;

        if(!is_null($page_id)){

            $link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);

            if($link_id){
                $result = ModuleActions::model()->deactivation($link_id);
            }

        }

        if($result)
            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
        else
            $this->redirect(Yii::app()->request->scriptUrl);

    }

    /* Активация модуля */
    public function actionActivation($page_id = null){

        $result = false;

        if(!is_null($page_id)){

            $result = ModulesInPages::model()->addLink($this->module_id, $page_id);

            if($result){
                $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
            }

            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
        }

        $this->redirect(Yii::app()->request->scriptUrl);

    }


}