<? include 'inc/meta.php'; ?>

<body>
<!--[if lt IE 7]>
<![endif]-->
<div class="page-bg">
    <? include 'inc/leafs.php'?>
	<div class="page-container">
		<?
			include 'inc/header.php';
		?>
		<div class="page-layout clearfix">
			<div class="breadcrumbs">
				<?=$breadcrumbs?>
			</div>
			
			<h1 class="headline"><?=$title?> <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
			<? //print_r($list); ?>
			<div class="page-content">
				<div class="pad-content">
					<nav class="section-navigator js-navigator">
						<ul>
							<li class="active"><a href="#cols" class="onPage">Лайт-офисы ЗДЕСЬ и СЕЙЧАС</a></li>
							<li><a href="#atms" class="onPage">Банкоматы и терминалы</a></li>
							
						</ul>
					</nav>
					<div class="atms js-page">
						<nav class="section-navigator js-navigator sub-navigation">
							<ul>
								<li class="active"><a href="#atms/list" class="onPage">Списком</a></li>
								<li><a href="#atms/map" class="onPage">Посмотреть на карте</a></li>
							</ul>
						</nav>
						<div class="atms-list js-sub-page" style="display:block;">
							<div class="remark remark-error empty-filter">
								<p>К сожалению, ни один банкомат или терминал не подходит под выбранные настройки фильтра, попробуйте выбрать другие или <a
										class="onPage js-filter-reset" href="javascript:void(0)">сбросить настройки фильтра</a></p>
							</div>
							<div class="filter-list contacts-list">
								<h2>Банкоматы и&nbsp;терминалы в&nbsp;Перми <a href="javascript:void(0)" class="atmFilterLink" style="white-space:nowrap;"><span>Выбрать банкомат или терминал</span></a></h2>
								<table class="atms-table">
                                    <thead>
									<tr data-id="-1" class="js-FilterHead">
										<th style="width: 180px;">Наименование</th>
										<th style="width: 90px;">Время работы</th>
										<th style="width:160px;">Адрес</th>
										<th>Услуги</th>
									</tr>
                                    </thead>
                                    <tbody>
									<? foreach($list[1]->points as $point): ?>
										<?
										$options = array();
										foreach($point->params as $param){
											if($param->value=='1') $options[] = $param->param_id;
										}
										if(in_array(2,$options) || in_array(3,$options) || in_array(4,$options)) $options[] = '2_3_4';
										if(in_array(5,$options) || in_array(6,$options) || in_array(7,$options)) $options[] = '5_6_7';
										if(in_array(8,$options) || in_array(9,$options) || in_array(10,$options)) $options[] = '8_9_10';
										if(in_array(11,$options) || in_array(12,$options) || in_array(13,$options)) $options[] = '11_12_13';
										if(count($options)) $options = '|'.implode('|',$options).'|';
										
										$type = 'atm';
										$icon = '/pics/i/maps/atm.png';
										if($point->params[18]->value=='1'){
											$type = '24';
											$icon = '/pics/i/maps/24.png';
										}
										if($point->params[21]->value=='1'){
											$type = 'petro';
											$icon = '/pics/i/maps/petro.png';
										}
										if($point->params[22]->value=='1'){
											$type = 'magic';
											$icon = '/pics/i/maps/magic.png';
										}
										if($point->params[23]->value=='1'){
											$type = 'mainoffice';
											$icon = '/pics/i/maps/mainoffice.png';
										}
										?>
										<tr data-id="<?=$point->id?>" data-options="<?=$options?>" data-lat="<?=$point->latitude?>" data-lon="<?=$point->longitude?>" data-icon="<?=$icon?>" data-getcashcurrency="<?=$options?>" data-rechargecard="<?=$options?>" data-payservices="<?=$options?>" data-payservicecash="<?=$options?>" data-title="<strong><?=str_replace('"','\"',$point->title)?></strong><br><?=$point->params[24]->value?>" data-type="<?=$type?>">
											<td>
												<strong><?=$point->title?></strong>
												<? if($point->params[21]->value=='1'): ?>
													<img class="partner" src="/pics/i/partner.png" alt="Петрокомерц банк">
												<? endif; ?>
												<? if($point->params[22]->value=='1'): ?>
													<img class="partner" src="/pics/i/partner_magia.png" alt="Практическая магия">
												<? endif; ?>
											</td>
											<td>
												<? if($point->params[18]->value=='1'): ?>
													<img src="/pics/i/24.png" alt="24 часа"> часа
												<? else: ?>
													<?=$point->params[1]->value?>
												<? endif; ?>
											</td>
											<td><a href="#atms/map/<?=$point->id?>" class="onPage"><?=$point->params[24]->value?></a></td>
											<td>
												<span style="font-size: 12px; line-height: 18px;">
													<?
													/*if($point->id!=10){*/
														foreach($point->params as $param){
															if($param->value=='1') echo $param->title,'; ';
														}
													/*}else{
														echo 'Все услуги';
													}*/
													?>
												</span>
											</td>
										</tr>
									<? endforeach; ?>
                                    </tbody>
								</table>

								<h2 id="PermReg">Банкоматы и&nbsp;терминалы в&nbsp;Пермском крае</h2>
								<table id="regionTable">
									<tr data-id="-1" class="js-FilterHead">
                                        <th style="width: 180px;">Наименование</th>
                                        <th style="width: 90px;">Время работы</th>
                                        <th style="width:160px;">Адрес</th>
                                        <th>Услуги</th>
									</tr>
									<? foreach($list[2]->points as $point): ?>
										<?
										$options = array();
										foreach($point->params as $param){
											if($param->value=='1') $options[] = $param->param_id;
										}
										if(in_array(2,$options) || in_array(3,$options) || in_array(4,$options)) $options[] = '2_3_4';
										if(in_array(5,$options) || in_array(6,$options) || in_array(7,$options)) $options[] = '5_6_7';
										if(in_array(8,$options) || in_array(9,$options) || in_array(10,$options)) $options[] = '8_9_10';
										if(in_array(11,$options) || in_array(12,$options) || in_array(13,$options)) $options[] = '11_12_13';
										if(count($options)) $options = '|'.implode('|',$options).'|';
										
										$type = 'atm';
										$icon = '/pics/i/maps/atm.png';
										if($point->params[18]->value=='1'){
											$type = '24';
											$icon = '/pics/i/maps/24.png';
										}
										if($point->params[21]->value=='1'){
											$type = 'petro';
											$icon = '/pics/i/maps/petro.png';
										}
										if($point->params[22]->value=='1'){
											$type = 'magic';
											$icon = '/pics/i/maps/magic.png';
										}
										if($point->params[23]->value=='1'){
											$type = 'mainoffice';
											$icon = '/pics/i/maps/mainoffice.png';
										}
										?>
										<tr data-id="<?=$point->id?>" data-options="<?=$options?>" data-lat="<?=$point->latitude?>" data-lon="<?=$point->longitude?>" data-icon="<?=$icon?>" data-getcashcurrency="<?=$options?>" data-rechargecard="<?=$options?>" data-payservices="<?=$options?>" data-payservicecash="<?=$options?>" data-title="<?=str_replace('"','\"',$point->title)?>" data-type="<?=$type?>">
											<td>
												<strong><?=$point->title?></strong>
												<? if($point->params[21]->value=='1'): ?>
													<img class="partner" src="/pics/i/partner.png" alt="Петрокомерц банк">
												<? endif; ?>
												<? if($point->params[22]->value=='1'): ?>
													<img class="partner" src="/pics/i/partner_magia.png" alt="Практическая магия">
												<? endif; ?>
											</td>
											<td>
												<? if($point->params[18]->value=='1'): ?>
													<img src="/pics/i/24.png" alt="24 часа"> часа
												<? else: ?>
													<?=$point->params[1]->value?>
												<? endif; ?>
											</td>
											<td><?=$point->params[24]->value?></td>
											<td>
												<span style="font-size: 12px; line-height: 18px;">
													<?
													/*if($point->id!=10){*/
														foreach($point->params as $param){
															if($param->value=='1') echo $param->title,'; ';
														}
													/*}else{
														echo 'Все услуги';
													}*/
													?>
												</span>
											</td>
										</tr>
									<? endforeach; ?>
								</table>
							</div>
						</div>
						<div class="atms-map  js-sub-page">
							<div class="legend clearfix">
								<table>
									<tr>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="mainoffice">
												<img src="/pics/i/maps/mainoffice.png" alt="Центральный офис Экопромбанка"> <span>Главный офис</span>
											</a>
										</td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="atm">
												<img src="/pics/i/maps/atm.png" alt="Банкоматы Экопромбанка"> <span>Банкоматы и&nbsp;терминалы Экопромбанка</span>
											</a>
										</td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="24">
												<img src="/pics/i/maps/24.png" alt="Круглосуточные банкоматы"> <span>Круглосуточные банкоматы и&nbsp;терминалы</span>
											</a>
										</td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="petro">
												<img src="/pics/i/maps/petro.png" alt="Банкоматы партнера Петрокомерц"> <span>Банкоматы и&nbsp;терминалы партнеров</span>
											</a>
										</td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="magic">
												<img src="/pics/i/maps/magic.png" alt="Банкоматы партнера Петрокомерц"> <span>Пункты пополнения счета п/с Практическая магия</span>
											</a>
										</td>
									</tr>
								</table>
							</div>
							<div id="atmMap" class="map"></div>
						</div>
					</div>
					<div class="cols  js-page" style="display:block;">
						<nav class="section-navigator js-navigator sub-navigation">
							<ul>
								<li class="active"><a href="#cols/list" class="onPage">Списком</a></li>
								<li><a href="#cols/map" class="onPage">Посмотреть на карте</a></li>
							</ul>
						</nav>
						<div class="cols-list  js-sub-page">
							<p>ОАО АКБ &laquo;ЭКОПРОМБАНК&raquo;<br> Офис Банка: Екатерининская, 120</p>
                            <p>К&nbsp;Вашим услугам, система лайт-офисов Банка ЗДЕСЬ и&nbsp;СЕЙЧАС, расположенных в&nbsp;крупнейших торговых центрах города Перми. Ее&nbsp;задача&nbsp;&mdash; максимально облегчить Ваше взаимодействие с&nbsp;Банком, именно в&nbsp;тот момент, когда для Вас это особенно актуально. Теперь Вы&nbsp;сможете пользоваться услугами Банка (например, оформить удобную кредитную карту для срочных или незапланированных приобретений), не&nbsp;выходя из&nbsp;торгового центра.</p>
                            <p>Мы&nbsp;делаем все, чтобы быть Вам полезными ЗДЕСЬ и&nbsp;СЕЙЧАС.</p>
                            <p><strong>Внимание!</strong> Сеть лайт-офисов постоянно расширяется. Следите за&nbsp;актуальной информацией на&nbsp;сайте.</p>
							<table class="cols-table">
								<tr class="js-FilterHead">
									<th>Наименование</th>
									<th style="padding-right:5px;  width: 33px;"></th>
                                    <th style="padding-left:5px;"></th>
									<th>Адрес</th>
									<th>Время работы</th>
								</tr>
                                <tbody>
								<? foreach($list[3]->points as $point): ?>
									<?
									$options = array();
									foreach($point->params as $param){
										if($param->value=='1') $options[] = $param->id;
									}
									if(in_array(2,$options) || in_array(3,$options) || in_array(4,$options)) $options[] = '2_3_4';
									if(in_array(5,$options) || in_array(6,$options) || in_array(7,$options)) $options[] = '5_6_7';
									if(in_array(8,$options) || in_array(9,$options) || in_array(10,$options)) $options[] = '8_9_10';
									if(in_array(11,$options) || in_array(12,$options) || in_array(13,$options)) $options[] = '11_12_13';
									if(count($options)) $options = '|'.implode('|',$options).'|';

									$type = 'mainoffice';
									$icon = '/pics/i/maps/mainoffice.png';
									if($point->params[18]->value=='1'){
										$type = '24';
										$icon = '/pics/i/maps/24.png';
									}
									if($point->params[21]->value=='1'){
										$type = 'petro';
										$icon = '/pics/i/maps/petro.png';
									}
									if($point->params[22]->value=='1'){
										$type = 'magic';
										$icon = '/pics/i/maps/magic.png';
									}
									if($point->params[23]->value=='1'){
										$type = 'mainoffice';
										$icon = '/pics/i/maps/mainoffice.png';
									}
									?>
									<tr data-id="<?=$point->id?>" data-options="<?=$options?>" data-lat="<?=$point->latitude?>" data-lon="<?=$point->longitude?>" data-icon="<?=$icon?>" data-getcashcurrency="<?=$options?>" data-rechargecard="<?=$options?>" data-payservices="<?=$options?>" data-payservicecash="<?=$options?>" data-title="<?=str_replace('"','\"',$point->title)?>" data-type="<?=$type?>">
										<td><strong><?=$point->title?></strong></td>
										<td style="padding-right:5px; width: 33px;">
                                            <? if(count($point->params[25]->img)>0): ?>
                                                <a href="javascript:void(0)" class="colsPhoto" data-id="<?=$point->id?>"  data-rel="photo"></a>
                                            <? endif; ?>
                                        </td>
                                        <td style="padding-left:5px;">
											<? if(count($point->params[26]->img)>0): ?>
												<a href="javascript:void(0)" class="colsScheme"  data-id="<?=$point->id?>" data-rel="scheme">Схема</a>
											<? endif; ?>
										</td>
										<td><a href="#cols/map/<?=$point->id?>" class="onPage"><?=$point->params[24]->value?></a></td>
										<td><?=$point->params[1]->value?></td>
									</tr>
								<? endforeach; ?>
                                </tbody>
							</table>
						</div>
						<div class="cols-map  js-sub-page">
							<div id="colMap" class="map"></div>
						</div>

					</div>
				</div><!-- .pad-content -->
			</div><!-- .page-content -->
			<?
				include 'inc/aside.php';
			?>
		</div><!-- .page-layout -->
		<?
			include 'inc/footer.php';
		?>
	</div><!-- .page-container -->
</div><!-- .page-bg -->
<?
	$ymaps_popup = true;
	include 'inc/popup.php';
?>