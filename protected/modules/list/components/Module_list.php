<?php

class Module_list extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'list';
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run(){
		$page_id = $this->page_id;
		$controller = Yii::app()->getController();
		$model = new ModuleList();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$this->create_item($page_id,$model);
			$this->update_order($page_id);
			$this->render('module_list', array('model' => $model, 'page_id' => $page_id));
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}
	
	/* Создание элемента списка */
	protected function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleList'])){
			$_POST['ModuleList']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$model->attributes = $_POST['ModuleList'];
			if($model->save()){
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:green;">Добавлено</p>');
				$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
			}else{
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:red;">Ошибка</p>');
			}
		}
	}
	
	/* Обнвление порядка сортировки */
	protected function update_order($page_id = null){
		$controller = Yii::app()->getController();
		if(isset($_POST['type']) && $_POST['type']==$this->module_id){
			foreach(array('ids'=>'rktv_module_'.$this->module_id) as $k=>$v){
				if(isset($_POST[$k]) && !empty($_POST[$k])){
					$out = "UPDATE $v SET order_id= CASE";
					$id = $_POST[$k];
					$id = explode(',',$id);
					for($i=count($id); $i>0; $i--){
						$out .= " WHEN id='".intval($id[count($id)-$i])."' THEN '$i'";
					};
					$out .= " ELSE order_id END";
					$connection = Yii::app()->db;
					$command = $connection->createCommand($out);
					$out = $command->execute();
				};
			};
			Yii::app()->user->setFlash($this->module_id.'_order_message','<p style="color:green;">Сохранено</p>');
			$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
		};
	}
}