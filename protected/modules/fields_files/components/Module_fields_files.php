<?php

class Module_fields_files extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'fields_files';
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run(){
		$page_id = $this->page_id;
		$controller = Yii::app()->getController();
		$model = new ModuleFieldsFiles();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
			if($role_id<2){ // доступно для пользователей первой роли (например, «Реактиву»)
				$this->create_item($page_id,$model);
				$this->update_order($page_id);
			};
			$this->update_values($page_id);
			$this->render('module_fields_files', array('model' => $model, 'page_id' => $page_id));
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}
	
	/* Создание элемента списка */
	protected function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleFieldsFiles'])){
			$_POST['ModuleFieldsFiles']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$model->attributes = $_POST['ModuleFieldsFiles'];
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
	
	/* Обнвление значений полей */
	protected function update_values($page_id = null){
		$controller = Yii::app()->getController();
		if(isset($_POST['type']) && $_POST['type']=='values'){
			if(isset($_POST['fields_files']) && count($_POST['fields_files'])){
				/* foreach($_POST['fields_files'] as $k=>$v)
					if(empty($v) || $v=='NULL') unset($_POST['fields_files'][$k]);
				if(count($_POST['fields_files'])){
					$table = 'rktv_module_'.$this->module_id;
					$out = "UPDATE $table SET `file_id`= CASE";
					foreach($_POST['fields_files'] as $k=>$v){
						$out .= " WHEN id='$k' THEN '$v'";
					};
					$out .= " ELSE `file_id` END";
					$connection = Yii::app()->db;
					$command = $connection->createCommand($out);
					$out = $command->execute();
				}; */
				foreach($_POST['fields_files'] as $k=>$v)
					$this->update_value_of_item($k,$v,$page_id);
			};
			Yii::app()->user->setFlash($this->module_id.'_values_message','<p style="color:green;">Сохранено</p>');
			$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
		};
	}
	
	/* Обнвление одного элемента */
	protected function update_value_of_item($id, $file_id, $page_id){
		$out = true;
		$data = array('file_id'=>$file_id);
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module_id);
			if(!is_null($id) && ModuleFieldsFiles::model()->existsItem($link_id,$id)){
				$model = ModuleFieldsFiles::model()->findByPk($id);
				if(isset($data)){
					$old_file_id = $model->file_id;
					if($data['file_id']=='NULL') $data['file_id'] = '';
					if((int)$old_file_id && (int)$old_file_id!=(int)$data['file_id']){
						$data['link'] = NULL;
						$data['extension'] = NULL;
						$data['size'] = 0;
					};
					if((int)$data['file_id']){
						$file_name = Files::model()->findByPk($data['file_id'])->file_name;
						$data['link'] = '/upload/'.md5($this->module_id).'/'.$file_name;
						$data['extension'] = explode('.',$file_name);
						$data['extension'] = $data['extension'][count($data['extension'])-1];
						$data['size'] = round(filesize($_SERVER['DOCUMENT_ROOT'].rawurldecode($data['link']))/1024);
					};
					$data['date_time'] = date('Y-m-d H:i:s');
					$model->attributes = $data;
					if($model->save()){
						if((int)$old_file_id && (int)$old_file_id!=(int)$data['file_id'])
							Files::model()->deleteFile($old_file_id,$this->module_id);
						Files::model()->saveTempFile((int)$data['file_id']);
					}else{
						$out = false;
					}
				}else{
					$out = false;
				};
			}else{
				$out = false;
			};
        }else{
            $out = false;
        }
		return $out;
	}
}