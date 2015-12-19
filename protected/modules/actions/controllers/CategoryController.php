<?php

class CategoryController extends BackEndController
{

    public $layout = 'inner';

    public function actionCreate($page_id = null)
    {

        if(!is_null($page_id)){

            $model = new ModuleActions();

            if(isset($_POST["ModuleActions"])){

                $model->attributes=$_POST["ModuleActions"];

                if($model->save()){
                    $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
                }

            }

            $this->render('create', array('page_id' => $page_id, 'model' => ModuleActions::model()));

        } else {

            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionUpdate($page_id = null, $id = null){

        if(!is_null($page_id) && !is_null($id) && ModuleActions::model()->categoryExist($id)){

            $model = ModuleActions::model()->findByPk($id);

            if(isset($_POST["ModuleActions"])){

                $model->attributes=$_POST["ModuleActions"];

                if($model->save()){
                    $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/category/update&page_id='.$page_id.'&id='.$id);
                }

            }

            $this->render('update', array('page_id' => $page_id, 'model' => $model));

        } else {

            $this->redirect(Yii::app()->request->scriptUrl);
        }

    }

    public function actionDelete($page_id = null, $id = null){

        if(!is_null($page_id) && !is_null($id) && ModuleActions::model()->categoryExist($id)){

            if(ModuleActions::model()->deleteCategory($id)){
                $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
            }

            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);

        } else
                $this->redirect(Yii::app()->request->scriptUrl);

    }
}