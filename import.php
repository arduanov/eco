<?

$host = 'localhost';
$user = 'root';
$pwd = ''; 
$db=mysql_connect($host,$user,$pwd);
mysql_select_db("eco_old",$db);
mysql_set_charset('cp-1251',$db); 

$sql = "SELECT * FROM content WHERE class = 'CCList' ORDER BY id";
$sqlres = mysql_query($sql) or die("Query failed");
$data = array();
echo '
<style>
table.main1 > td {border: 1px solid #333; padding:5px}
table.main1 > tr {margin:0; padding:0;}
</style>
<table class="main1">
	<tr>
		<td>ID</td>
		<td>Имя</td>
		<td>Текст</td>
		<td>Справа</td>
	</tr>
';
$i = 0;
$j = 0;
while($row = mysql_fetch_array($sqlres)){
	$i++;
	$settings = unserialize($row['settings']);
	
	$sql2 = "SELECT * FROM ".$settings['table']." ORDER BY id";
	$sqlres2 = mysql_query($sql2) or die("Query failed");
	while($row2 = mysql_fetch_array($sqlres2)){
		$j++;
		$data[$row['id']] = array();
		$data[$row['id']]['name'] = iconv('windows-1251','utf-8',$row['name']);
		$data[$row['id']]['text'] = iconv('windows-1251','utf-8',$row2['text']);
		$data[$row['id']]['righttext'] = iconv('windows-1251','utf-8',$row2['righttext']);
		echo '<tr>';
		echo '<td><h1>',$row['id'],'</h1></td>';
		echo '<td><textarea style="width:200px; height:300px;">',$data[$row['id']]['name'],'</textarea></td>';
		// echo '<td></td>';
		// echo '<td></td>';
		echo '<td><textarea style="width:600px; height:300px;">',$data[$row['id']]['text'],'</textarea></td>';
		echo '<td><textarea style="width:300px; height:300px;">',$data[$row['id']]['righttext'],'</textarea></td>';
		echo '</tr>';
	}
}
echo '</table>';
/*
$pages = array(
	@3 => 63,
	@4 => 0, // * Акционеры
	@5 => 29,
	@6 => 27,
	@7 => 31,
	@8 => 25,
	@22 => 52+53,
	23 => 16,
	24 => 54+55,
	25 => 58,
	26 => 18,
	27 => 73, // 59,63! Кредитование (60, 48)+
	29 => 8, // 41!?! Банковские карты-
	30 => 0, // * Инкассация и перевозка грузов-
	31 => 15,
	34 => 33, // 22! Расчетно-кассовое обслуживание в рублях-
	35 => 34, // 24! Расчетно-кассовое обслуживание в иностранной валюте-
	36 => 38, // ! Информация для вкладчиков-
	37 => 18,
	39 => 48, // ! Потребительское кредитование-
	40 => 0, // * Ипотечное кредитование-
	41 => 42, // 29!?! Банковские карты-
	42 => 39, // просто так * Тарифы+
	43 => 46,
	44 => 43, // * SMS-Сервис++++++++++++
	45 => 26, // * Банкоматы и терминалы+
	47 => 0, // * Реквизиты для перечисления на карту-
	48 => 49, // !?! Переводы «Western Union»-
	51 => 4,
	52 => 2, // ! Услуги юридическим лицам
	53 => 3, // ! Услуги физическим лицам
	54 => 0, // * Скидки по картам
	56 => 0, // * Корпоративное управление
	57 => 60,
	58 => 20,
	59 => 9, // 27,63! Кредитование (60, 48)-
	61 => 21,
	62 => 22, // ! Торговый эквайринг
	63 => 60, // ! Кредитование малого и среднего бизнеса+
	64 => 61,
	65 => 62,
	66 => 20, // 58! Условия инвестирования
	67 => 0, // * Кредит на пополнение оборотных средств
	68 => 0, // * Бланковый кредит
	69 => 0, // * Кредит «Инвестиционный» под залог коммерческой недвижимости
	70 => 60, // 57! Кредит на развитие малого бизнеса
	71 => 0, // * «Корпоративный кредит»
	72 => 0, // * Кредит «Для руководителей предприятий корпоративных клиентов банка»
	73 => 0, // * Кредит «Стандартный»
	74 => 0, // * Кредит «Профессиональный»
	75 => 0, // * Кредит «Свободный»
	76 => 0, // * Кредит «Универсальный»
	77 => 0, // * Кредит «Корпоративный»
	78 => 0, // * Кредит «Строительный»
	79 => 0, // * Кредит «Новая квартира»
	80 => 0, // * Перечень документов
	82 => 0, // * Услуги для банков корреспондентов
	84 => 51, // ?!? Переводы «Migom»
	85 => 50, // ! Денежные переводы
	86 => 0, // * Овердрафт
	87 => 0, // * Регламентирующие документы
	88 => 0, // * Магазины
	89 => 70, // ! Документы Эмиссии
	90 => 0, // * Проекты
	92 => 0, // * Детский развлекательный центр «Солнечный остров»
	93 => 0, // * ООО «УЭС-Архив»
	94 => 0, // * Плата за услуги связи
	95 => 0, // * Кредит под поручительство ОАО «ПЦРП»
	97 => 45, // ! Формы заявлений
	98 => 0, // * Вклады для VIP-клиентов
	99 => 37,
	100 => 12,
	101 => 0, // дублирование 100
	102 => 0, // * Страхование
	104 => 35,
	105 => 15, // страница не типа лист ! Дистанционное банковское обслуживание
	107 => 57, // ! Банк-Клиент: подключение услуги
	108 => 0, // * Преимущества
	109 => 0, // * Меры безопасности при работе
	110 => 0, // * Банк сегодня
	111 => 0, // * Акция «Время открытий»
	112 => 0, // * Платежи населения
	113 => 71, // ! Предоставление копий документов
	114 => 0, // * Вклад «День рождения»
	115 => 0, // * Программа открытия счетов «Как Вам будет удобно!»
	117 => 72, // ! Информация о регистраторе
	118 => 0, // * Акция «Вкусный новый год»
	120 => 0, // * Памятка о мерах безопасного использования банковских карт
	121 => 0, // * Сведения об эмиссии и эквайринге платежных карт
	122 => 0, // * Итоги голосования
	123 => 0, // * Информация о лицах, оказывающих существенное влияние на решения, принимаемые органами управления
	126 => 58, // ! Депозит для саморегулируемых организаций
	127 => 58, // ! Классический депозит
	128 => 58, // ! Отраслевые депозиты
	129 => 58, // ! Депозит для учреждений образования и науки
	130 => 58, // ! Накопительный депозит
	138 => 0, // * Овердрафт до зарплаты «СпецРезерв»
	139 => 41, // 143,150! Кредитные карты
	140 => 31, // ! Открытие и ведение корреспондентских счетов
	141 => 0, // * Инкассация
	142 => 0, // * Лайт-офисы ЗДЕСЬ и СЕЙЧАС
	143 => 41, // 139,150! Кредитные карты
	144 => 0, // * Вопрос-ответ
	145 => 47,
	146 => 0, // тупо ссылки* Кредитная карта 112
	147 => 0, // * Онлайн заявки
	148 => 0, // пусто* Порядочный кредит +100/500
	149 => 0, // * Практически Магическая карта
	150 => 41, // 139,143! Кредитная карта 112
	151 => 0 // * Практически магическая карта
);*/
// echo '<hr>';
// echo $j,'<br>',$j;

mysql_close();

/*
$filename = 'analytic.xml';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$xmldoc = new SimpleXMLElement($contents);
$file = $xmldoc->xpath("/FilesData/File");

$host = 'localhost';
$user = 'root';
$pwd = ''; 
$db=mysql_connect($host,$user,$pwd);
mysql_select_db("pfc",$db);
mysql_set_charset('utf8',$db); 

foreach($file as $f){
	$Title = $f->Title;
	$Date = $f->attributes()->Date;
	$Date = explode(' ',$Date);
	$Date = $Date[0];
	$FileName =  $f->attributes()->FileName;
	$FolderName =  $f->attributes()->FolderName;
	if($FolderName=='daily-review'){
		
		// КОПИРОВАНИЕ ФАЙЛОВ
		$sql = "SELECT id FROM rktv_files WHERE file_name = '$FileName'";
		$sqlres = mysql_query($sql) or die("Query failed");
		$file_id = 0;
		$i=0;
		while ($row=mysql_fetch_array($sqlres)){
			$i++;
			$file_id = $row['id'];
		};
		$index = $i-1;
		$filename = 'pfc.ru/docs/'.$FolderName.'/'.$FileName;
		$newfile = 'files/'.$FileName;
		do{
			$index++;
			$newfile_index = explode('.',$newfile);
			if($index>0) $newfile_index[count($newfile_index)-2] .= '_'.$index;
			$newfile_index = implode('.',$newfile_index);
		}while(file_exists($newfile_index));
		$index_log = '';
		if($index>0) $index_log = ' ИНДЕКС: '.$index;
		if(!file_exists($newfile_index)){
			if(copy($filename,$newfile_index)){
				echo 'ok — '.$filename.$index_log.'<br>';
			}else{
				echo 'error ———————————————————————— '.$filename.$index_log.'<br>';
			};
		}else{
			echo 'error ———————————————————————— '.$filename.$index_log.'<br>';
		};
		$FileName = explode('/',$newfile_index);
		$FileName = $FileName[count($FileName)-1];
		// конец: КОПИРОВАНИЕ ФАЙЛОВ
		
		$sql = "SELECT id FROM rktv_files WHERE file_name = '$FileName'";
		$sqlres = mysql_query($sql) or die("Query failed");
		$file_id = 0;
		$i=0;
		while ($row=mysql_fetch_array($sqlres)){
			$i++;
			$file_id = $row['id'];
		};
		if($i==0){
			$sql = "INSERT INTO rktv_files (file_name) VALUES ('$FileName')";
			$sqlres = mysql_query($sql) or die("Query failed");
			
			$sql = "SELECT id FROM rktv_files WHERE file_name = '$FileName'";
			$sqlres = mysql_query($sql) or die("Query failed");
			$file_id = 0;
			while ($row=mysql_fetch_array($sqlres)){
				$i++;
				$file_id = $row['id'];
			};
			if($i==1){
			
				$Title = trim(str_replace('"','\"',$Title));
				$sql = "INSERT INTO rktv_module_files_data (category_id,date,name,file_id) VALUES (24,'$Date',\"$Title\",'$file_id')";
				$sqlres = mysql_query($sql) or die("Query failed");
				
			}else{
			
				echo 'ERROR #2 - '.$file_id.'<br>';
				
			};
		}else{
			echo 'ERROR! - '.$file_id.'<br>';
		};
	};
	
};

mysql_close();*/

/* 
$filename = 'news.xml';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$xmldoc = new SimpleXMLElement($contents);
$news = $xmldoc->xpath("/Project/NewsData/News");

$host = 'localhost';
$user = 'root';
$pwd = ''; 
$db=mysql_connect($host,$user,$pwd);
mysql_select_db("pfc",$db);
mysql_set_charset('utf8',$db); 

$i = 0;
foreach($news as $n){
	$Title = $n->Title;
	$Date = $n->attributes()->Date;
	$Date = explode(' ',$Date);
	$Date = $Date[0];
	$Text =  $n->Text;
	$ProjectCategoryId =  $n->attributes()->ProjectCategoryId;
	if($ProjectCategoryId=='13'){
		$i++;
		$Title = trim(str_replace('"','\"',$Title));
		$Text = trim(str_replace('"','\"',$Text));
		$sql = "INSERT INTO rktv_module_news_data (id,name,date,text,active) VALUES ($i,\"$Title\",'$Date',\"$Text\",'1')";
		$sqlres = mysql_query($sql) or die("Query failed");
		$sql = "INSERT INTO rktv_module_news (mpage_id,news_data_id) VALUES (12,$i)";
		$sqlres = mysql_query($sql) or die("Query failed");
		echo '0<br>';
	};
};
mysql_close();
 */

/*
$filename = 'news.xml';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$xmldoc = new SimpleXMLElement($contents);
$file = $xmldoc->xpath("/Project/NewsData/News");

$host = 'localhost';
$user = 'root';
$pwd = ''; 
$db=mysql_connect($host,$user,$pwd);
mysql_select_db("pfc",$db);
mysql_set_charset('utf8',$db); 

foreach($file as $f){
	$Title = $f->Title;
	$Date = $f->attributes()->Date;
	$Date = explode(' ',$Date);
	$Date = $Date[0];
	$FileName = '';
	if(isset($f->attributes()->FileName)) $FileName =  $f->attributes()->FileName;
	
	$ProjectCategoryId =  $f->attributes()->ProjectCategoryId;
	if($ProjectCategoryId=='14' && $FileName != ''){
		
		// КОПИРОВАНИЕ ФАЙЛОВ
		$sql = "SELECT id FROM rktv_files WHERE file_name = '$FileName'";
		$sqlres = mysql_query($sql) or die("Query failed");
		$file_id = 0;
		$i=0;
		while ($row=mysql_fetch_array($sqlres)){
			$i++;
			$file_id = $row['id'];
		};
		$index = $i-1;
		$filename = 'pfc.ru/docs/news/'.$FileName;
		$newfile = 'files/'.$FileName;
		do{
			$index++;
			$newfile_index = explode('.',$newfile);
			if($index>0) $newfile_index[count($newfile_index)-2] .= '_'.$index;
			$newfile_index = implode('.',$newfile_index);
		}while(file_exists($newfile_index));
		$index_log = '';
		if($index>0) $index_log = ' ИНДЕКС: '.$index;
		if(!file_exists($newfile_index)){
			if(copy($filename,$newfile_index)){
				echo 'ok — '.$filename.$index_log.'<br>';
			}else{
				echo 'error ———————————————————————— '.$filename.$index_log.'<br>';
			};
		}else{
			echo 'error ———————————————————————— '.$filename.$index_log.'<br>';
		};
		$FileName = explode('/',$newfile_index);
		$FileName = $FileName[count($FileName)-1];
		// конец: КОПИРОВАНИЕ ФАЙЛОВ
		
		$sql = "SELECT id FROM rktv_files WHERE file_name = '$FileName'";
		$sqlres = mysql_query($sql) or die("Query failed");
		$file_id = 0;
		$i=0;
		while ($row=mysql_fetch_array($sqlres)){
			$i++;
			$file_id = $row['id'];
		};
		if($i==0){
			$sql = "INSERT INTO rktv_files (file_name) VALUES ('$FileName')";
			$sqlres = mysql_query($sql) or die("Query failed");
			
			$sql = "SELECT id FROM rktv_files WHERE file_name = '$FileName'";
			$sqlres = mysql_query($sql) or die("Query failed");
			$file_id = 0;
			while ($row=mysql_fetch_array($sqlres)){
				$i++;
				$file_id = $row['id'];
			};
			if($i==1){
			
				$Title = trim(str_replace('"','\"',$Title));
				$sql = "INSERT INTO rktv_module_files_data (category_id,date,name,file_id) VALUES (18,'$Date',\"$Title\",'$file_id')";
				$sqlres = mysql_query($sql) or die("Query failed");
				
			}else{
			
				echo 'ERROR #2 - '.$file_id.'<br>';
				
			};
		}else{
			echo 'ERROR! - '.$file_id.'<br>';
		};
	};
	
};

mysql_close();
*/

/* $host = 'localhost';
$user = 'root';
$pwd = ''; 
$db=mysql_connect($host,$user,$pwd);
mysql_select_db("pfc",$db);
mysql_set_charset('utf8',$db); */
/* $sql = "SELECT id,file_name FROM rktv_files";
$sqlres = mysql_query($sql) or die("Query failed");
while ($row=mysql_fetch_array($sqlres)){
	if(!file_exists('../upload/'.$row['file_name'])) echo $row['id'].',';
}; */
/* $sql = "SELECT * FROM  `rktv_module_files_data` WHERE  `file_id` IN ( 2410, 3519, 3741, 3722, 3732, 3612, 3723, 2522, 3730, 3724, 3727, 3677, 3449, 3725, 3733, 3736, 3739, 3734, 3620, 3621 )";
$sqlres = mysql_query($sql) or die("Query failed");
while ($row=mysql_fetch_array($sqlres)){
	echo $row['file_id'].',';
}; */
// mysql_close();



// echo '1';
?>
