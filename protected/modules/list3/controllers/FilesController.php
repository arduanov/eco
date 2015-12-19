<?php
class FilesController extends BackEndController
{
    public function actionUpdate($page_id = null, $item_id = null, $id = null) {
        $data['page_id'] = $page_id;
        $data['item_id'] = $item_id;
        $data['id'] = $id;
        $model = ModuleList3Files::model()->findByPk($id);
        $data['model'] = $model;
        if (isset($_POST['ModuleList3Files'])) {
            $oldfile = $model->file_id;
            $model->short = $_POST['ModuleList3Files']['short'];
            $model->file_id = $_POST['ModuleList3Files']['file_id'];
            if ($model->save()) {
                if ($model->file_id != $oldfile) {
                    Files::model()->saveTempFile((int)$model->file_id);
                    Files::model()->deleteFile($oldfile,$this->module->id);
                }
                Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
                $this->render('update',$data);
            }
            else {
                Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
                Files::model()->deleteFile($model->file_id,$this->module->id);
                $this->render('update',$data);
            }
        }
        else
            $this->render('update',$data);
    }

    public function actionDelete($page_id = null, $item_id = null, $id = null) {
        $model = ModuleList3Files::model()->findByPk($id);
        if ($model != null) {
            $fileId = $model->file_id;
            if ($model->delete())
                Files::model()->deleteFile($fileId,$this->module->id);
        }
        $this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$item_id.'&/#!/tab_third');
    }
}
