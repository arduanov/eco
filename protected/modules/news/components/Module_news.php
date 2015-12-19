<?php

class Module_news extends CWidget {
	public $page_id = null;
	public $page = 1;
	public $module_id = 'news';
	
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
				};
				/**/
				if($slipanie && $i+1==$page-$near){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				};
				/**/
				for($i=$page-$near; $i<$page; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
			};
			if($page-($near+$begend+1)<1){
				if($page>1) $pagination_menu_prev = '<li><a href="'.$href.($page-1).$href_sufix.'" class="prev">&larr;</a></li>';
				for($i=1; $i<$page; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
			};
			$pagination_menu .= '<li class="active"><span>'.$page.'</span></li>';
			if($page+($near+$begend)<$maxpage){
				for($i=$page+1; $i<$page+$near+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				/**/
				if($slipanie && $i==$maxpage-$begend){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				};
				/**/
				for($i=$maxpage-$begend+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				if($page<$maxpage){
					$pagination_menu_next = '<li><a href="'.$href.($page+1).$href_sufix.'" class="next">&rarr;</a></li>';
					$next_button = TRUE;
				};
			};
			if($page+($near+$begend)>$maxpage-1){
				for($i=$page+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				if($page<$maxpage){
					$pagination_menu_next = '<li><a href="'.$href.($page+1).$href_sufix.'" class="next">&rarr;</a></li>';
					$next_button = TRUE;
				};
			};
			$pagination_menu .= '';
		};
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
		};
		return $pagination_menu;
	}
	
	/* Вызывается при редактировании страницы, на которой активирован этот модуль */
	public function run($page_id = null, $page = 1){
		$page_id = $this->page_id;
		$page = $this->page;
		$controller = Yii::app()->getController();
		$model = new ModuleNews();
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$this->create_item($page_id,$model);
			
			$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$records_on_page = 10;
			$count = ModuleNews::model()->getCount($mpage_id);
			$pagination = $this->pagination('/admin.php?r=pages/update&id='.$page_id.'&page=',$count,$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data = ModuleNews::model()->getList($mpage_id,$offset,$limit);
			
			$this->render('module_news', array('model' => $model, 'page_id' => $page_id, 'data' => $data, 'pagination' => $pagination));
		}else{
			$controller->redirect(Yii::app()->request->scriptUrl);
		};
	}
	
	/* Создание новости */
    public function create_item($page_id = null, $model){
		$controller = Yii::app()->getController();
		if(isset($_POST['ModuleNews'])){
			$_POST['ModuleNews']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
			$model->attributes = $_POST['ModuleNews'];
			if((int)$_POST['ModuleNews']['photo_id']) Files::model()->saveTempFile((int)$_POST['ModuleNews']['photo_id']);
			if($model->save()){
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:green;">Добавлено</p>');
				$controller->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module_id);
			}else{
				Yii::app()->user->setFlash($this->module_id.'_add_message','<p style="color:red;">Ошибка</p>');
			}
		}
    }
}