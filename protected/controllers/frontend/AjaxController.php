<?php
class AjaxController extends FrontEndController
{
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
				substr($f,0,7)!='http://' && file_exists(dirname(__FILE__).'/../../..'.$f) ||
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
					$file_path = dirname(__FILE__).'/../../..'.$f;
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
			};
			$body .= "--".$this->boundary ."--\n";
		};
		return mail($to, $subject, $body, $headers);
	}
	protected function sending($subject,$labels,$filepath = array(),$filename = array(),$message = ''){
		if(empty($message)){
			$i = 0;
			foreach($labels as $k=>$v){
				if($v==''){
					if(!in_array($k,array('Сообщение'))){
						$message .= '<b>'.$k.':</b> '.htmlspecialchars($_POST[$this->data_prefix.$i]).'<br>';
					}else{
						$message .= '<b>'.$k.':</b><br>'.nl2br(htmlspecialchars($_POST[$this->data_prefix.$i])).'<br>';
					};
				}else{
					if(!in_array($k,array('Сообщение'))){
						$message .= '<b>'.$k.':</b> '.htmlspecialchars($_POST[$v]).'<br>';
					}else{
						$message .= '<b>'.$k.':</b><br>'.nl2br(htmlspecialchars($_POST[$v])).'<br>';
					};
				};
				$i++;
			};
		};
		/*РАССЫЛКА*/
		if(empty($this->emails)) $this->emails = Settings::model()->getMail();
		$emails = explode($this->emails_parser,$this->emails);
		for($i = 0; $i<count($emails); $i++){
			$emails[$i] = trim($emails[$i]);
			if(preg_match($this->emails_preg_match,$emails[$i])){
				$this->send_mime_mail($this->name_from,$this->email_from,$this->name_to,$emails[$i],$this->data_charset,$this->send_charset,$subject,$message,$this->html,$filepath,$filename);
			};
		};
		for($i=0; $i<count($filepath); $i++){
			if(substr($filepath[$i],0,7)!='http://' && file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$filepath[$i]))
				unlink($_SERVER['DOCUMENT_ROOT'].'/'.$filepath[$i]); //Удаление файла
			// system("del $file_path");
		};
		/**/
		return 0;
	}

	public function actionFilesize()
	{
		$_POST['href'] = str_replace('../','',$_POST['href']);
		$_POST['href'] = explode('?',$_POST['href']);
		$_POST['href'] = explode('#',$_POST['href'][0]);
		$_POST['href'] = $_POST['href'][0];
		if(substr($_POST['href'],0,15)=='/storages/file/' || substr($_POST['href'],0,16)=='/storages/files/' || substr($_POST['href'],0,8)=='/upload/'){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].rawurldecode($_POST['href']))){
				$filesize = filesize($_SERVER['DOCUMENT_ROOT'].rawurldecode($_POST['href']));
				if($filesize>=1024*1000){
					$filesize = round($filesize/1024/1024,2).' мб';
				}else{
					$filesize = round($filesize/1024).' кб';
				}
				echo $filesize;
			}
		}else{
			//$data['title'] = 'Страница не найдена';
			//$this->render('404', $data);
		}
	}
	/**
	 * Отправка письма заявки на квартиру
	 */
	public function actionFeedback()
	{
		$labels = array(
			'Имя'=>'feedbackName',
			'Контактные данные'=>'feedbackContacts',
			'Сообщение'=>'feedbackMessage'
		);
		$subject = 'Сообщение с сайта «Экопромбанка»';
		echo $this->sending($subject,$labels);
	}

	/**
	 * Отправка письма заявки на вклад
	 */
	public function actionVklad()
	{
		$this->emails = Settings::model()->getMail3();

		$labels = array(
			'Имя'=>'userName',
			'Телефон для связи'=>'userContacts',
			'Вклад'=>'vkladName',
//			'Период'=>'vkladPeriod',
//			'Сумма'=>'vkladSumm',
//			'Валюта'=>'vkladCurrency',
		);

		if($_POST['vkladPeriod']){
			$labels['Период']='vkladPeriod';
			$labels['Сумма']='vkladSumm';
			$labels['Валюта']='vkladCurrency';
		}



		$subject = 'Сообщение с сайта «Экопромбанка»';
		echo $this->sending($subject,$labels);
	}
	public function actionDistance()
	{
		$sql_result = array();
		$lon = floatval(Yii::app()->request->getParam('lon'));
		$lat = floatval(Yii::app()->request->getParam('lat'));
		if(!empty($lon) && !empty($lat)){
			$connection = Yii::app()->db;
			$query = "
				SELECT id, longitude as lon, latitude as lat,
				SQRT(POW(longitude-$lon, 2)+POW(latitude-$lat, 2)) as distance
				FROM `rktv_module_ymaps`
				ORDER BY distance ASC
				LIMIT 0,3";
			$command = $connection->createCommand($query);
			$sql_result = $command->queryAll();
		}
		echo json_encode($sql_result);
	}
}