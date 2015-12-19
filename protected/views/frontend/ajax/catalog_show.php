<?
$size_array = array(
	1 => '12-18 месяцев','18-24 месяца','2-3 года','3-4 года'
);
?>
			<? foreach($item as $d_id=>$d): ?>
				<?
				$item_id = $d_id;
				if(!isset($size_id) || !in_array($size_id,$sizes) || !isset($d->sizes[$size_id])){
					foreach($d->sizes as $s_id=>$s){
						$s_id--;
						if(count($cookie_ids)){
							if(in_array($d_id,$cookie_ids) && array_key_exists($d_id.'_'.$s_id,$cookie_ids) || !in_array($d_id,$cookie_ids)) break;
						}else{
							break;
						};
					};
				}else{
					$s = $d->sizes[$size_id];
					$s_id = $size_id-1;
				};
				// !!! $s_id на 1 меньше, т.к. во frontend'е нумерация начинается с 1, а в БД с 2 !!!
				?>
				<div class="solutionBody cf">
					<div class="img">
						<img src="<?=$d->front_img[2]?>" alt="<?=$d->longtitle?>">
						<!--span class="action"></span-->
					</div>
					<div class="content">
						<h2><?=$d->longtitle?></h2>
						<div class="row sizesAndPrice cf">
							<span class="label">Выберите размер:</span>
							<div class="value cf">
								<? if(count($d->sizes)): ?>
								<ul>
									<? $size_i = 0; ?>
									<? foreach($d->sizes as $s_id=>$s): ?>
										<? $size_i++; ?>
									<li><label><input type="radio" class="sizeSelect" name="size1" value="<?=$s_id-1?>" data-price="<?=$s->price?>" <?=($size_id==($s_id-1) || $size_i==1)?'checked=""':''?>> <?=$size_array[$s_id-1]?></label></li>
									<? endforeach; ?>
								</ul>
								<? endif; ?>
								<div class="priceBig"><span><?=Yii::app()->numberFormatter->format('#,##0.',$s->price)?></span> руб.</div>
							</div>
						</div>
						<div class="row description cf">
							<span class="label">Описание:</span>
							<div class="value"><?=$d->description?></div>
						</div>
						<div class="row socialsRow cf">
							<span class="label">Поделитесь:</span>
							<div class="value">
								<p class="icons">
									<a href="http://<?=$_SERVER['SERVER_NAME']?><?=$pages->make_url($doc_id_last)?>show_<?=$d_id?>/" class="socialIcon vk l-vk"></a>
									<a href="http://<?=$_SERVER['SERVER_NAME']?><?=$pages->make_url($doc_id_last)?>show_<?=$d_id?>/" class="socialIcon fb l-fb"></a>
									<a href="http://<?=$_SERVER['SERVER_NAME']?><?=$pages->make_url($doc_id_last)?>show_<?=$d_id?>/" class="socialIcon tw l-tw"></a>
									<span class="socialIcon od">
										<a target="_blank" class="mrc__plugin_uber_like_button" rel="nofollow" href="http://connect.mail.ru/share" data-mrc-config="{'nc' : '1', 'cm' : '1', 'ck' : '2', 'sz' : '20', 'st' : '2', 'tp' : 'ok', width:20}"></a>
									</span>
									<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>
								</p>
							</div>
						</div>
						<div class="row buttons cf">
							<a href="javascript:void(0)" class="btnMedium blue" data-id="<?=$d_id?>"><span class="r"></span><span class="l" style="width:140px;">Сделать заказ сразу</span></a>
							<a href="javascript:void(0)" class="btnMedium" data-id="<?=$d_id?>"><span class="r"></span><span class="l" style="width:140px;">Положить в корзину</span></a>
						</div>
					</div>
				</div>
			<? endforeach; ?>