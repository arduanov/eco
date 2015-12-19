<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 16.02.12
 * Time: 20:27
 * To change this template use File | Settings | File Templates.
 */

class ActionController extends BackEndController
{

    public $layout = 'inner';

    public function actionCreate($page_id = null)
    {
        if(!is_null($page_id)){

            $model = new ModuleActionsData();

            if(isset($_POST["ModuleActionsData"])){

                $model->attributes=$_POST["ModuleActionsData"];

                if($model->save()){
                    $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
                }

            }

            $this->render('create', array('page_id' => $page_id, 'model' =>  $model));

        } else {

            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionUpdate($page_id = null, $id = null)
    {
        if(!is_null($page_id) && !is_null($id)){

            $model = ModuleActionsData::model()->findByPk($id);

            if(isset($_POST["ModuleActionsData"])){

                $model->attributes=$_POST["ModuleActionsData"];

                if($model->save()){
                    $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
                }

            }

            $images = $model->getImages($id, $this->module->id);

            $this->render('update', array('page_id' => $page_id, 'model' =>  $model, 'images' => $images));

        } else {

            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionDelete($page_id = null, $id = null){

        $actions = new ModuleActionsData();

        if(!is_null($id) && $actions->existsAction($id)){

            if($actions->deleteAction($id)){
                $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);
            }

            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id);

        } else
            $this->redirect(Yii::app()->request->scriptUrl);
    }


}