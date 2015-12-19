<? include 'inc/meta.php'; ?>
<? $services_hide = array(278,279,295,296,297,301); ?>
<body>
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
							<li class="active"><a href="#atms" class="onPage">Банкоматы и терминалы</a></li>
						</ul>
					</nav>
					<div class="atms js-page"  style="display:block;">
						<nav class="section-navigator js-navigator sub-navigation">
							<ul>
								<li class="active"><a href="#atms/list" class="onPage">Списком</a></li>
								<li><a href="#atms/map" class="onPage">Посмотреть на карте</a></li>
							</ul>
						</nav>
						<div class="atms-list js-sub-page" style="display:block;">

                            <div id="stripePosition">
                                <div class="contacts-filter-stripe scrollable-stripe clearfix">
                                    <button href="javascript:void(0)" class="btn btn-small atmFilterLink js-contacts-filter" style="white-space:nowrap;">Найти банкомат или терминал</button>
                                    <div class="region-selector">
                                        <a href="javascript:void(0)" class="onPage" data-id="PermATMS"><span>Пермь</span></a>
                                        <a href="javascript:void(0)" class="onPage" data-id="PermReg"><span>Пермский край</span></a>
                                    </div>
                                </div>
                            </div>

							<div class="remark remark-error empty-filter">
								<p>К сожалению, ни один банкомат или терминал не подходит под выбранные настройки фильтра, попробуйте выбрать другие или <a
										class="onPage js-filter-reset" href="javascript:void(0)">сбросить настройки фильтра</a></p>
							</div>

                            <div class="filter-list contacts-list">
								<h2 id="PermATMS">Банкоматы и&nbsp;терминалы в&nbsp;Перми</h2>
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
										foreach($point->params as $code => $param){
											if($param->value=='1') $options[] = $code;
										}
										if(in_array('pay_card_rur',$options) || in_array('pay_card_usd',$options) || in_array('pay_card_eur',$options)) $options[] = 'pay_card_rur_eur_usd';
										if(in_array('pay_rur',$options) || in_array('pay_nal_rur',$options)) $options[] = 'pay_rur_nal_rur';
										
										if(count($options)) $options = '|'.implode('|',$options).'|';
											else $options = '';


                                        $type = '';
                                        $type2 = '';
                                        $icon = '';
                                        switch($point->params['type']->value_id){
                                            case '6':
                                                $type = 'magic';
                                                $icon = '/pics/i/maps/magic.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $icon = '/pics/i/maps/magic24.png';
                                                    $type2 = '24';
                                                }
                                                break;
                                            case '7':
                                                $type = 'partnerB';
                                                $icon = '/pics/i/maps/partnerB.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $icon = '/pics/i/maps/partner24.png';
                                                    $type2 = '24';
                                                }
                                                break;
                                            case '8':
                                                $type = 'partnerT';
                                                $icon = '/pics/i/maps/partnerT.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $icon = '/pics/i/maps/partner24.png';
                                                    $type2 = '24';
                                                }
                                                break;
                                            case '9':
                                                $type = 'atmB';
                                                $icon = '/pics/i/maps/atmB.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $type2 = '24';
                                                    $icon = '/pics/i/maps/atm24.png';
                                                }
                                                break;
                                            case '10':
                                                $type = 'atmT';
                                                $icon = '/pics/i/maps/atmT.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $type2 = '24';
                                                    $icon = '/pics/i/maps/atm24.png';
                                                }
                                                break;
                                        }
										if($point->params['main']->value=='1'){
											$type = 'mainoffice';
											$icon = '/pics/i/maps/mainoffice.png';
											if($point->params['24_hours']->value=='1'){
												$icon = '/pics/i/maps/mainoffice24.png';
												$type2 = '24';
											}
										}
                                        if($type!=''):
										?>
										<tr data-id="<?=$point->id?>" data-options="<?=$options?>" data-lat="<?=$point->latitude?>" data-lon="<?=$point->longitude?>" data-icon="<?=$icon?>" data-getcashcurrency="<?=$options?>" data-rechargecard="<?=$options?>" data-payservices="<?=$options?>" data-payservicecash="<?=$options?>" data-title="<strong><?=htmlspecialchars($point->title)?></strong><br><?=htmlspecialchars($point->params['address']->value)?>" data-type="<?=$type?>" data-type2="<?=$type2?>">
											<td>
												<strong><?=$point->title?></strong>
                                                <?
                                                $icon_text = '';
                                                list($g) = ModuleList4List4::model()->getList($point->id);
                                                switch($g) {
                                                    case '1':
                                                    case '2':
                                                        $icon_text = "Банкомат ЭКОПРОМБАНКа";
                                                        break;
                                                    case '316':
                                                        $icon_text = "Терминал ЭКОПРОМБАНКа";
                                                        break;
                                                }
												$icon_img = '';
												if($point->params['partner']->value=='1') $icon_text = 'Банкомат партнера';
												if($point->params['partner_term']->value=='1') $icon_text = 'Терминал партнера';
												if($point->params['icon']->value_id=='1') $icon_img = '<img src="/pics/bankicons/petrocommercbank.png" alt="Банк Петрокоммерц">';
												if($point->params['icon']->value_id=='2') $icon_img = '<img src="/pics/i/partner_magia.png" alt="Практическая магия">';
                                                if($point->params['icon']->value_id=='3') $icon_img = '<img src="/pics/bankicons/ecoprombank.png" alt="Экопромбанк">';
												if(!empty($icon_img) || !empty($icon_text)){
													echo '<p class="partner-icon">';
													if(!empty($icon_img)) echo $icon_img;
													if(!empty($icon_img) && !empty($icon_text)) echo ' ';
													if(!empty($icon_text)) echo $icon_text;
													echo '</p>';
												}
												?>
											</td>
											<td>
												<? if($point->params['24_hours']->value=='1'): ?>
													<img src="/pics/i/24.png" alt="24 часа"> часа
												<? else: ?>
													<?=$point->params['time']->value?>
												<? endif; ?>
											</td>
											<td><a href="#atms/map/<?=$point->id?>" class="onPage"><?=$point->params['address']->value?></a></td>
											<td>
												<span style="font-size: 12px; line-height: 18px;">
													<?
													/*if($point->id!=10){*/
														$array_out = array('#pay_card_rur_usd_eur' => array());
														foreach($point->params as $code => $param){
                                                            if (in_array(intval($param->id),$services_hide)) continue;
															if($param->value=='1'){
																switch($code){
																	case 'pay_card_rur':
																		$array_out['#pay_card_rur_usd_eur'][] = 'RUR';
																		break;
																	case 'pay_card_usd':
																		$array_out['#pay_card_rur_usd_eur'][] = 'USD';
																		break;
																	case 'pay_card_eur':
																		$array_out['#pay_card_rur_usd_eur'][] = 'EUR';
																		break;
																	default:
																		$array_out[$code] = $param->title.'; ';
																		break;
																}
															}
														}
														if(count($array_out['#pay_card_rur_usd_eur'])) $array_out['#pay_card_rur_usd_eur'] = 'Пополнить счет наличными с помощью карты ('.implode(', ',$array_out['#pay_card_rur_usd_eur']).');';
															else unset($array_out['#pay_card_rur_usd_eur']);
														echo implode(' ',$array_out);
													/*}else{
														echo 'Все услуги';
													}*/
													?>
												</span>
											</td>
										</tr>
                                        <? endif; ?>
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
										foreach($point->params as $code => $param){
											if($param->value=='1') $options[] = $code;
										}
										if(in_array('pay_card_rur',$options) || in_array('pay_card_usd',$options) || in_array('pay_card_eur',$options)) $options[] = 'pay_card_rur_eur_usd';
										if(in_array('pay_rur',$options) || in_array('pay_nal_rur',$options)) $options[] = 'pay_rur_nal_rur';
										/* if(in_array('nal_rur',$options) || in_array('nal_usd',$options) || in_array('nal_eur',$options)) $options[] = '2_3_4';
										if(in_array('pay_card_rur',$options) || in_array('pay_card_usd',$options) || in_array('pay_card_eur',$options)) $options[] = '5_6_7';
										if(in_array('pay_rur',$options) || in_array('pay_usd',$options) || in_array('pay_eur',$options)) $options[] = '8_9_10';
										if(in_array('pay_nal_rur',$options) || in_array('pay_nal_usd',$options) || in_array('pay_nal_eur',$options)) $options[] = '11_12_13'; */
										if(count($options)) $options = '|'.implode('|',$options).'|';
											else $options = '';

                                        $type = '';
                                        $type2 = '';
                                        $icon = '';
                                        switch($point->params['type']->value_id){
                                            case '6':
                                                $type = 'magic';
                                                $icon = '/pics/i/maps/magic.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $icon = '/pics/i/maps/magic24.png';
                                                    $type2 = '24';
                                                }
                                                break;
                                            case '7':
                                                $type = 'partnerB';
                                                $icon = '/pics/i/maps/partnerB.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $icon = '/pics/i/maps/partner24.png';
                                                    $type2 = '24';
                                                }
                                                break;
                                            case '8':
                                                $type = 'partnerT';
                                                $icon = '/pics/i/maps/partnerT.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $icon = '/pics/i/maps/partner24.png';
                                                    $type2 = '24';
                                                }
                                                break;
                                            case '9':
                                                $type = 'atmB';
                                                $icon = '/pics/i/maps/atmB.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $type2 = '24';
                                                    $icon = '/pics/i/maps/atm24.png';
                                                }
                                                break;
                                            case '10':
                                                $type = 'atmT';
                                                $icon = '/pics/i/maps/atmT.png';
                                                if($point->params['24_hours']->value=='1'){
                                                    $type2 = '24';
                                                    $icon = '/pics/i/maps/atm24.png';
                                                }
                                                break;
                                        }
                                        if($point->params['main']->value=='1'){
                                            $type = 'mainoffice';
                                            $icon = '/pics/i/maps/mainoffice.png';
                                            if($point->params['24_hours']->value=='1'){
                                                $icon = '/pics/i/maps/mainoffice24.png';
                                                $type2 = '24';
                                            }
                                        }
                                        if($type!=''):
										?>
										<tr data-id="<?=$point->id?>" data-options="<?=$options?>" data-lat="<?=$point->latitude?>" data-lon="<?=$point->longitude?>" data-icon="<?=$icon?>" data-getcashcurrency="<?=$options?>" data-rechargecard="<?=$options?>" data-payservices="<?=$options?>" data-payservicecash="<?=$options?>" data-title="<?=htmlspecialchars($point->title)?>" data-type="<?=$type?>" data-type2="<?=$type2?>">
											<td>
												<strong><?=$point->title?></strong>
												<?
												$icon_img = '';
												$icon_text = '';
												if($point->params['partner']->value=='1') $icon_text = 'Банкомат партнера';
												if($point->params['partner_term']->value=='1') $icon_text = 'Терминал партнера';
												if($point->params['icon']->value_id=='1') $icon_img = '<img src="/pics/bankicons/petrocommercbank.png" alt="Банк Петрокоммерц">';
												if($point->params['icon']->value_id=='2') $icon_img = '<img src="/pics/i/partner_magia.png" alt="Практическая магия">';
												if(!empty($icon_img) || !empty($icon_text)){
													echo '<p class="partner-icon">';
													if(!empty($icon_img)) echo $icon_img;
													if(!empty($icon_img) && !empty($icon_text)) echo ' ';
													if(!empty($icon_text)) echo $icon_text;
													echo '</p>';
												}
												?>
											</td>
											<td>
												<? if($point->params['24_hours']->value=='1'): ?>
													<img src="/pics/i/24.png" alt="24 часа"> часа
												<? else: ?>
													<?=$point->params['time']->value?>
												<? endif; ?>
											</td>
											<td><?=$point->params['address']->value?></td>
											<td>
												<span style="font-size: 12px; line-height: 18px;">
													<?
													/*if($point->id!=10){*/
														$array_out = array('#pay_card_rur_usd_eur' => array());
														foreach($point->params as $code => $param){
															if (in_array(intval($param->id),$services_hide)) continue;
                                                            if($param->value=='1'){
																switch($code){
																	case 'pay_card_rur':
																		$array_out['#pay_card_rur_usd_eur'][] = 'RUR';
																		break;
																	case 'pay_card_usd':
																		$array_out['#pay_card_rur_usd_eur'][] = 'USD';
																		break;
																	case 'pay_card_eur':
																		$array_out['#pay_card_rur_usd_eur'][] = 'EUR';
																		break;
																	default:
																		$array_out[$code] = $param->title.'; ';
																		break;
																}
															}
														}
														if(count($array_out['#pay_card_rur_usd_eur'])) $array_out['#pay_card_rur_usd_eur'] = 'Пополнить счет наличными с помощью карты ('.implode(', ',$array_out['#pay_card_rur_usd_eur']).');';
															else unset($array_out['#pay_card_rur_usd_eur']);
														echo implode(' ',$array_out);
													/*}else{
														echo 'Все услуги';
													}*/
													?>
												</span>
											</td>
										</tr>
                                        <? endif; ?>
									<? endforeach; ?>
								</table>
							</div>
						</div>
						<div class="atms-map  js-sub-page">
                            <div class="contacts-filter-stripe clearfix">
                                <button href="javascript:void(0)" class="btn btn-small atmFilterLink js-contacts-filter" style="white-space:nowrap;">Найти банкомат или терминал</button>
                            </div>
							<div class="legend clearfix">
								<table>
									<tr>
                                        <td>
                                            <a href="javascript:void(0)" class="clearfix" data-type="">
                                                <img src="/pics/i/maps/all.png" alt="Все банкоматы и терминалы"> <span>Все банкоматы и терминалы</span>
                                            </a>
                                        </td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="atmB">
												<img src="/pics/i/maps/atmB.png" alt="Банкоматы Экопромбанка"> <span>Банкоматы Экопромбанка</span>
											</a>
										</td>
                                        <td>
                                            <a href="javascript:void(0)" class="clearfix" data-type="atmT">
                                                <img src="/pics/i/maps/atmT.png" alt="Терминалы Экопромбанка"> <span>Терминалы Экопромбанка</span>
                                            </a>
                                        </td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="24">
												<img src="/pics/i/maps/atm24.png" alt="Круглосуточные банкоматы"> <span>Круглосуточные банкоматы и&nbsp;терминалы</span>
											</a>
										</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0)" class="clearfix" data-type="mainoffice">
                                                <img src="/pics/i/maps/mainoffice.png" alt="Центральный офис Экопромбанка"> <span>Главный офис</span>
                                            </a>
                                        </td>
										<td>
											<a href="javascript:void(0)" class="clearfix" data-type="partnerB">
												<img src="/pics/i/maps/partnerB.png" alt="Банкоматы партнеров"> <span>Банкоматы партнеров</span>
											</a>
										</td>
                                        <td>
                                            <a href="javascript:void(0)" class="clearfix" data-type="partnerT">
                                                <img src="/pics/i/maps/partnerT.png" alt="Терминалы партнеров"> <span>Терминалы партнеров</span>
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