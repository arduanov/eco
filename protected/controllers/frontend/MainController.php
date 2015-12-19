<?php

// require_once($_SERVER['DOCUMENT_ROOT'].'/protected/helpers/thumb/ThumbLib.inc.php');

class MainController extends FrontEndController
{

    public $pCode = '';

	public $layout = 'main';
	public $product = '';

	protected $emails_preg_match = "/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/";
	protected $emails = '';
	// protected $emails_parser = "\n";
	protected $emails_parser = ",";
	protected $data_prefix = 'data_';
	protected $name_from = 'Экопромбанк';			// имя отправителя
	protected $email_from = 'no-reply@ecoprombank.ru';	// email отправителя
	protected $name_to = '';					// имя получателя
	protected $data_charset = 'UTF-8';			// кодировка переданных данных
	protected $send_charset = 'UTF-8';			// кодировка письма
	protected $html = TRUE;						// письмо в виде html или обычного текста
	protected $boundary = "---";				// разделитель
	protected function mime_header_encode($str, $data_charset, $send_charset){
		if($data_charset != $send_charset){
			$str = iconv($data_charset, $send_charset, $str);
		};
		return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
	}
	protected function send_mime_mail($name_from,$email_from,$name_to,$email_to,$data_charset,$send_charset,$subject,$body,$html = FALSE,$filepath = array(),$filename = array()){
		$to = $this->mime_header_encode($name_to, $data_charset, $send_charset)
					 . ' <' . $email_to . '>';
		$subject = $this->mime_header_encode($subject, $data_charset, $send_charset);
		$from =  $this->mime_header_encode($name_from, $data_charset, $send_charset)
						 .' <' . $email_from . '>';
		if($data_charset != $send_charset) {
			$body = iconv($data_charset, $send_charset, $body);
		}
		$headers = "From: $from\r\n";
		$type = ($html) ? 'html' : 'plain';

		$flag = false;
		foreach($filepath as $f){
			if(
				substr($f,0,7)!='http://' && file_exists($f) ||
				substr($f,0,7)=='http://'
			) $flag = true;
		};

		if(!$flag){
			$headers .= "Content-type: text/$type; charset=$send_charset\r\n";
			$headers .= "Mime-Version: 1.0\r\n";
		}else{
			$headers .= "Content-Type: multipart/mixed; boundary=\"$this->boundary\"";
			$body_begin = "--$this->boundary\n";
			$body_begin .= "Content-type: text/$type; charset=$send_charset\n";
			$body_begin .= "Content-Transfer-Encoding: Quot-Printed\n\n";
			$body = $body_begin.$body."\n\n";
			// $body .= "--$this->boundary\n";
			for($i=0; $i<count($filepath); $i++){
				$f = $filepath[$i];
				$body .= "--$this->boundary\n";
				/**/
				if(substr($f,0,7)!='http://'){
					$file_path = $f;
					// $file_name = explode('/',$file_path);
					// $file_name = $file_name[count($file_name)-1];
					$file = fopen($file_path, "r"); //Открываем файл
					$text = fread($file, filesize($file_path)); //Считываем весь файл
					fclose($file); //Закрываем файл
				}else{
					$file_path = $f;
					$text = file_get_contents($f);
				}
				/* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
				$body .= "Content-Type: application/octet-stream; name==?$send_charset?B?".base64_encode($filename[$i])."?=\n";
				$body .= "Content-Transfer-Encoding: base64\n";
				$body .= "Content-Disposition: attachment; filename==?$send_charset?B?".base64_encode($filename[$i])."?=\n\n";
				$body .= chunk_split(base64_encode($text))."\n";
			}
			$body .= "--".$this->boundary ."--\n";
		}
		return mail($to, $subject, $body, $headers);
	}
	protected function sending($subject,$labels,$filepath = array(),$filename = array(),$message = ''){
		if(empty($message)){
			$i = 0;
			foreach($labels as $k=>$v){
				if($v==''){
					if(!in_array($k,array('Комментарий'))){
						$message .= '<b>'.$k.':</b> '.htmlspecialchars($_POST[$this->data_prefix.$i]).'<br>';
					}else{
						$message .= '<b>'.$k.':</b><br>'.nl2br(htmlspecialchars($_POST[$this->data_prefix.$i])).'<br>';
					}
				}else{
					if(!in_array($k,array('Комментарий'))){
						$message .= '<b>'.$k.':</b> '.htmlspecialchars($_POST[$v]).'<br>';
					}else{
						$message .= '<b>'.$k.':</b><br>'.nl2br(htmlspecialchars($_POST[$v])).'<br>';
					}
				}
				$i++;
			}
		}
		/*РАССЫЛКА*/
		if(empty($this->emails)) $this->emails = Settings::model()->getMail();
		$emails = explode($this->emails_parser,$this->emails);
		for($i = 0; $i<count($emails); $i++){
			$emails[$i] = trim($emails[$i]);
			if(preg_match($this->emails_preg_match,$emails[$i])){
				$this->send_mime_mail($this->name_from,$this->email_from,$this->name_to,$emails[$i],$this->data_charset,$this->send_charset,$subject,$message,$this->html,$filepath,$filename);
			}
		}
		for($i=0; $i<count($filepath); $i++){
			if(substr($filepath[$i],0,7)!='http://' && file_exists($filepath[$i]))
				unlink($filepath[$i]); //Удаление файла
			// system("del $file_path");
		}
		/**/
		return 0;
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
/* 	protected function beforeAction(){
		print_r($this->getActionParams());

		$this->run('application.controllers.frontend.siteController.actionIndex');
		echo $this->action->getId();
		print_r($this->actions());
		exit;
	} */


	protected function plural($number, $one, $two, $five) {
		$number = abs($number);
		$number %= 100;
		if ($number >= 5 && $number <= 20) {
			return $five;
		}
		$number %= 10;
		if ($number == 1) {
			return $one;
		}
		if ($number >= 2 && $number <= 4) {
			return $two;
		}
		return $five;
	}

	/* ПАГИНАЦИЯ */
	protected function pagination($href,$count,&$page,$lim){
		$slipanie = TRUE;	//TRUE — в случае, когда «...» заменяет всего одну страницу, вместо «...» пишется та самая, заменяемая, страница; FALSE — «...» может заменять и всего одну страницу
		$next_button = FALSE;
		//$count - количество записей по запросу
		//$page — страница
		//$lim — количество записей на странице
		$near = 1; //количество страниц слева и справа от выбранной
		$begend = 1; //количество отображаемых страниц вначале и сконца
		$href_sufix = '/';
		$request_uri = explode('?',$_SERVER['REQUEST_URI']);
		if(count($request_uri)>1) $href_sufix .= '?'.$request_uri[1];
		/*выполнение программы*/
		$maxpage = round($count/$lim);
		if($maxpage<$count/$lim) $maxpage++;
		if($page>$maxpage) $page=$maxpage;
		$pagination_menu = '';
		$pagination_menu_prev = '<a href="javascript:void(0)" class="prev inactive">Пред.</a>';
		$pagination_menu_next = '<a href="javascript:void(0)" class="next inactive">След.</a>';
		if($count > $lim){
			// $pagination_menu = '<ul>';
			$pagination_menu = '';
			if($page-($near+$begend+1)>0){
				if($page>1) $pagination_menu_prev = '<a href="'.$href.($page-1).$href_sufix.'" class="prev">Пред.</a>';
				for($i=1; $i<$begend+1; $i++){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}
				/**/
				if($slipanie && $i+1==$page-$near){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}else{
					// находим середину среди «точек» ☺
					$point_num = floor(($page-$near-$begend-1)/2);
					// прижимаем вправо
					if(2*$point_num==$page-$near-$begend-1) $point_num--;
					$point_num = $page-$near-$point_num-1;
					// приклеиваем к левой границе
					if($point_num+$near+1<$page-$near) $point_num = $page-2*$near-1;
					// вывод в переменную
					$pagination_menu .= '<a href="'.$href.$point_num.$href_sufix.'">...</a>';
				}
				/**/
				for($i=$page-$near; $i<$page; $i++){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}
			}
			if($page-($near+$begend+1)<1){
				if($page>1) $pagination_menu_prev = '<a href="'.$href.($page-1).$href_sufix.'" class="prev">Пред.</a>';
				for($i=1; $i<$page; $i++){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}
			}
			$pagination_menu .= '<span class="active">'.$page.'</span>';
			if($page+($near+$begend)<$maxpage){
				for($i=$page+1; $i<$page+$near+1; $i++){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}
				/**/
				if($slipanie && $i==$maxpage-$begend){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}else{
					// находим середину среди «точек» ☺
					$point_num = floor(($page-$near-($maxpage-$begend)-1)/2);
					// прижимаем влево
					if(2*$point_num==$page-$near-($maxpage-$begend)-1) $point_num--;
					$point_num = $page-$near-$point_num;
					// приклеиваем к левой границе
					if($point_num-$near-1>$page+$near) $point_num = $page+2*$near+1;
					// вывод в переменную
					$pagination_menu .= '<a href="'.$href.$point_num.$href_sufix.'">...</a>';
				}
				/**/
				for($i=$maxpage-$begend+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}
				if($page<$maxpage){
					$pagination_menu_next = '<a href="'.$href.($page+1).$href_sufix.'" class="next">След.</a>';
					$next_button = TRUE;
				}
			}
			if($page+($near+$begend)>$maxpage-1){
				for($i=$page+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<a href="'.$href.$i.$href_sufix.'">'.$i.'</a>';
				}
				if($page<$maxpage){
					$pagination_menu_next = '<a href="'.$href.($page+1).$href_sufix.'" class="next">След.</a>';
					$next_button = TRUE;
				}
			}
			// $pagination_menu .= '</ul>';
		}
		if($pagination_menu!=''){
			$pagination_menu = '
                    '.$pagination_menu.'
                    '.$pagination_menu_next.'
					'.$pagination_menu_prev.'
				';
		}
		return $pagination_menu;
	}
	protected function year_pagination($href,$count,&$page,$lim,$year){
		$page = 1;
		$slipanie = TRUE;	//TRUE — в случае, когда «...» заменяет всего одну страницу, вместо «...» пишется та самая, заменяемая, страница; FALSE — «...» может заменять и всего одну страницу
		$next_button = FALSE;
		//$count - количество записей по запросу
		//$page — страница
		//$lim — количество записей на странице
		$near = 1; //количество страниц слева и справа от выбранной
		$begend = 1; //количество отображаемых страниц вначале и сконца
		$href_sufix = '/';
		$request_uri = explode('?',$_SERVER['REQUEST_URI']);
		if(count($request_uri)>1) $href_sufix .= '?'.$request_uri[1];
		/*выполнение программы*/
		
		$year_count = count($year);
		
		$maxpage = round($count/$lim);
		if($maxpage<$count/$lim) $maxpage++;
		if($page>$maxpage) $page = $maxpage;
		$count_before_page_i = 0;
		$count_before_page = $year_count;
		$year_page= array();
		
		$get_year = 0;
		if(isset($_GET['y'])) $get_year = (int)$_GET['y'];
		for($i = 0; $i<$year_count; $i++){
			if($get_year==$year[$i]->year) $page = $i+1;
			$year_page[$i] = $count_before_page_i+1;
			$count_before_page_i++;
		}
		
		$maxpage = $year_count;
		if($page>$maxpage) $page = $maxpage;
		
		if($page==1) $near = 4;
		if($page==2) $near = 3;
		if($page==3) $near = 2;
		
		if($page==$maxpage-2) $near = 2;
		if($page==$maxpage-1) $near = 3;
		if($page==$maxpage) $near = 4;
		//if($page-1<$begend+$near+1)
		
		$pagination_menu = '';
		if($year_count > 1){
			// $pagination_menu = '<ul>';
			$pagination_menu = '';
			if($get_year==$year[$page-1]->year)
				$pagination_menu .= '<li><a href="'.$href.'">Все</a></li>';
			if($page-($near+$begend+1)>0){
				for($i=1; $i<$begend+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}
				/**/
				if($slipanie && $i+1==$page-$near){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				}
				/**/
				for($i=$page-$near; $i<$page; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}
			}
			if($page-($near+$begend+1)<1){
				for($i=1; $i<$page; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}
			}
			if($get_year==$year[$page-1]->year)
				$pagination_menu .= '<li class="active"><span>'.$year[$page-1]->year.'</span></li>';
			else{
				$pagination_menu .= '<li class="active"><span>Все</span></li>';
				$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$page-1]->year.'">'.$year[$page-1]->year.'</a></li>';
			}
			if($page+($near+$begend)<$maxpage){
				for($i=$page+1; $i<$page+$near+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}
				/**/
				if($slipanie && $i==$maxpage-$begend){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				}
				/**/
				for($i=$maxpage-$begend+1; $i<$maxpage+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}
				if($page<$maxpage){
					$next_button = TRUE;
				}
			}
			if($page+($near+$begend)>$maxpage-1){
				for($i=$page+1; $i<$maxpage+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.'?y='.$year[$i-1]->year.'">'.$year[$i-1]->year.'</a></li>';
				}
				if($page<$maxpage){
					$next_button = TRUE;
				}
			}
			// $pagination_menu .= '</ul>';
		}
		if($pagination_menu!=''){
			$pagination_menu = '<ul>'.$pagination_menu.'</ul>';
		}
		return $pagination_menu;
	}
	protected function year_pagination_by_page($href,$count,&$page,$lim,$year){
		$slipanie = TRUE;	//TRUE — в случае, когда «...» заменяет всего одну страницу, вместо «...» пишется та самая, заменяемая, страница; FALSE — «...» может заменять и всего одну страницу
		$next_button = FALSE;
		//$count - количество записей по запросу
		//$page — страница
		//$lim — количество записей на странице
		$near = 1; //количество страниц слева и справа от выбранной
		$begend = 1; //количество отображаемых страниц вначале и сконца
		$href_sufix = '/';
		$request_uri = explode('?',$_SERVER['REQUEST_URI']);
		if(count($request_uri)>1) $href_sufix .= '?'.$request_uri[1];
		/*выполнение программы*/
		
		$year_count = count($year);
		
		$maxpage = round($count/$lim);
		if($maxpage<$count/$lim) $maxpage++;
		if($page>$maxpage) $page = $maxpage;
		$count_before_page_i = 0;
		$count_before_page = ($page-1)*$lim;
		$year_page= array();
		for($i = 0; $i<$year_count; $i++){
			if($count_before_page+$lim>$count_before_page_i) $page = $i+1;
			$year_page[$i] = floor($count_before_page_i/$lim)+1;
			$count_before_page_i += $year[$i]->count;
		}
		
		$maxpage = $year_count;
		if($page>$maxpage) $page = $maxpage;
		
		if($page==1) $near = 4;
		if($page==2) $near = 3;
		if($page==3) $near = 2;
		
		if($page==$maxpage-2) $near = 2;
		if($page==$maxpage-1) $near = 3;
		if($page==$maxpage) $near = 4;
		//if($page-1<$begend+$near+1)
		
		$pagination_menu = '';
		if($count > $lim){
			// $pagination_menu = '<ul>';
			$pagination_menu = '';
			if($page-($near+$begend+1)>0){
				for($i=1; $i<$begend+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}
				/**/
				if($slipanie && $i+1==$page-$near){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				}
				/**/
				for($i=$page-$near; $i<$page; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}
			}
			if($page-($near+$begend+1)<1){
				for($i=1; $i<$page; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}
			}
			$pagination_menu .= '<li class="active"><span>'.$year[$page-1]->year.'</span></li>';
			if($page+($near+$begend)<$maxpage){
				for($i=$page+1; $i<$page+$near+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}
				/**/
				if($slipanie && $i==$maxpage-$begend){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				}
				/**/
				for($i=$maxpage-$begend+1; $i<$maxpage+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}
				if($page<$maxpage){
					$next_button = TRUE;
				}
			}
			if($page+($near+$begend)>$maxpage-1){
				for($i=$page+1; $i<$maxpage+1; $i++){
					$i_page = $year_page[$i-1];
					$pagination_menu .= '<li><a href="'.$href.$i_page.$href_sufix.'">'.$year[$i-1]->year.'</a></li>';
				}
				if($page<$maxpage){
					$next_button = TRUE;
				}
			}
			// $pagination_menu .= '</ul>';
		}
		if($pagination_menu!=''){
			$pagination_menu = '<ul>'.$pagination_menu.'</ul>';
		}
		return $pagination_menu;
	}

/* Yandex.XML functions */
	protected function highlight_words($node){
		$stripped = preg_replace('/<\/?(title|passage)[^>]*>/', '', $node->asXML());
		return str_replace('</hlword>', '</strong>', preg_replace('/<hlword[^>]*>/', '<strong>', $stripped));
	}
	protected function print_pager($found_links,$query,$host,$page = 0,$links_on_page = 10,$out){
		$query = htmlspecialchars($query);
		// $host = htmlspecialchars($host);
		if($page!=0){
			// $out .= "<a href='?page=" . ($page - 1) . "&query={$query}&host={$host}'>&#8592; предыдущая</a> ";
			$out .= "<a href='?page=".($page - 1)."&searchString={$query}'>&#8592;</a> ";
		}
		// $out .= " страница № ".($page + 1);
		$out .= "".($page + 1);
		if($found_links>($page + 1)*$links_on_page){
			// $out .= " <a href='?page="  . ($page + 1)  . "&query=$query&host={$host}'>следующая &#8594;</a> ";
			$out .= " <a href='?page=".($page + 1)."&searchString=$query'>&#8594;</a> ";
		}
	}
/* end of Yandex.XML functions */
	protected function get_id($url = '', $tree = array(), $level = 0, $type = '')
    {
        $prev_id = 0;
        $id = 0;
        $next_id = 0;
        $tree_next = array();
        if ($url == '') $url = 'index';
        $url = explode('/', $url);
        //var_dump($url);
        if ($level < 1) $count = count($url);
        else $count = $level;
        for ($i = 0; $i < $count; $i++) {
            foreach ($tree as $k => $t) {
                if ($next_id < 0) {
                    $next_id = $k;
                    break 1;
                }
                //echo $t['code'];
                if ($t['code'] == $url[$i]) {
                    $id = $k;

                    $tree_next = array();
                    if (is_array($t['child']) && count($t['child']) > 0) $tree_next = $t['child'];
                    $next_id = -1;
                } else {
                    if ($level >= 0) {
                        $prev_id = $k;
                        $id = 0;
                    }
                }
            }
            if (count($tree_next) > 0) {
                $prev_id = 0;
                $next_id = 0;
                $tree = $tree_next;
                $tree_next = array();
            }
        }
        switch ($type) {
            case 'next':
                if ($next_id < 0)
                    foreach ($tree as $k => $t) {
                        $next_id = $k;
                        break 1;
                    }
                if ($id == 0) $next_id = 0;
                return $next_id;
                break;
            case 'prev':
                if ($prev_id == 0)
                    foreach ($tree as $k => $t)
                        $prev_id = $k;
                if ($id == 0) $prev_id = 0;
                return $prev_id;
                break;
            default:
                return $id;
                break;
        }
    }

    /* protected function login(){
        $out = array();
        if(!isset($_POST['LoginForm'])) return $out;
        $out['error'] = 'Неверный логин или пароль';
        $out['username'] = $_POST['LoginForm']['username'];
        $out['password'] = $_POST['LoginForm']['password'];
        $model=new LoginForm;
        $model->role_id = array(4);
        if(isset($_POST['LoginForm'])){
            $model->attributes=$_POST['LoginForm'];
            if($model->validate() && $model->login(4))
                $out['error'] = '';
        }
        return $out;
    } */
	
	protected function breadcrumbs($id, $id_last = NULL){
		if(is_null($id_last)) $id_last = $id;
		$out = array();
		$pages = new Pages();
		$i = 0;
		do {
			if($i==0){
				if($id==$id_last){
					$page = $pages->findByPk($id);
					$out[] = $page->name;
				}else{
					$id = $id_last;
					$page = $pages->findByPk($id);
					$url = $pages->make_url($id);
					$out[] = '<a href="'.$url.'">'.$page->name.'</a>';
				}
			}else{
				$page = $pages->findByPk($id);
				$url = $pages->make_url($id);
				$out[] = '<a href="'.$url.'">'.$page->name.'</a>';
			}
			$id = $page->parent_id;
			$i++;
		} while($id>0);
		return implode(' &mdash; ', array_reverse($out));
	}

	public function actionIndex()
	{
		//if($this->beginCache('doc_url_'.md5(Yii::app()->request->url), array('duration'=>3600*24))) {
		$pages = new Pages();
		$data = array();
        $data['helper']['tree'] = ModuleHelper::model()->getTree();
        $data['helper']['list'] = ModuleHelper::model()->getList();
		$data['tree'] = $pages->getTreePages2(true);
		// $pages->getTreePages(NULL,$data['tree'],true);
		$data['pages'] = $pages;
		$data['doc_id'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree']);
//        echo '<pre>';
//        var_dump($data['tree']);
//        die;
		$data['doc_id_top'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree'],1);
		$data['doc_id_last'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree'],-1);
		$data['page_images'] = $pages->get_images($data['doc_id_last']);
		$data['content'] = trim($pages->getPageText($data['doc_id_last']));
		$data['title'] = trim($pages->getPageNameById($data['doc_id_last']));
		$data['longtitle'] = trim($pages->findByPk($data['doc_id_last'])->title);
        if(empty($data['longtitle'])) $data['longtitle'] = $data['title'];
		$data['short'] = trim($pages->findByPk($data['doc_id_last'])->short);
		$data['code'] = trim($pages->findByPk($data['doc_id_last'])->code);
		$data['meta_keywords'] = trim($pages->findByPk($data['doc_id_last'])->meta_keywords);
		$data['meta_description'] = trim($pages->findByPk($data['doc_id_last'])->meta_description);
		$data['breadcrumbs'] = $this->breadcrumbs($data['doc_id'], $data['doc_id_last']);
		if(empty($data['meta_keywords'])) $data['meta_keywords'] = trim($pages->findByPk(1)->meta_keywords);
		if(empty($data['meta_description'])) $data['meta_description'] = trim($pages->findByPk(1)->meta_description);
		$data['url_for_menu'] = Yii::app()->request->pathInfo;
		// следующая/предыдущая страница
		$data['doc_id_next'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree'],0,'next');
		$data['doc_id_prev'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree'],0,'prev');
		$data['additional_main_data'] = ModuleFields::model()->getValueListByPageId(1);
		// привязка форм
		switch($data['doc_id']){
			/*case '2':
				$data['include'] = array('forms/purchase');
				$data['include_title'] = '';
				break;*/
			default:
				$data['include'] = array();
				break;
		}

		$hidden_pages = array();
		$pages_id_records_templates = array(
			'lenta_files_category'=>array(), //файлы с категориями
			'lenta_records_simple'=>array(), //простой список
			'lenta_records'=>array(), //для вакансий?
			'magazine'=>array(), //для магазина
			'consult'=>array() //для вопрос/ответ
		);
		$pages_id_redirect_to_next_level = array();
		$pages_id_not_redirect_to_next_level = array(25, 13);

		if($data['doc_id']==27){
			if($_POST['type']=='vacancy'){
				if(isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])){
					$filepath = array(
						$_FILES['file']['tmp_name']
					);
					$filename = array(
						$_FILES['file']['name']
					);
					$subject = 'Резюме с сайта «Экопромбанк»';
					$message = '<p>Новое резюме с сайта «Экопромбанка» на должность «'.$_POST['title'].'»</p>';
					$this->emails = Settings::model()->getMail2();
                    $out = $this->sending($subject,array(),$filepath,$filename,$message);
                    $this->emails = '';
					if($out==0){
						Yii::app()->user->setFlash('message','<p class="success"><strong>Спасибо Вам! Мы рассмотрим резюме и свяжемся с Вами в ближайшее время!</strong></p>');
					}else{
						Yii::app()->user->setFlash('message','<p class="success" style="color:red;"><strong>К сожаленью произошла ошибка. Попробуйте отправить резюме позже или свяжитесь с нами по телефону (342) 200-79-77.</strong></p>');
						Yii::app()->user->setFlash('error','1');
					}
				}else{
					Yii::app()->user->setFlash('message','<p class="success" style="color:red;"><strong>Необходимо прикрепить файл.</strong></p>');
					Yii::app()->user->setFlash('error','1');
				}
				Yii::app()->user->setFlash('form_id',$_POST['form_id']);
				$this->redirect('/'.Yii::app()->request->pathInfo.'/#vform_'.$_POST['form_id']);
			}
		}
		// $this->cookie_basket($data);
		if(empty(Yii::app()->request->pathInfo)/*  || empty(Yii::app()->user->id) */){

			/*$login = $this->login();
			if((count($login)>0 && empty($login['error'])) || !empty(Yii::app()->user->id)){
				if(empty(Yii::app()->request->pathInfo)) $this->redirect('/state/');
				$this->redirect('/'.Yii::app()->request->pathInfo.'/');
			}
			$data['error'] = $login['error'];
			$data['username'] = $login['username'];
			$data['password'] = $login['password'];*/
			$data['doc_id'] = 1;
			$data['doc_id_top'] = 1;
			$data['doc_id_last'] = 1;
			$data['content'] = trim($pages->getPageText($data['doc_id_last']));
			$data['title'] = trim($pages->getPageNameById($data['doc_id_last']));
			$data['short'] = trim($pages->findByPk($data['doc_id_last'])->short);
			$data['code'] = 'index';
			$data['news_common_doc_id'] = 65;
			$data['news_common_list'] = ModuleNews::model()->getList(ModulesInPages::model()->getLink($data['news_common_doc_id'],'news'),0,2,1);
			$this->render('index', $data);
		}else{
			$active_modules = Modules::model()->getActiveModule($data['doc_id_last']);
			if(count($active_modules)){
				if(count($active_modules)==2 && array_key_exists(6,$active_modules) && array_key_exists(9,$active_modules)){
					$this->moduleList3($data);
				}else{
					foreach($active_modules as $a_id=>$a){
						/*if($a['code']!='news'){
							$data['news_common_doc_id'] = 6;
							$data['news_common_list'] = ModuleNews::model()->getList(ModulesInPages::model()->getLink($data['news_common_doc_id'],'news'),0,1,1);
							$data['list2_common_doc_id'] = 6;
							$data['list2_common_list'] = ModuleList2::model()->getList(ModulesInPages::model()->getLink($data['list2_common_doc_id'],'list2'),0,1,1);
						}*/
						switch($a['code']){
							/*case 'catalog':
								$this->moduleCatalog($data);
								break;*/
							case 'news':
								$this->moduleNews($data);
								break 2;
							case 'list':
								$this->moduleList($data);
								break 2;
							case 'list2':
								$this->moduleList2($data);
								break 2;
							case 'list3':
								$this->moduleList3($data);
								break 2;
							case 'mfiles':
								$this->moduleMfiles($data);
								break 2;
							case 'ymaps':
								$this->moduleYmaps($data);
								break 2;
							/*case 'complaint_book':
								$this->moduleComplaint_book($data);
								break;
							case 'fields':
								$this->moduleFields($data);
								break;
							case 'flats':
								$this->moduleFlats($data);
								break;
							case 'questions':
								$this->moduleQuestions($data);
								break;*/
							default:
								//$this->actionError();
								$active_modules = array();
								break;
						}
					}
				}
			}
			if(count($active_modules)==0){
                /*echo $data['doc_id'];
                die;*/
				/*
				$data['news_common_doc_id'] = 6;
				$data['news_common_list'] = ModuleNews::model()->getList(ModulesInPages::model()->getLink($data['news_common_doc_id'],'news'),0,1,1);
				$data['list2_common_doc_id'] = 6;
				$data['list2_common_list'] = ModuleList2::model()->getList(ModulesInPages::model()->getLink($data['list2_common_doc_id'],'list2'),0,1,1);
				*/
				switch($data['doc_id_last']){
					default:
						switch($data['doc_id']){
							case 0:
								$this->actionError();
								break;
							case 12:
								$this->render('safe', $data);
								break;
                            case 23:
                                $this->render('safe', $data);
                                break;
							case 39:
								$this->moduleCardSelect($data);
								break;
							case 49:
								$this->render('perevod', $data);
								break;
							case 77:
								$this->render('exchange', $data);
								break;
							case 26:
								// $mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'ymaps');
								// $mpage_id = ModulesInPages::model()->getLink(26,'ymaps');
								// $data['list'] = ModuleYmapsCategories::model()->getList($mpage_id,0,0,1,true);

                                $cache_hash = md5('data#atms_list');
                                $data['list'] = Yii::app()->cache->get($cache_hash);
                                if($data['list']===false){

                                    $data['list'] = array();
                                    $i = 0;
                                    foreach(array(100 => 256, 101 => 281, 102 => 286) as $page_id => $category_param_id){
                                        $i++;
                                        $mpage_id = ModulesInPages::model()->getLink($page_id,'list4');
                                        $object = array();
                                        $object['title'] = Pages::model()->findByPk($page_id)->name;
                                        $object['points'] = '';
                                        $object = (object)$object;
                                        $object->points = ModuleList4::model()->getList($mpage_id,0,0,1);
                                        foreach($object->points as $key => $value){
                                            $item = ModuleList4::model()->getList4($key,$mpage_id,2);
                                            if(count($item['params'][$category_param_id]['values'])){
                                                $new_params = $item['params'][$category_param_id]['values'][0]['value']['params'];
                                                $array = array();
                                                foreach($new_params as $k => $v){
                                                    $array[$v['code']] = array(
                                                        'id' => $v['id'],
                                                        'title' => $v['title'],
                                                        'data_type_id' => $v['data_type_id'],
                                                        'value' => '',
                                                        'value_id' => ''
                                                    );
                                                    if(isset($v['values'][0]['value'])) $array[$v['code']]['value'] = $v['values'][0]['value'];
                                                    if(isset($v['values'][0]['value_id'])) $array[$v['code']]['value_id'] = $v['values'][0]['value_id'];
                                                }
                                                $params = $value->params;
                                                $object->points[$key]->params = $params + $array;
                                                // echo '<pre>';
                                                // var_dump($new_params);
                                                // var_dump($object->points[$key]->params);
                                                // echo '</pre>';
                                                // die;
                                            }
                                            foreach($object->points[$key]->params as $k => $v){
                                                $object->points[$key]->params[$k] = (object)$v;
                                            }
                                        }
                                        $data['list'][$i] = $object;
                                    }


                                    Yii::app()->cache->set($cache_hash, $data['list'], 3600*24*30);
                                }

								$this->render('atms', $data);
								break;
							default:

								if(/*in_array($data['doc_id'],$pages_id_redirect_to_next_level)*/ !in_array($data['doc_id'],$pages_id_not_redirect_to_next_level)){
									$temp_array = array();
									$temp_array = $pages->getTreePages($data['doc_id'],$temp_array);
									foreach($temp_array as $id=>$t){
										break;
									}
									if(count($temp_array)>0){
										$this->redirect($pages->make_url($id));
									}
								}
								if(!in_array(Yii::app()->request->pathInfo,$hidden_pages)){
									$this->render('list', $data);
								}else{
									Yii::app()->runController('main/'.Yii::app()->request->pathInfo);
								}
								break;
						}
						break;
				}
			}
		}
		//	$this->endCache();
		//}
	}

	protected function moduleCatalog($data){
		$pages = $data['pages'];
		$link_id = ModulesInPages::model()->getLink($data['doc_id_last'],'catalog');
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='show_'){ // конкретный продукты
			$item_id = floor(substr($type,5));
			$data['item'] = ModuleCatalogSuite::model()->getItem($link_id,$item_id);
			if(!$data['item']) $this->redirect($pages->make_url($data['doc_id_last']));
			$data['accessories_tab'] = ModuleCatalogAccessoriesTab::model()->getList($link_id);
			$data['title'] = '«'.$data['item']->catalog->title.'», '.$data['item']->color.' — '.$data['title'];
			$this->render('item', $data);
		}elseif(empty($type)){
			$data['catalog'] = ModuleCatalog::model()->getList($link_id);
			$data['catalog_type'] = ModuleCatalogType::model()->getList();
			$this->render('catalog', $data);
		}else{
			// неизвестный тип отображения ПРОДУКТОВ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleNews($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'news');
		$records_on_page = 10; // количество новостей на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='show_'){ // конкретная новость
			$lenta = new ModuleNews();
			$news_id = floor(substr($type,5));
			if($lenta->existsItem($mpage_id,$news_id,1)){
				$data['news_id'] = $news_id;
				$data['lenta'] = $lenta->getItem($news_id,$mpage_id);
				$data['lastNews'] = $lenta->getLastNewsList($mpage_id, $news_id, 4);
				if(count($data['lenta'])==0){
					$this->redirect($pages->make_url($data['doc_id_last']));
				}else{
					$data['page_title'] = $data['title'];
					$data['title'] = $data['lenta']['title'].' — '.$data['title'];
					$this->render('news_show', $data);
				}
			}else{
				// новость не найдена
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}elseif(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$lenta = new ModuleNews();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			$url = $pages->make_url($data['doc_id_last']).'page_';
			
			$data['year'] = $lenta->get_years($mpage_id,1);
			$in_years = FALSE;
			$year_count = count($data['year']);
			$get_year = 0;
			if(isset($_GET['y'])) $get_year = (int)$_GET['y'];
			for($i = 0; $i<$year_count; $i++){
				if($get_year==$data['year'][$i]->year) $in_years = TRUE;
			}
			if(!$in_years) $get_year = 0;
			$data['get_year'] = $get_year;
			
			$news_count = $lenta->getCount($mpage_id,1,$get_year);
			$data['pagination'] = $this->pagination($url,$news_count,$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			//$data['lenta'] = $pages->getModuleNews($data['doc_id_last'],$offset,$limit);
			
			$data['page_num'] = $page;
			$data['newsList'] = ModuleNews::model()->getList($mpage_id,$offset,$limit,1,$get_year);
			$data['year_pagination'] = $this->year_pagination($pages->make_url($data['doc_id_last']),$news_count,$page,$records_on_page,$data['year']);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$this->render('news', $data);
		}else{
			// неизвестный тип отображения НОВОСТЕЙ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleNewsList2($data){
		$pages = $data['pages'];
		$mpage_id_list2 = ModulesInPages::model()->getLink($data['doc_id_last'],'list2');
		$mpage_id_news = ModulesInPages::model()->getLink($data['doc_id_last'],'news');
		$records_on_page = 10; // количество новостей на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='show_'){ // конкретная новость
			$lenta = new ModuleNews();
			$news_id = floor(substr($type,5));
			if($lenta->existsItem($mpage_id_news,$news_id,1)){
				$data['news_show'] = 1;
				$data['item_id'] = $news_id;
				$data['item'] = $lenta->getItem($news_id,$mpage_id_news);
				$data['lastNews'] = $lenta->getLastNewsList($mpage_id_news, $news_id, 2);
				$list2 = new ModuleList2();
				$data['list2'] = ModuleList2::model()->getList($mpage_id_list2,0,0,1);
				$data['doc_id_list2'] = $data['doc_id_last'];
				if(count($data['item'])==0){
					$this->redirect($pages->make_url($data['doc_id_last']));
				}else{
					$data['title'] = $data['item']['title'].' — '.$data['title'];
					$this->render('news_list2_show', $data);
				}
			}else{
				// новость не найдена
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}elseif(substr($type,0,7)=='action_'){ // конкретная акция
			$list2 = new ModuleList2();
			$lenta = new ModuleNews();
			$action_id = floor(substr($type,7));
			if($list2->existsItem($mpage_id_list2,$action_id,1)){
				$data['news_show'] = 0;
				$data['item_id'] = $action_id;
				$data['item'] = $list2->getItem($action_id,$mpage_id_list2);
				$data['doc_id_list2'] = $data['doc_id_last'];
				$data['list2'] = $list2->getOtherList($mpage_id_list2, $action_id,0,1);
				$data['lastNews'] = $lenta->getLastNewsList($mpage_id_news, 0, 2);
				if(count($data['item'])==0){
					$this->redirect($pages->make_url($data['doc_id_last']));
				}else{
					$data['title'] = $data['list2']['title'].' — '.$data['title'];
					$this->render('news_list2_show', $data);
				}
			}else{
				// акция не найдена
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}elseif(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$lenta = new ModuleNews();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			$data['pagination'] = $this->pagination($pages->make_url($data['doc_id_last']).'page_',$lenta->getCount($mpage_id_news,1),$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data['newsList'] = ModuleNews::model()->getList($mpage_id_news,$offset,$limit,1);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$data['list2'] = ModuleList2::model()->getList($mpage_id_list2,0,0,1);
			$data['doc_id_list2'] = $data['doc_id_last'];
			$this->render('news_list2', $data);
		}else{
			// неизвестный тип отображения
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleList($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'list');
		$lenta = new ModuleList();
		$data['lenta'] = ModuleList::model()->getList($mpage_id,0,0,1);
		$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
		$this->render('list1', $data);
	}

	protected function moduleList2($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'list2');
		$records_on_page = 0; // количество публикаций на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='show_'){ // конкретная публикация
			$lenta = new ModuleList2();
			$item_id = floor(substr($type,5));
			if($lenta->existsItem($mpage_id,$item_id,1)){
				$data['item_id'] = $item_id;
				$data['item'] = $lenta->getItem($item_id,$mpage_id);
				$data['other_lenta'] = $lenta->getOtherList($mpage_id, $item_id,4,1);
				if(count($data['item'])==0){
					$this->redirect($pages->make_url($data['doc_id_last']));
				}else{
					$data['title_original'] = $data['title'];
					$data['title'] = $data['item']['title'].' — '.$data['title'];
					$this->render('list2_show', $data);
				}
			}else{
				// публикация не найдена
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}elseif(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$lenta = new ModuleList2();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			if($records_on_page>0) $data['pagination'] = $this->pagination($pages->make_url($data['doc_id_last']).'page_',$lenta->getCount($mpage_id,1),$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data['lenta'] = ModuleList2::model()->getList($mpage_id,$offset,$limit,1);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$this->render('list2', $data);
		}else{
			// неизвестный тип отображения ПУБЛИКАЦИЙ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleList3($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'list3');
		$records_on_page = 0; // количество публикаций на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='show_'){ // конкретная публикация
			$lenta = new ModuleList3();
			$item_id = floor(substr($type,5));
			if($lenta->existsItem($mpage_id,$item_id,1)){
				$data['item_id'] = $item_id;
				$data['item'] = $lenta->getItem($item_id,$mpage_id);
                $data['longtitle'] = $data['item']['title'];
                switch($data['doc_id_last']){
                    case 37:
                        $data['longtitle'] = 'Вклад '.$data['item']['title'];
                        break;
                    /*case :
                        $data['longtitle'] = ''.$data['item']['title'];
                        break;*/
                }
				//$data['other_lenta'] = $lenta->getOtherList($mpage_id, $item_id,4,1);
				if(count($data['item'])==0){
					$this->redirect($pages->make_url($data['doc_id_last']));
				}else{
					$data['title'] = $data['item']['title'].' — '.$data['title'];
					if($data['doc_id_last']==37) {
                        $data['list3'] = ModuleList3::model()->getList($mpage_id);
                        $ids = array();
                        foreach($data['list3'] as $value) {
                            $ids[] = $value->id;
                        }
                        $count = count($ids);
                        $i = 0;
                        while ($ids[$i] != $item_id) $i++;
                        if ($i == 0) {
                            $data['prev'] = false;
                            $data['next'] = $count > 1 ? $lenta->getItem($ids[1],$mpage_id) : false;
                        }
                        else if ($i == $count - 1) {
                            $data['prev'] = $count > 1 ? $lenta->getItem($ids[$i-1],$mpage_id) : false;
                            $data['next'] = false;
                        }
                        else {
                            $data['prev'] = $lenta->getItem($ids[$i-1],$mpage_id);
                            $data['next'] = $lenta->getItem($ids[$i+1],$mpage_id);
                        }
                        $list3files = ModuleList3Files::model()->findAllByAttributes(array('item_id'=>$item_id));
                        if (count($list3files) > 0) {
                            foreach($list3files as $file) {
                                $data['files'][$file->id]['short'] = $file->short;
                                $data['files'][$file->id]['ref'] = Files::model()->getVirtualPath('list3',$file->file_id);
                            }
                        }
                        $this->render('deposit_show', $data);
                    }
						else $this->render('list3_show', $data);
				}
			}else{
				// публикация не найдена
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}elseif(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$lenta = new ModuleList3();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			if($records_on_page>0) $data['pagination'] = $this->pagination($pages->make_url($data['doc_id_last']).'page_',$lenta->getCount($mpage_id,1),$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data['list3'] = ModuleList3::model()->getList($mpage_id,$offset,$limit,1);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			if($data['doc_id_last']==37) $this->render('deposit', $data);
				else $this->render('list3', $data);
		}else{
			// неизвестный тип отображения ПУБЛИКАЦИЙ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}
	
	protected function moduleCardSelect($data){
		$mpage_id = ModulesInPages::model()->getLink(40,'list3');
		$data['debit_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);
		$mpage_id = ModulesInPages::model()->getLink(41,'list3');
		$data['credit_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);
        $mpage_id = ModulesInPages::model()->getLink(110,'list3');
        $data['storage_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);
        $mpage_id = ModulesInPages::model()->getLink(111,'list3');
        $data['pension_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);
        $mpage_id = ModulesInPages::model()->getLink(112,'list3');
        $data['salary_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);
		$this->render('card_select', $data);
	}
	
	protected function moduleYmaps($data){
		/*$mpage_id = ModulesInPages::model()->getLink(40,'list3');
		$data['debit_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);
		$mpage_id = ModulesInPages::model()->getLink(41,'list3');
		$data['credit_cards'] = ModuleList3::model()->getList($mpage_id,0,0,1);*/
		$pages = $data['pages'];
			$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'ymaps');
			$data['list'] = ModuleYmapsCategories::model()->getList($mpage_id,0,0,1,true);
			$this->render('ymaps', $data);
	}

	protected function moduleQuestions($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'questions');
		$records_on_page = 0; // количество публикаций на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='show_'){ // конкретная публикация
			$lenta = new ModuleQuestions();
			$item_id = floor(substr($type,5));
			if($lenta->existsItem($mpage_id,$item_id,1)){
				$data['item_id'] = $item_id;
				$data['lenta'] = $lenta->getItem($item_id,$mpage_id);
				$data['other_lenta'] = $lenta->getOtherList($mpage_id, $item_id,4,1);
				if(count($data['lenta'])==0){
					$this->redirect($pages->make_url($data['doc_id_last']));
				}else{
					$data['title'] = $data['lenta']['title'].' — '.$data['title'];
					$this->render('question_show', $data);
				}
			}else{
				// публикация не найдена
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}elseif(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$lenta = new ModuleQuestions();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			if($records_on_page>0) $data['pagination'] = $this->pagination($pages->make_url($data['doc_id_last']).'page_',$lenta->getCount($mpage_id,1),$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data['lenta'] = ModuleQuestions::model()->getList($mpage_id,$offset,$limit,1);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$this->render('questions', $data);
		}else{
			// неизвестный тип отображения ПУБЛИКАЦИЙ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleComplaint_book($data){
		$pages = $data['pages'];
		$records_on_page = 1; // количество отзывов на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'complaint_book');
		if(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$complaint_book = new ModuleComplaintBook();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			$data['pagination'] = $this->pagination($pages->make_url($data['doc_id_last']).'page_',$complaint_book->getCount($mpage_id,1),$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data['list'] = $complaint_book->getList($mpage_id,$offset,$limit,1);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$data['include'] = array('forms/complaint_book');
			$data['include_title'] = 'Ваше предложение или отзыв';
			$this->render('complaint_book', $data);
		}else{
			// неизвестный тип отображения ПУБЛИКАЦИЙ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleCatalog_decision($data){
		$pages = $data['pages'];
		$records_on_page = 8; // количество отзывов на странице
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		// фильтры
		$params = array();
		if(isset($_GET['wear_id'])) $params['wear_id'] = $_GET['wear_id'];
		if(isset($_GET['category_id']) && $_GET['category_id']!='') $params['category_id'] = (int)$_GET['category_id'];
		if(isset($_GET['category_id']) && $_GET['category_id']=='0') $params['category_id'] = '0';
		if(isset($_GET['size_id']) && (int)$_GET['size_id']) $params['size_id'] = (int)$_GET['size_id'];
		$data['params'] = $params;
		
		if(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$decision = new ModuleCatalogDecision();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			$decision_count = $decision->getCount($params,1);
			// if($decision_count==0 && count($params)) $this->redirect($pages->make_url($data['doc_id_last']));
			$data['pagination'] = $this->pagination($pages->make_url($data['doc_id_last']).'page_',$decision_count,$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$data['decision'] = $decision->getList($params,$offset,$limit,1);
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$this->render('catalog', $data);
		}elseif(substr($type,0,5)=='show_'){ // конкретная публикация
			$decision = new ModuleCatalogDecision();
			$item_id = floor(substr($type,5));
			$data['item_id'] = $item_id;
			$data['decision'] = $decision->getList($params,0,0,1);
			$data['item'] = $decision->getList(array('ids'=>array($item_id)),0,0);
			if(count($data['item'])==0){
				$this->redirect($pages->make_url($data['doc_id_last']));
			}else{
				$data['title'] = $data['item'][$item_id]->longtitle.' — '.$data['title'];
				$this->render('catalog_show', $data);
			}
		}else{
			// неизвестный тип отображения ПУБЛИКАЦИЙ
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleFields($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'fields');
		$data['fields'] = ModuleFields::model()->getListByCode($mpage_id);
		$data['include'] = array('forms/calculator');
		$this->render('list', $data);
	}

	protected function moduleFlats($data){
		$pages = $data['pages'];
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'flats');
		if(empty($type)){
			$data['flats'] = ModuleFlats::model()->getList($mpage_id,3,0,'bought < :bought');
			$this->render('flats', $data);
		}elseif(substr($type,0,5)=='show_'){ // конкретная квартира
			$flats = new ModuleFlats();
			$item_id = floor(substr($type,5));
			$data['item_id'] = $item_id;
			$data['flats'] = $flats->getList($mpage_id);
			$data['item'] = $flats->getItem($mpage_id,$item_id);
			if($data['item']){
				$data['title'] = 'Квартира №'.$data['item']->number;
				$this->render('flat_show', $data);
			}else{
				$this->redirect($pages->make_url($data['doc_id_last']));
			}
		}else{
			// неизвестный тип отображения КВАРТИР
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}

	protected function moduleMfiles($data){
		$pages = $data['pages'];
		$mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'mfiles');
		$records_on_page = 10; // количество новостей на странице
		$data['group_of_files'] = 0;
		$data['table_of_files'] = 0;
		
		$fields_mpage_id = ModulesInPages::model()->getLink($data['doc_id_last'],'fields');
		if($fields_mpage_id>0){
			$fields = ModuleFields::model()->getListByCode($fields_mpage_id);
			if(isset($fields['items_on_page']) && (int)$fields['items_on_page']->value>0){
				$records_on_page = (int)$fields['items_on_page']->value;
			}
			if(isset($fields['items_on_page']) && $fields['items_on_page']->value=='0'){
				$records_on_page = 0;
			}
			if(isset($fields['group_of_files'])){
				$data['group_of_files'] = (int)$fields['group_of_files']->value;
			}
			if(isset($fields['table_of_files'])){
				$data['table_of_files'] = (int)$fields['table_of_files']->value;
			}
		}
		
		$type = explode($pages->make_url($data['doc_id_last']),'/'.Yii::app()->request->pathInfo);
		$type = explode('/',$type[1]);
		$type = $type[0];
		if(substr($type,0,5)=='page_' || empty($type)){ // выбор страницы
			$page = 1;
			$lenta = new ModuleFiles();
			if(!empty($type)) $page = floor(substr($type,5));
			if($page<1) $page = 1;
			$url = $pages->make_url($data['doc_id_last']).'page_';
			
			$data['year'] = $lenta->get_years($mpage_id,1);
			$in_years = FALSE;
			$year_count = count($data['year']);
			$get_year = 0;
			if(isset($_GET['y'])) $get_year = (int)$_GET['y'];
			for($i = 0; $i<$year_count; $i++){
				if($get_year==$data['year'][$i]->year) $in_years = TRUE;
			}
			if(!$in_years) $get_year = 0;
			$data['get_year'] = $get_year;
			
			$news_count = $lenta->getCount($mpage_id,1,$get_year);
			if($records_on_page>0){
				$data['pagination'] = $this->pagination($url,$news_count,$page,$records_on_page);
			}
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			//$data['lenta'] = $pages->getModuleNews($data['doc_id_last'],$offset,$limit);
			
			$data['page_num'] = $page;
			$data['list'] = ModuleFiles::model()->getList($mpage_id,$offset,$limit,1,$get_year,$data['group_of_files']);
			if($records_on_page>0){
				$data['year_pagination'] = $this->year_pagination($pages->make_url($data['doc_id_last']),$news_count,$page,$records_on_page,$data['year']);
			}
			$data['url_for_menu'] = substr(substr($data['pages']->make_url($data['doc_id_last']),0,-1),1);
			$data['records_on_page'] = $records_on_page;
			$this->render('mfiles', $data);
		}else{
			// неизвестный тип отображения
			$this->redirect($pages->make_url($data['doc_id_last']));
		}
	}
	/*
	public function actionBasket(){
	    $pages = new Pages();
		$data = array();
		// $pages->getTreePages(NULL,&$data['tree'],true);
		$data['tree'] = $pages->getTreePages2(true);
		$data['pages'] = $pages;
		$data['doc_id'] = 0;
		$data['doc_id_top'] = -1;
		$data['content'] = '';
		$data['title'] = 'Корзина';
		$data['short'] = '';
		$data['code'] = 'basket';
		$data['meta_keywords'] = trim($pages->findByPk(1)->meta_keywords);
		$data['meta_description'] = trim($pages->findByPk(1)->meta_description);
		$data['url_for_menu'] = 'basket';
		$this->cookie_basket($data);
		if(count($data['cookie_data'])==0) $this->redirect('/');
		
		$this->render('basket', $data);
	}
	
	private function cookie_basket(&$data){
		
		// !!! $s_id на 1 меньше, т.к. во frontend'е нумерация начинается с 1, а в БД с 2 !!!
		
		// для отображении корзины на всех страницах сайта
		$data['cookie'] = json_decode($_COOKIE['basket']);
		$data['cookie_ids'] = array();
		if(count($data['cookie'])>0){
			foreach($data['cookie'] as $c){
				$data['cookie_ids'][$c->id.'_'.((int)$c->size)] = $c->id;
			}
		}
		$data['cookie_data'] = ModuleCatalogDecision::model()->getList(array('ids'=>$data['cookie_ids']),0,0);
		if(is_array($data['cookie'])){
			if(count($data['cookie'])>0){
				foreach($data['cookie'] as $c_key=>$c){
					if(!array_key_exists($c->id,$data['cookie_data']) || !array_key_exists((int)$c->size+1,$data['cookie_data'][$c->id]->sizes)){
						unset($data['cookie'][$c_key]);
					}
				}
			}
		}else{
			$data['cookie'] = array();
		}
		setcookie('basket', json_encode($data['cookie']), time()+60*60*24*30, "/");
		// обновление массива
		$data['cookie_ids'] = array();
		$data['cookie_price'] = 0;
		$data['cookie_count'] = 0;
		if(count($data['cookie'])>0){
			foreach($data['cookie'] as $c){
				$data['cookie_price'] += floatval($c->price)*(int)$c->quan;
				$data['cookie_count'] += (int)$c->quan;
				$data['cookie_ids'][$c->id.'_'.((int)$c->size)] = $c->id;
			}
		}
		$data['cookie_header'] = 'Вы еще ничего<br> не заказали';
		if($data['cookie_count'])
			$data['cookie_header'] = '<a href="/basket/">'.$data['cookie_count'].' '.$this->plural($data['cookie_count'],'товар','товара','товаров').'<br> на '.$data['cookie_price'].' руб.</a>';
		// конец корзины
	}
	*/
	
	
	public function actionSearch(){
	    $pages = new Pages();
		$data = array();
		// $pages->getTreePages(NULL,&$data['tree'],true);
		$data['tree'] = $pages->getTreePages2(true);
		$data['pages'] = $pages;
		$data['doc_id'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree']);
		$data['doc_id_top'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree'],1);
		$data['doc_id_last'] = $this->get_id(Yii::app()->request->pathInfo,$data['tree'],-1);
		$data['content'] = '<p><a target="_blank" href="http://www.yandex.ru"><img src="/pics/i/yandex-for-white-background.png" alt="Yandex" title="Yandex" style="margin-right: 11px; position: relative; top: -5px;"></a>';
		$data['title'] = trim('Поиск по сайту');
		$data['short'] = '';
		$data['code'] = 'search';
		$data['query'] = array_key_exists('searchString', $_REQUEST) ? $_REQUEST['searchString'] : '';
		$data['query'] = trim($data['query']);
		$data['url_for_menu'] = Yii::app()->request->pathInfo;
		$data['additional_main_data'] = ModuleFields::model()->getValueListByPageId(1);
		$host  = 'www.ecoprombank.ru';
		if(!empty($data['query'])){
			$esc = htmlspecialchars($data['query']);
			$ehost = htmlspecialchars($host);
			$search_tail = htmlspecialchars(" host:$ehost");
			if($_SERVER["REQUEST_METHOD"] =='GET'){
				$page = array_key_exists('page', $_GET)? $_GET['page'] : 0;
			}else $page = 0;
// XML запрос
$doc = <<<DOC
<?xml version='1.0' encoding='utf-8'?>
	<request>
		<query>$esc $search_tail</query>
		<groupings>
			<groupby attr="" mode="flat" groups-on-page="10" docs-in-group="1" />
		</groupings>
		<page>$page</page>
	</request>
DOC;
			$context = stream_context_create(array(
				'http' => array(
				'method'=>"POST",
				'header'=>"Content-type: application/xml\r\n" .
						  "Content-length: " . strlen($doc),
				'content'=>$doc
				)
			));
			$response = file_get_contents('http://xmlsearch.yandex.ru/xmlsearch?user=ecoprombank&key=03.133003686:fadca582b2d0ab2f7ba1128f9d14fc2e', true, $context);
			if($response){
				$xmldoc = new SimpleXMLElement($response);
				$error = $xmldoc->response->error;
				$found_all = $xmldoc->response->found;
				$found = $xmldoc->xpath("response/results/grouping/group/doc");
				if($error){
					$data['content'] .= "</p><p>Ошибка: ".$error[0]."</p>";
				}else{
					$data['content'] .= "нашёл <b>$found_all</b> страниц</p>\n";
					$data['content'] .= "<h2>Результаты поиска</h2>";
					$data['content'] .= "<ol start='" . ($page * 10 + 1) . "' class=\"searchResult\">\n";
					foreach ($found as $item) {
						$data['content'] .= "<li>";
						$data['content'] .= "<strong><a href='{$item->url}'>" . $this->highlight_words($item->title) . "</a></strong>";
						if($item->passages){
							foreach ($item->passages->passage as $passage) {
								$data['content'] .= "<p>" . $this->highlight_words($passage) . "<p>";
							}
						}
						// $data['content'] .= "<span style='color: gray; font-size: 80%'>{$item->url}</span>";
						$data['content'] .= "</li>";
					}
					$data['content'] .= "</ol>\n";
					$this->print_pager($found_all, $data['query'], $host, $page, 10, $data['content']);
				}
			}else{
				$data['content'] .= "</p><p>Внутренняя ошибка сервера.</p>\n";
			}
		}
		$data['content'] = '
			<div class="searchFieldBig">
				<form action="/search/" method="GET" class="searchFormBig clearfix">
				    <input type="submit" value="Найти" class="btn btnSmall searchBtn">
				    <div class="inpC">
					    <input type="text" autocomplete="off" value="'.$data['query'].'" name="searchString" class="inp" id="searchText">
					</div>
				</form>
			</div>'.$data['content'];
		$this->render('list', $data);
	}

	public function actionError()
	{
		header("HTTP/1.1 404 Not Found");
		$pages = new Pages();
		$data = array();
		// $pages->getTreePages(NULL,&$data['tree']);
		$data['tree'] = $pages->getTreePages2(true);
		$data['title'] = 'Страница не найдена';
		$data['pages'] = $pages;
		$data['additional_main_data'] = ModuleFields::model()->getValueListByPageId(1);
		// $this->redirect('/');
	    $this->render('404', $data);
	}

	/*public function actionOrders($h = NULL, $type = NULL)
	{
		if(is_null($h)){
			header("HTTP/1.1 404 Not Found");
			$pages = new Pages();
			$data = array();
			// $pages->getTreePages(NULL,&$data['tree']);
			$data['tree'] = $pages->getTreePages2(true);
			$data['title'] = 'Страница не найдена';
			$data['pages'] = $pages;
			// $this->redirect('/');
			$this->render('404', $data);
		}else{
			if(!is_null($type) && $type=='xml') echo $this->renderPartial('order_xml', array('h'=>$h));
				else $this->render('order', array('h'=>$h));
		}
	}*/

	/* public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('/');
	} */
}