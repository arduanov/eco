<?php

class Module_fields extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'fields';
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run(){
		$page_id = $this->page_id;
		$controller = Yii::app()->getController();
		$model = new ModuleFields();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
			if($role_id<2){ // доступно для пользователей первой роли (например, «Реактиву»)
				$model = $this->create_item($page_id,$model);
				$this->update_order($page_id);
			};
			$this->update_values($page_id);
			$data_type_drop_down_list = DataType::model()->getDropDownList();
			unset($data_type_drop_down_list[5]);
			unset($data_type_drop_down_list[6]);
			$this->render('module_fields', array(
				'model' => $model,
				'data_type_drop_down_list' => $data_type_drop_down_list,
				'page_id' => $page_id)
			);
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}
	
	/* Создание элемента списка */
	protected function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleFields'])){
			$_POST['ModuleFields']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$model->attributes = $_POST['ModuleFields'];
			if($model->save()){
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:green;">Добавлено</p>');
				$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
			}else{
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:red;">Ошибка</p>');
			}
		}
        return $model;
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
	
	/* Обнвление порядка сортировки */
	protected function update_values($page_id = null){
		$controller = Yii::app()->getController();
		if(isset($_POST['type']) && $_POST['type']=='values'){
			if(isset($_POST['fields']) && count($_POST['fields'])){
				$table = 'rktv_module_'.$this->module_id;
				$out = "UPDATE $table SET `value`= CASE";
				foreach($_POST['fields'] as $k=>$v){
					$out .= " WHEN id='$k' THEN '$v'";
				};
				$out .= " ELSE `value` END";
				$connection = Yii::app()->db;
				$command = $connection->createCommand($out);
				$out = $command->execute();
			};
			Yii::app()->user->setFlash($this->module_id.'_values_message','<p style="color:green;">Сохранено</p>');
			$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
		};
	}
}