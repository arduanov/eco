<?php

class Module_list4 extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'list4';
	
	/* ПАГИНАЦИЯ */
	protected function pagination($href,$count,&$page,$lim){
		$slipanie = TRUE;	//TRUE — в случае, когда «...» заменяет всего одну страницу, вместо «...» пишется та самая, заменяемая, страница; FALSE — «...» может заменять и всего одну страницу
		$next_button = FALSE;
		//$count - количество записей по запросу
		//$page — страница
		//$lim — количество записей на странице
		$near = 2; //количество страниц слева и справа от выбранной
		$begend = 1; //количество отображаемых страниц вначале и сконца
		$href_sufix = '&/#!/tab_'.$this->module_id;
		/*выполнение программы*/
		$maxpage = round($count/$lim);
		if($maxpage<$count/$lim) $maxpage++;
		if($page>$maxpage) $page=$maxpage;
		$pagination_menu = '';
		// $pagination_menu_prev = '<li><span class="prev">&larr;</span></li>';
		$pagination_menu_prev = '';
		// $pagination_menu_next = '<li><span class="next">&rarr;</span></li>';
		$pagination_menu_next = '';
		if($count > $lim){
			$pagination_menu = '';
			if($page-($near+$begend+1)>0){
				if($page>1) $pagination_menu_prev = '<li><a href="'.$href.($page-1).$href_sufix.'" class="prev">&larr;</a></li>';
				for($i=1; $i<$begend+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}
				/**/
				if($slipanie && $i+1==$page-$near){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				}
				/**/
				for($i=$page-$near; $i<$page; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}
			}
			if($page-($near+$begend+1)<1){
				if($page>1) $pagination_menu_prev = '<li><a href="'.$href.($page-1).$href_sufix.'" class="prev">&larr;</a></li>';
				for($i=1; $i<$page; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}
			}
			$pagination_menu .= '<li class="active"><span>'.$page.'</span></li>';
			if($page+($near+$begend)<$maxpage){
				for($i=$page+1; $i<$page+$near+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}
				/**/
				if($slipanie && $i==$maxpage-$begend){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				}
				/**/
				for($i=$maxpage-$begend+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}
				if($page<$maxpage){
					$pagination_menu_next = '<li><a href="'.$href.($page+1).$href_sufix.'" class="next">&rarr;</a></li>';
					$next_button = TRUE;
				}
			}
			if($page+($near+$begend)>$maxpage-1){
				for($i=$page+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}
				if($page<$maxpage){
					$pagination_menu_next = '<li><a href="'.$href.($page+1).$href_sufix.'" class="next">&rarr;</a></li>';
					$next_button = TRUE;
				}
			}
			$pagination_menu .= '';
		}
		if($pagination_menu!=''){
			/*$pagination_menu = '
				<div class="pTop">
					'.$pagination_menu_prev.$pagination_menu_next.'
				</div>
				<div class="pages">
					'.$pagination_menu.'
				</div>';*/
			$pagination_menu = '
				<nav class="paging">
					<ul><li class="name"><span>Страницы:</span></li>'.$pagination_menu_prev.$pagination_menu.$pagination_menu_next.'</ul>
				</nav>';
		}
		return $pagination_menu;
	}
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run($page_id = null, $page = 1){
		$page_id = $this->page_id;
		$page = $this->page;
		$controller = Yii::app()->getController();
		$model = new ModuleList4();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$model = $this->create_item($page_id,$model);
			$this->update_order($page_id);
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module_id);
			$module_settings = ModuleList4Settings::model()->getItem($mpage_id);
			$params_list = ModuleList4Params::model()->getList($mpage_id);
			
			if($module_settings->news_type>0){
				$records_on_page = $module_settings->pagination;
				$count = ModuleList4::model()->getCount($mpage_id);
				$pagination = $this->pagination('/admin.php?r=pages/update&id='.$page_id.'&page=',$count,$page,$records_on_page);
				$offset = ($page-1)*$records_on_page;
				$limit = $records_on_page;
				$data = ModuleList4::model()->getList($mpage_id,$offset,$limit);
				$this->render('module_list4', array(
					'model' => $model,
					'params_list' => $params_list,
					'module_settings' => $module_settings,
					'data' => $data,
					'pagination' => $pagination,
					'page_id' => $page_id
				));
			}else{
				$data = ModuleList4::model()->getList($mpage_id);
				$this->render('module_list4', array(
					'model' => $model,
					'params_list' => $params_list,
					'module_settings' => $module_settings,
					'data' => $data,
					'pagination' => '',
					'page_id' => $page_id
				));
			}
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		}
	}
	
	/* Создание новости */
    public function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleList4'])){
			$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$_POST['ModuleList4']['mpage_id'] = $mpage_id;
			if(!isset($_POST['ModuleList4']['date'])) $_POST['ModuleList4']['date'] = date('Y-m-d');
			$model->attributes = $_POST['ModuleList4'];
			if((int)$_POST['ModuleList4']['img_id']) Files::model()->saveTempFile((int)$_POST['ModuleList4']['img_id']);
			if($model->save()){
				$item_id = $model->primaryKey;
				// обработка input-параметров
				if(isset($_POST['ModuleList4Values']) && is_array($_POST['ModuleList4Values']) && count($_POST['ModuleList4Values'])){
					foreach($_POST['ModuleList4Values'] as $key => $value){
						if(is_array($value) && count($value)){
							foreach($value as $key2 => $value2){
								$params_value = new ModuleList4Values();
								$params_value->attributes = array(
									'param_id' => (int)$key,
									'item_id' => $item_id,
									'value' => $value2
								);
								$params_value->save();
							}
						}else{
							$params_value = new ModuleList4Values();
							$params_value->attributes = array(
								'param_id' => (int)$key,
								'item_id' => $item_id,
								'value' => $value
							);
							$params_value->save();
						}
					}
				}
				// активация (создание) альбомов для параметров типа «Фотогалерея»
				$params_list = ModuleList4Params::model()->getList($mpage_id);
				if(count($params_list)){
					foreach($params_list as $key => $value){
						if($value['data_type_id']==8){
							$param_id = $value['id'];
							$id = $item_id;
							$param_value = ModuleList4Values::model()->getItem($id, $param_id);
							if(count($param_value)==0 || is_null(ModuleGallery::model()->findByPk((int)$param_value['value']))){
								$gallery = new ModuleGallery();
								$gallery->attributes = array(
									'title' => 'list4 # param_id = '.$param_id.', item_id = '.$id,
									'date' => date('Y-m-d'),
									'active' => 1
								);
								if($gallery->save()){
									if(count($param_value)==0){
										$model = new ModuleList4Values();
										$model->attributes = array(
											'param_id' => $param_id,
											'item_id' => $id,
											'value' => $gallery->primaryKey
										);
										$model->save();
									}else{
										ModuleList4Values::model()->new_value($id, $param_id, $gallery->primaryKey);
									}
								}
							}
						}
					}
				}
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
					}
					$out .= " ELSE order_id END";
					$connection = Yii::app()->db;
					$command = $connection->createCommand($out);
					$out = $command->execute();
				}
			}
            Yii::app()->cache->delete(md5('data#atms_list'));
			Yii::app()->user->setFlash($this->module_id.'_order_message','<p style="color:green;">Сохранено</p>');
			$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
		}
	}
}