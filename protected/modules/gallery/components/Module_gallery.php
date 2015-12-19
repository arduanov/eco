<?php

class Module_gallery extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'gallery';
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run($page_id = null){
		$page_id = $this->page_id;
		$controller = Yii::app()->getController();
		$model = new ModuleGallery();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$this->create_item($page_id,$model);
			$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$data = ModuleGallery::model()->getList($mpage_id);
			$this->render('module_gallery', array('model' => $model, 'page_id' => $page_id, 'data' => $data));
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}
	
	/* Создание новости */
    public function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleGallery'])){
			$_POST['ModuleGallery']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$model->attributes = $_POST['ModuleGallery'];
			if($model->save()){
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:green;">Добавлено</p>');
				$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
			}else{
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:red;">Ошибка</p>');
			}
		}
    }
}