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
                <div role="main" class="mainBlock">
					<div class="pageHeader">
						<h1><?=$title?></h1>
						<div class="print">
							<a href="javascript:print()" class="onPage"><span>Распечатать</span></a>
						</div>
					</div>
                    <p class="warning" id="emptyFilter">
                        К&nbsp;сожалению, не&nbsp;осталось квартир с&nbsp;заданными параметрами. Измените параметры поиска и&nbsp;посмотрите другие квартиры.
                    </p>
					<table class="appartmentList">
						<thead>
							<tr>
								<th>№ кв.</th>
								<th>Этаж</th>
								<th>Кол-во комнат</th>
								<th>Площадь общая</th>
								<th>Цена за м<sup>2</sup>, руб.</th>
								<th>Стоимость, руб.</th>
                                <th></th>
								<th class="button"></th>
							</tr>
						</thead>
						<tbody>
							<? foreach($flats as $flat): ?>
								<?
								$data_view = array();
								if($flat->window_n) $data_view[] = '1';
								if($flat->window_e) $data_view[] = '2';
								if($flat->window_s) $data_view[] = '3';
								if($flat->window_w) $data_view[] = '4';
								
								foreach($prices_combo_list as $key => $value){
									if($flat->price*$flat->area>=$value['min'] && $flat->price*$flat->area<=$value['max']){
										$data_price = $key;
										break;
									}
								}
								?>
							<tr data-href="<?=$pages->make_url($doc_id_last)?>show_<?=$flat->id?>/" data-rooms="<?=$flat->rooms?>" data-floor="<?=$flat->floor?>" data-price="<?=$data_price?>" data-porch="<?=$flat->porch?>" data-view="<?=implode('||',$data_view)?>">
								<td><?=$flat->number?></td>
								<td><?=$flat->floor?></td>
								<td><?=$flat->rooms?></td>
								<td><?=$flat->area?> м<sup>2</sup></td>
								<td><?=Yii::app()->numberFormatter->format('#,##0.',$flat->price)?></td>
								<td><?=Yii::app()->numberFormatter->format('#,##0.',$flat->price*$flat->area)?></td>
                                <td><a href="<?=$pages->make_url($doc_id_last)?>show_<?=$flat->id?>/">Планировка</a></td>
								<td class="button">
									<? if(in_array($flat->bought,array(0,1,2))): ?>
                                    <a href="<?=$pages->make_url($doc_id_last)?>show_<?=$flat->id?>/" class="roomLink requestButton" data-number="<?=$flat->number?>" data-rooms="<?=$flat->rooms?>" data-floor="<?=$flat->floor?>" data-price="<?=$data_price?>" data-porch="<?=$flat->porch?>" data-view="<?=implode('||',$data_view)?>">Отправить заявку</a>
									<? endif; ?>
								</td>
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				</div>
				<aside class="pageAside">
					<a class="hotlink cf buildingprocess construction" href="javascript:void(0)">
						<span class="img"></span>
						<span class="txt">
						   <span class="linkText">Ход строительства дома</span>
						</span>
					</a>
					<a class="hotlink cf viewswindows" href="javascript:void(0)">
						<span class="img"></span>
						<span class="txt">
							<span class="linkText">Виды из&nbsp;окон со&nbsp;всех сторон</span>
						</span>
					</a>
				</aside>
			</div>
		</div>
	    <? include 'inc/commonblock.php'; ?>
		<? include 'inc/footer.php'; ?>
	</div>
</div>