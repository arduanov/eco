<?php

class Module_list3 extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'list3';
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run(){
		$page_id = $this->page_id;
		$controller = Yii::app()->getController();
		$model = new ModuleList3();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$this->create_item($page_id,$model);
			$this->update_order($page_id);
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module_id);
			if($mpage_id==5) $mpage_id = 4;
			if($mpage_id==54) $mpage_id = 4;
			if($mpage_id==56) $mpage_id = 4;
			if($mpage_id==58) $mpage_id = 4;
			$params_list = ModuleList3Params::model()->getList($mpage_id);
			$this->render('module_list3', array(
				'model' => $model,
				'params_list' => $params_list,
				'page_id' => $page_id
			));
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}
	
	/* Создание новости */
    public function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleList3'])){
			$_POST['ModuleList3']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$model->attributes = $_POST['ModuleList3'];
			if((int)$_POST['ModuleList3']['img_id']) Files::model()->saveTempFile((int)$_POST['ModuleList3']['img_id']);
			if($model->save()){
				$item_id = $model->primaryKey;
				// обработка input-параметров
				if(isset($_POST['ModuleList3Values']) && is_array($_POST['ModuleList3Values']) && count($_POST['ModuleList3Values'])){
					foreach($_POST['ModuleList3Values'] as $key => $value){
						if(is_array($value) && count($value)){
							foreach($value as $key2 => $value2){
								$params_value = new ModuleList3Values();
								$params_value->attributes = array(
									'param_id' => (int)$key,
									'item_id' => $item_id,
									'value' => $value2
								);
								$params_value->save();
							}
						}else{
							$params_value = new ModuleList3Values();
							$params_value->attributes = array(
								'param_id' => (int)$key,
								'item_id' => $item_id,
								'value' => $value
							);
							$params_value->save();
						}
					}
				}
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