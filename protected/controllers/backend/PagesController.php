<?php

class PagesController extends BackEndController
{

    public function actionAccess(){
        $this->pageTitle = CHtml::encode(Yii::app()->name);
        $this->render('access');
    }

	public function actionCreate()
    {
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if ($role_id != 7) {
            $this->pageTitle = 'Создание раздела';
            $model = new Pages();

            if (isset($_POST['Pages'])) {
                $model->attributes = $_POST['Pages'];

                if ($model->save()) {
                    $this->redirect(YII::app()->baseUrl . '/admin.php?r=pages/update&id=' . $model->id);
                } else
                    $this->render('create', array('model' => $model));
            } else {
                $this->render('create', array('model' => $model));
            }
        } else
            $this->redirect(Yii::app()->baseUrl . '/admin.php?r=pages/access');
    }

    public function actionLinked($module_id = 0, $page_id = 0)
    {
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if ($role_id != 7) {
            if ($module_id > 0 && $page_id > 0) {
                ModulesInPages::model()->addLink($module_id, $page_id);
            }
            $this->redirect(YII::app()->baseUrl . '/admin.php?r=pages/update&id=' . $page_id);
        } else
            $this->redirect(Yii::app()->baseUrl . '/admin.php?r=pages/access');
    }

    public function actionUnlinked($link_id = 0, $page_id = 1)
    {
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if ($role_id != 7) {
            if ($link_id > 0)
                ModulesInPages::model()->deleteLink($link_id);
            $this->redirect(YII::app()->baseUrl . '/admin.php?r=pages/update&id=' . $page_id);
        } else
            $this->redirect(Yii::app()->baseUrl . '/admin.php?r=pages/access');
    }

    public function actionDelete($id = false)
    {
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if ($role_id != 7) {
            $pages = new Pages();
            //var_dump($id);
            if ($id && $pages->findByPk($id) != null) {
                $model = $pages->findByPk($id);
                if (is_array($data = $pages->checkLinkToModule($id))) {
                    $this->render('error', array('model' => $model, 'error' => $data, 'type' => 'Требуется деактивировать сл. модули', 'action' => 'удалении страницы'));
                } else {
                    Pages::model()->deletePageById((int)$id);
                }
            }
            $this->redirect('/admin.php');
        } else
            $this->redirect(Yii::app()->baseUrl . '/admin.php?r=pages/access');
    }

    public function actionUpdate($id = false, $page = 1)
    {
        $role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if ($role_id != 7 || ($role_id==7 && $id==1)) {
            $pages = new Pages();

            if (!empty($id) && Pages::model()->existsPage($id)) {
                $active = Modules::model()->getActiveModule($id);
                $model = $pages->findByPk($id);
                if (isset($_POST['Pages'])) {
                    if ($model->validate()) {
                        $old_file_id = $model->image_id;
                        if ($_POST['Pages']['image_id'] == 'NULL') $_POST['Pages']['image_id'] = '';
                        $model->attributes = $_POST['Pages'];
                        if ($model->save()) {
                            if ((int)$_POST['Pages']['image_id']) Files::model()->saveTempFile((int)$_POST['Pages']['image_id']);
                            elseif ($_POST['Pages']['image_id'] == '') Files::model()->deleteFile($old_file_id, 'page');
                            if ($old_file_id != $model->image_id) Files::model()->deleteFile($old_file_id, 'page');
                            // Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
                            $this->redirect(YII::app()->baseUrl . '/admin.php?r=pages/update&id=' . $id);
                        } else {
                            // Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
                        }
                    }
                }

                $image = Pages::model()->getImage($id, 'page');

                $this->pageTitle = 'Редактирование раздела — ' . $model->name;
                $this->render('update', array('model' => $model, 'name' => $model->getPageNameById($id), 'active' => $active, 'image' => $image, 'page' => $page));
            } else {
                $this->redirect(Yii::app()->request->baseUrl);
            }
        } else
            $this->redirect(Yii::app()->baseUrl . '/admin.php?r=pages/access');
    }
}