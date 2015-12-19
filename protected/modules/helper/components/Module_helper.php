<?php

class Module_helper extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'helper';
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run(){

		$page_id = $this->page_id;
		$controller = Yii::app()->getController();
		$model = new ModuleHelper();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
            $model = $this->create_item($page_id,$model);
            $data['model'] = $model;
            $data['page_id'] = $page_id;
            $data['tree'] = ModuleHelper::model()->getTree();
            $data['dropdown'] = ModuleHelper::model()->getDropDown($data['tree']);
            $data['list'] = ModuleHelper::model()->getList();
			$this->render('module_helper', $data);
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}

	/* Создание элемента списка */
	protected function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleHelper'])){
			$_POST['ModuleHelper']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
            $model->attributes = $_POST['ModuleHelper'];
            if ($model->parent_id == 0) $model->parent_id = NULL;
			if($model->save()){
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:green;">Добавлено</p>');
				$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
			}else{
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:red;">Ошибка</p>');
			}
		}
        return $model;
	}
}