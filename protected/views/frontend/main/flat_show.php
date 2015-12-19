<? include 'inc/meta.php'; ?>

<?
$window_n = false;
$window_e = false;
$window_s = false;
$window_w = false;
$floors = array();
$porches = array();
$rooms = array();
foreach($flats as $flat){
	if(!empty($flat->floor) && !in_array($flat->floor,$floors)) $floors[] = $flat->floor;
	if(!empty($flat->porch) && !in_array($flat->porch,$porches)) $porches[] = $flat->porch;
	if(!empty($flat->rooms) && !in_array($flat->rooms,$rooms)) $rooms[] = $flat->rooms;
	if($flat->window_n) $window_n = true;
	if($flat->window_e) $window_e = true;
	if($flat->window_s) $window_s = true;
	if($flat->window_w) $window_w = true;
}
sort($floors);
sort($porches);
sort($rooms);
$floors_count = count($floors);
$porches_count = count($porches);
$rooms_count = count($rooms);

if(isset($_GET['porch'])){
	unset($_COOKIE['room_all']);
	unset($_COOKIE['room_1']);
	unset($_COOKIE['room_2']);
	unset($_COOKIE['room_3']);
	unset($_COOKIE['floor']);
	$_COOKIE['porch'] = $_GET['porch'];
	unset($_COOKIE['price']);
	unset($_COOKIE['view']);
}
?>
<body>
<div id="container">
	<div class="pad">
		<? include 'inc/header.php'; ?>
		<div class="page cf">
			<section class="flatFilter">
				<div class="filter first">
					<label class="filterLabel">Количество комнат</label>
					<ul class="checkboxGroup">
						<?
						$checked = '';
						if(!isset($_COOKIE['room_all']) || $_COOKIE['room_all']=='' || $_COOKIE['room_all']==1)
							if($_COOKIE['room_1']!=1 && $_COOKIE['room_1']!=2 && $_COOKIE['room_1']!=3) $checked = 'checked';
						?>
						<li><label for="ch-room-all" value="-1" class="<?=$checked?>""><input type="checkbox" id="ch-room-all" data-room="-1" value="-1" <?=$checked?>><span>Все</span></label></li>
						<?
						for($i=0; $i<$rooms_count; $i++){
							$checked = '';
							if($_COOKIE['room_'.$rooms[$i]]==1) $checked = 'checked';
						?>
							<li><label for="ch-room-<?=$rooms[$i]?>" class="<?=$checked?>""><input type="checkbox" id="ch-room-<?=$rooms[$i]?>" data-room="<?=$rooms[$i]?>" value="<?=$rooms[$i]?>" <?=$checked?>><span><?=$rooms[$i]?>-<?=($rooms[$i]<2)?'но':'х'?> комнатная</span></label></li>
						<?
						}
						?>
					</ul>
				</div>
				<div class="filter">
					<label class="filterLabel">Этаж</label>
					<select class="styledSelect" id="floorFilter">
						<option value="0">Все</option>
						<optgroup>
						<? for($i=0; $i<ceil($floors_count/2); $i++): ?>
							<option value="<?=$floors[$i]?>" <?=($_COOKIE['floor']==$floors[$i])?'selected':''?>><?=$floors[$i]?></option>
						<? endfor; ?>
						</optgroup>
						<optgroup>
						<? for($i=$i; $i<$floors_count; $i++): ?>
							<option value="<?=$floors[$i]?>" <?=($_COOKIE['floor']==$floors[$i])?'selected':''?>><?=$floors[$i]?></option>
						<? endfor; ?>
						</optgroup>
					</select>
				</div>
				<div class="filter">
					<label class="filterLabel">Подъезд</label>
					<select class="styledSelect" id="porchFilter">
						<option value="0">Любой</option>
						<? for($i=0; $i<$porches_count; $i++): ?>
							<option value="<?=$porches[$i]?>" <?=($_COOKIE['porch']==$porches[$i])?'selected':''?>><?=$porches[$i]?></option>
						<? endfor; ?>
					</select>
				</div>
				<div class="filter">
					<label class="filterLabel">Цена, млн. руб.</label>
					<select class="styledSelect" id="priceFilter">
						<option value="0">Не важно</option>
						<?
						foreach($prices_combo_list as $key => $value){
							if($_COOKIE['price']==$key && $_COOKIE['price']!='') $selected = ' selected';
								else $selected = '';
							echo '<option value="',$key,'"',$selected,'>',$value['title'],'</option>';
						}
						?>
					</select>
				</div>
				<div class="filter">
					<label class="filterLabel">Вид из окна</label>
					<select class="styledSelect" id="viewFilter">
						<option value="0">Любой</option>
						<? if($window_n): ?><option value="1" <?=($_COOKIE['view']==1)?'selected':''?>>Север</option><? endif; ?>
						<? if($window_e): ?><option value="2" <?=($_COOKIE['view']==2)?'selected':''?>>Восток</option><? endif; ?>
						<? if($window_s): ?><option value="3" <?=($_COOKIE['view']==3)?'selected':''?>>Юг</option><? endif; ?>
						<? if($window_w): ?><option value="4" <?=($_COOKIE['view']==4)?'selected':''?>>Запад</option><? endif; ?>
					</select>
				</div>
			</section>
			<div class="pad contentPad cf">
			   <div class="appartmentDetails">
				   <div class="pageHeader">
					   <div class="breadcrumbs">
						   <a href="<?=$pages->make_url($doc_id_last)?>">Квартиры</a>&nbsp;&mdash; <span class="roomNumberTitle"><?=$item->rooms?>-<?=($item->rooms<2)?'но':'х'?></span> комнатная
					   </div>
					   <h1 class="roomTitle"><?=$item->rooms?>-<?=($item->rooms<2)?'но':'х'?> комнатная квартира №<?=$item->number?></h1>
					   <div class="print">
						   <a href="javascript:print()" class="onPage"><span>Распечатать</span></a>
					   </div>
				   </div>

				   <div class="details cf">
					   <div class="col big">
							<table>
								<tr>
									<td>Номер квартиры</td>
									<td class="val" id="fNum"><?=$item->number?></td>
									<td class="spacer"></td>
									<td>Площадь общая</td>
									<td class="val" id="fSquareCommon"><?=$item->area?>&nbsp;м<sup>2</sup></td>
								</tr>
								<tr>
									<td>Подъезд</td>
									<td class="val" id="fPorch"><?=$item->porch?></td>
									<td class="spacer"></td>
									<td>Площадь жилая</td>
									<td class="val" id="fSquareLiving"><?=$item->living_area?>&nbsp;м<sup>2</sup></td>
								</tr>
								<tr>
									<td>Этаж</td>
									<td class="val" id="fFloor"><?=$item->floor?></td>
									<td class="spacer"></td>
									<td>Цена за&nbsp;м<sup>2</sup></td>
									<td class="val" id="fPriceMeter"><?=Yii::app()->numberFormatter->format('#,##0.',$item->price)?>&nbsp;руб.</td>
								</tr>
								<tr class="last">
									<td>Кол-во комнат</td>
									<td class="val" id="fRooms"><?=$item->rooms?></td>
									<td class="spacer"></td>
									<td>Стоимость</td>
									<td class="val" id="fFullPrice"><?=Yii::app()->numberFormatter->format('#,##0.',$item->price*$item->area)?>&nbsp;руб.</td>
								</tr>
						   </table>
					   </div>
					   <div class="col">
						   <div class="views">
							   <p class="title"><a href="javascript:void(0)" class="viewsGallery onPage"><span>Виды из окон</span></a></p>
							   <? //if($item->window_n): ?>
							   <div class="view cf north" <?=(!$item->window_n)?'style="display:none;"':''?> data-view="1">
								   <div class="img"><a href="javascript:void(0)" data-view="n"><img src="/pics/views/north.jpg"></a></div>
								   <a href="javascript:void(0)" data-view="n" class="onPage"><span>Север</span></a>
							   </div>
							   <? //endif; ?>
							   <? //if($item->window_e): ?>
							   <div class="view cf east" <?=(!$item->window_e)?'style="display:none;"':''?> data-view="2">
								   <div class="img"><a href="javascript:void(0)" data-view="e"><img src="/pics/views/east.jpg"></a></div>
								   <a href="javascript:void(0)" data-view="e" class="onPage"><span>Восток</span></a>
							   </div>
							   <? //endif; ?>
							   <? //if($item->window_s): ?>
							   <div class="view cf south" <?=(!$item->window_s)?'style="display:none;"':''?> data-view="3">
								   <div class="img"><a href="javascript:void(0)" data-view="s"><img src="/pics/views/south.jpg"></a></div>
								   <a href="javascript:void(0)" data-view="s" class="onPage"><span>Юг</span></a>
							   </div>
							   <? //endif; ?>
							   <? //if($item->window_w): ?>
							   <div class="view cf west" <?=(!$item->window_w)?'style="display:none;"':''?> data-view="4">
								   <div class="img"><a href="javascript:void(0)" data-view="w"><img src="/pics/views/west.jpg"></a></div>
								   <a href="javascript:void(0)" data-view="w" class="onPage"><span>Запад</span></a>
							   </div>
							   <? //endif; ?>
						   </div>
					   </div>
					   <div class="btn">
							<?
							$data_view = array();
							if($item->window_n) $data_view[] = '1';
							if($item->window_e) $data_view[] = '2';
							if($item->window_s) $data_view[] = '3';
							if($item->window_w) $data_view[] = '4';

							foreach($prices_combo_list as $key => $value){
								if($item->price*$item->area>=$value['min'] && $item->price*$item->area<=$value['max']){
									$data_price = $key;
									break;
								}
							}
							?>
						   <a href="#" class="currentRequest" data-number="<?=$item->number?>" data-rooms="<?=$item->rooms?>" data-floor="<?=$item->floor?>" data-price="<?=$data_price?>" data-porch="<?=$item->porch?>" data-view="<?=implode('||',$data_view)?>">Отправить заявку на эту квартиру</a>
					   </div>
				   </div>
				   <h3 class="planHeader">Планировка</h3>
				   <p class="planText">Вы&nbsp;можете посмотреть планировки соседних квартир, кликнув на&nbsp;маркер (подсолнух)</p>
				   <div id="plan">
					   <div class="navigator">
						   <div class="navContainer"><a href="javascript:void(0)" class="brd"><i class="u"></i><i class="d"></i><i class="l"></i><i class="r"></i></a></div>
					   </div>
					   <div class="imgContainer">
							<?
							$mpage_id = ModulesInPages::model()->getLink($doc_id_last,'flats');
							$flats_floor = ModuleFlats::model()->getList($mpage_id, NULL, $item->floor);
							$left_top = array(
								array(
									// подъезд 1
									array(1300,140),
									array(1353,327),
									array(1147,369),
									
									// подъезд 2
									array(1166,593),
									array(1354,617),
									array(1354,778),
									array(1371,901),
									
									// подъезд 3
									array(1297,1044),
									array(1411,1155),
									array(1413,1305),
									array(980,1205),
									
									// подъезд 4
									array(800,1307),
									array(680,1411),
									array(593,1155),
									
									// подъезд 5
									array(355,1155),
									array(315,1400),
									array(65,1210)
								),
								array(
									// подъезд 1
									array(1297,125),
									array(1355,177),
									array(1353,335),
									array(1147,369),
									
									// подъезд 2
									array(1166,610),
									array(1362,586),
									array(1413,761),
									array(1371,925),
									
									// подъезд 3
									array(1297,1044),
									array(1411,1180),
									array(1396,1275),
									array(1339,1455),
									array(1151,1435),
									array(1027,1339),
									
									// подъезд 4
									array(818,1339),
									array(677,1445),
									array(571,1339),
									
									// подъезд 5
									array(365,1335),
									array(292,1452),
									array(201,1452),
									array(109,1335)
								),
								array(
									
									// подъезд 1
									array(1297,125),
									array(1355,177),
									array(1353,335),
									array(1147,369),
									
									// подъезд 2
									array(1166,610),
									array(1362,586),
									array(1413,761),
									array(1371,925),
									
									// подъезд 3
									array(1297,1044),
									array(1411,1180),
									array(1396,1275),
									array(1339,1455),
									array(1151,1435),
									array(1027,1339),
									
									// подъезд 4
									array(818,1339),
									array(677,1445),
									array(571,1339),
									
									// подъезд 5
									array(365,1335),
									array(292,1452),
									array(201,1452),
									array(109,1335)
								)
							);
							if($item->floor==1) $left_top = $left_top[0];
								elseif($item->floor>=2 && $item->floor<=7) $left_top = $left_top[1];
								else $left_top = $left_top[2];
							$i = 0;
							foreach($flats_floor as $flat){
								if($flat->floor==$item->floor){
									$active = '';
									if($flat->id==$item->id) $active = 'active';
									if(isset($left_top[$i]) && count($left_top[$i])==2){
										$left = $left_top[$i][0].'px';
										$top = $left_top[$i][1].'px';
									}else{
										$left = '0';
										$top = '0';
									}
									switch($flat->bought){
										case 1:
											$class = 'reserve';
											break;
										case 2:
											$class = 'bron';
											break;
										case 3:
											$class = 'sold';
											break;
										default:
											$class = '';
											break;
									}
									
									$data_view = array();
									if($flat->window_n) $data_view[] = '1';
									if($flat->window_e) $data_view[] = '2';
									if($flat->window_s) $data_view[] = '3';
									if($flat->window_w) $data_view[] = '4';
									
									echo '<a href="javascript:void(0)" class="marker ',$active,' ',$class,'"';
									echo ' data-href="',$pages->make_url($doc_id_last),'show_',$flat->id,'/"';
									echo ' data-number="',$flat->number,'"';
									echo ' data-porch="',$flat->porch,'"';
									echo ' data-floor="',$flat->floor,'"';
									echo ' data-rooms="',$flat->rooms,'"';
									echo ' data-area="',$flat->area,'"';
									echo ' data-living_area="',$flat->living_area,'"';
									echo ' data-price_m2="',Yii::app()->numberFormatter->format('#,##0.',$flat->price),'&nbsp;руб."';
									echo ' data-price="',Yii::app()->numberFormatter->format('#,##0.',$flat->price*$flat->area),'&nbsp;руб."';
									echo ' data-view="',implode('||',$data_view),'"';
									echo ' style="left:',$left,'; top:',$top,';"></a>';
									$i++;
								}
							}
							if($item->floor==1) $floor_img = '/pics/floor/1.jpg';
								elseif($item->floor>=2 && $item->floor<=7) $floor_img = '/pics/floor/2.jpg';
								else $floor_img = '/pics/floor/3.jpg';
							?>
						   
						   <img src="<?=$floor_img?>" width="1500" height="1536">
					   </div>
				   </div>

                   <div class="legend">
                       <p><img src="/pics/i/marker_legend.png" alt="Свободно"><span> —  квартиры находящиеся в открытой продаже.</span></p>
                       <p><img src="/pics/i/sold.png" alt="Продано"><span> — заключенные договора и оплата квартиры в соответствии с договором.</span></p>
                       <p><img src="/pics/i/bron.png" alt="Бронь"><span> — забронированные квартиры и идет процесс заключения договора.</span></p>
                       <p><img src="/pics/i/reserve.png" alt="Резерв"><span> —  квартиры временно не выставленные в продажу.</span></p>
                   </div>

				   <p class="back"><a href="<?=$pages->make_url($doc_id_last)?>">К списку квартир</a></p>
			   </div>
			</div>
		</div>
	    <? include 'inc/commonblock.php'; ?>
		<? include 'inc/footer.php'; ?>
	</div>
</div>