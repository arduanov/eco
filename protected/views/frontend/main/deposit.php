<? include 'inc/meta.php'; ?>

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
                    <?
                        $aside_fixed_class = 'aside-fixed';
                        include 'inc/aside.php';
                    ?>
                    <div class="page-content fixed-aside">
                        <div class="pad-content">
                            <div class="filter deposit-filter new-deposit-filter">
                                <div class="filter-pad clearfix">
                                    <div class="slider-rows clearfix" style="position:relative; z-index:5;">
                                        <div class="slider first clearfix" style="width:240px; position:relative; z-index:3;">
                                            <span class="label">Сумма вклада</span>
                                            <select name="deposit[currency]">
                                                <option value="rur">Руб.</option>
                                                <option value="usd">Долл.</option>
                                                <option value="eur">Евро</option>
                                            </select>
                                             <div class="inpC">
                                                <input class="inp" id="summ" name="deposit[summ]" value="350 000" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-row-deposit">
                                        <div class="deposit-slider-input" style="clear:both;"></div>
                                        <div class="deposit-slider-legend">
                                            <table>
                                                <tr>
                                                    <td class="start-range">5&nbsp;000</td>
                                                    <td class="range2">100&nbsp;000</td>
                                                    <td class="range3">1&nbsp;000&nbsp;000</td>
                                                    <td class="range4">10&nbsp;000&nbsp;000</td>
                                                    <td class="last"></td>
                                                </tr>
                                            </table>
                                            <span class="end-range">100&nbsp;000&nbsp;000</span>
                                        </div>
                                    </div>
                                    <div class="slider-rows clearfix">
                                        <div class="slider selectOnly clearfix" style="margin-left:0;">
                                            <span class="label">Cрок вклада</span>
                                            <select name="deposit[period]">
                                                <option value="31">1 месяц + день</option>
                                                <option value="91">3 месяца + день</option>
                                                <option value="181">6 месяцев + день</option>
                                                <option value="271">9 месяцев + день</option>
                                                <option value="370" selected="selected">1 год + 5 дней</option>
                                                <option value="740">2 года + 10 дней</option>
                                                <option value="1110">3 года + 15 дней</option>
                                                <option value="1480">4 года + 20 дней</option>
                                                <option value="1850">5 лет + 25 дней</option>
                                            </select>
                                        </div>
                                    </div>

                                   <?/* <div class="col first">
                                        <div class="filter-block">
											<?
											$param = ModuleList3Params::model()->getItem(65);
											if($param->data_type_id==2):
											?>
												<label class="row">
													<input type="checkbox" name="deposit[options]" value="65"> <?=$param['title']?>
												</label>
											<? endif; ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="filter-block">
											<?
											$param = ModuleList3Params::model()->getItem(66);
											if($param->data_type_id==2):
											?>
												<label class="row">
													<input type="checkbox" name="deposit[options]" value="66"> <?=$param['title']?>
												</label>
											<? endif; ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="filter-block">
											<?
											$param = ModuleList3Params::model()->getItem(67);
											if($param->data_type_id==2):
											?>
												<label class="row">
													<input type="checkbox" name="deposit[options]" value="67"> <?=$param['title']?>
												</label>
											<? endif; ?>
                                        </div>
                                    </div>
                                    <div class="col last">
                                        <div class="filter-block">
											<?
											$param = ModuleList3Params::model()->getItem(68);
											if($param->data_type_id==5 || $param->data_type_id==6):
											?>
												<h6><?=$param['title']?></h6>
												<?
												$params_values = ModuleList3ParamsValues::model()->getList($param->id);
												$checked = 'checked = "checked"';
												foreach($params_values as $key => $value):
												?>
													<label class="row">
														<input type="<?=($param->data_type_id==5)?'radio':'radio'?>" <?=$checked?> name="deposit[<?=$param->code?>]" value="<?=$value->id?>"> <?=$value->title?>
													</label>
													<?$checked = '';?>
												<? endforeach; ?>
											<? endif; ?>
                                        </div>
                                    </div>*/?>
                                </div><!-- .filter-pad -->
                               <!-- <div class="filter-reset">
                                    <a href="javascript:void(0)" class="onPage icon-link  js-filter-reset"><span>Сбросить настройки фильтра</span></a>
                                </div>-->
                            </div><!-- .filter .card-filter -->

                            <!--<div class="remark remark-error empty-filter">
                                <p>Просим Вас <a class="onPage js-filter-reset" href="javascript:void(0)">изменить параметры фильтра</a> для выбора другого вклада. Пожелания Вы можете отправить нам через сервис «<a class="onPage js-feedback-trigger" href="javascript:void(0)">Оставить отзыв</a>».</p>
                            </div>-->
                            <a href="javascript:void(0)" class="ctrlLeft" style="display:none"><span></span></a>
                            <a href="javascript:void(0)" class="ctrlRight" style="display:none"><span></span></a>
                            <div class="filter-list deposit-list clearfix">
                                <!-- .filter-list-aside -->
                                <div class="ovf">
                                    <table class="scrollTable" style="table-layout: fixed;">
                                        <tbody>
											<tr data-id="-1" class="js-FilterHead">
                                                <th>Вклад</th>
												<th>Ставка в %</th>
												<th>Доход</th>
												<th>Общая сумма вклада</th>
                                                <th class="last"></th>
											</tr>
											<? foreach($list3 as $key => $item): ?>
												<?
												$data_types = array();
												foreach(array('currency','percents') as $code){
													if(isset($item->params[$code]) && is_array($item->params[$code]) && in_array($item->params[$code]['data_type_id'],array(1,5,6))){
														if(isset($item->params[$code]['value']) && is_array($item->params[$code]['value']) && count($item->params[$code]['value'])){
															$data_types_i = array();
															foreach($item->params[$code]['value'] as $value){
																switch($value['id']){
																	case 39: $data_types_i[] = 'rur'; break;
																	case 40: $data_types_i[] = 'usd'; break;
																	case 41: $data_types_i[] = 'eur'; break;
																	default : $data_types_i[] = $value['id']; break;
																}
															}
															$data_types_i = 'data-'.$code.'="|'.implode('|',$data_types_i).'|"';
															$data_types[] = $data_types_i;
														}
													}
												}
												$data_types_i = array();
												if($item->params['deposit_adj']['value']==1) $data_types_i[] = 65;
												if($item->params['deposit_take_off']['value']==1) $data_types_i[] = 66;
												if($item->params['deposit_close']['value']==1) $data_types_i[] = 67;
												if(count($data_types_i)) $data_types[] = 'data-options="|'.implode('|',$data_types_i).'|"';
												
												$data_types_i = array();
												foreach(array(31,91,181,271,370,740,1110,1480,1850) as $period){
													if(!empty($item->params['rur_'.$period]['value']) || !empty($item->params['usd_'.$period]['value']) || !empty($item->params['eur_'.$period]['value']))
															$data_types_i[] = $period;
												}
												if(count($data_types_i)) $data_types[] = 'data-period="|'.implode('|',$data_types_i).'|"';
													
												$data_types = implode(' ',$data_types);
												?>
												<? if(empty($item->params['deposit_type'])): ?>
													<tr data-id="<?=$key?>" <?=$data_types?> data-minrur="<?=str_replace(',','.',$item->params['min_sum_rur']['value'])?>" data-minusd="<?=str_replace(',','.',$item->params['min_sum_usd']['value'])?>" data-mineur="<?=str_replace(',','.',$item->params['min_sum_eur']['value'])?>">
												<? else: ?>
													<tr data-id="<?=$key?>" <?=$data_types?> data-minrur="<?=str_replace(',','.',$item->params['min_sum_rur']['value'])?>">
												<? endif; ?>
                                                        <td class="table-deposit-type">
                                                            <strong><a href="<?=$pages->make_url($doc_id_last)?>show_<?=$key?>/"><?=$item->title?></a></strong>
                                                        </td>
														<td class="table-deposit-percents">
                                                            —
														</td>
                                                        <td class="table-deposit-income">
                                                            —
                                                        </td>
                                                        <td class="table-deposit-summ">
                                                            —
                                                        </td>
                                                        <td class="table-deposit-offer last" style="white-space:nowrap; width:170px;">
                                                            <a href="javascript:void(0)" class="btn btn-small  js-vklad-order-trigger" data-name="<?=$item->title?>" data-period="370" data-currency="RUR" data-summ="350 000">Оформить</a>
                                                        </td>
													</tr>
											<? endforeach; ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        /*Проценты вклады и методы вычисления*/
                                        var DEPOSIT_PERCENTS = {
											<? $i = 0; ?>
											<? $count = count($list3); ?>
											<? foreach($list3 as $key => $item): ?>
												<? $i++; ?>
												deposit<?=$key?> : {
												<? if(empty($item->params['deposit_type'])): ?>
														trigger : 'period',
														periods : {
															<? foreach(array('rur','usd','eur') as $valuta): ?>
															<?=$valuta?> : [
																<?
																$var_arr = array();
																foreach(array(31,91,181,271,370,740,1110,1480,1850) as $period){
																	if(!empty($item->params[$valuta.'ef_'.$period]['value'])){
                                                                            $var_arr[] = '{period : '.$period.', percents : '.str_replace(',','.',$item->params[$valuta.'ef_'.$period]['value']).' , percents_viwe : '.str_replace(',','.',$item->params[$valuta.'_'.$period]['value']).'}';
                                                                            // echo '{period : ',$period,', percents : ',str_replace(',','.',$item->params[$valuta.'_'.$period]['value']),'}';
                                                                            // if($period!=1850) echo ',';
                                                                    }
																}
																echo implode(',',$var_arr);
																?>
															]<?=($valuta!='eur')?',':''?>
															<? endforeach; ?>
														},
												<? else: ?>
														trigger : 'summ',
														summ : <?=str_replace(',','.',$item->params['deposit_sum']['value'])?>,
														periodsMore : {
															rur : [
																<?
																$valuta = 'rur2';
																$var_arr = array();
																foreach(array(31,91,181,271,370,740,1110,1480,1850) as $period){
																	if(!empty($item->params[$valuta.'_ef_'.$period]['value'])){
																			$var_arr[] = '{period : '.$period.', percents : '.str_replace(',','.',$item->params[$valuta.'ef_'.$period]['value']).', percents_viwe : '.str_replace(',','.',$item->params[$valuta.'_'.$period]['value']).'}';
																			// echo '{period : ',$period,', percents : ',str_replace(',','.',$item->params[$valuta.'_'.$period]['value']),'}';
																			// if($period!=1850) echo ',';
																	}
																}
																echo implode(',',$var_arr);
																?>
															]
														},
														periodsLess : {
															rur : [
																<?
																$valuta = 'rur';
																$var_arr = array();
																foreach(array(31,91,181,271,370,740,1110,1480,1850) as $period){
																	if(!empty($item->params[$valuta.'ef_'.$period]['value'])){
																			$var_arr[] = '{period : '.$period.', percents : '.str_replace(',','.',$item->params[$valuta.'ef_'.$period]['value']).', percents_viwe : '.str_replace(',','.',$item->params[$valuta.'_'.$period]['value']).'}';
																			// echo '{period : ',$period,', percents : ',str_replace(',','.',$item->params[$valuta.'_'.$period]['value']),'}';
																			// if($period!=1850) echo ',';
																	}
																}
																echo implode(',',$var_arr);
																?>
															]
														},
												<? endif; ?>
													percentsMin : "<?=str_replace(array('"',"\n","\r"),array('\"','',''),nl2br($item->params['percents_base']['value']))?>"
												}<?=($i<$count)?',':''?>
											<? endforeach; ?>
                                        }
                                    </script>
                                    <!-- .scrollTable -->
                                </div>
                                <p style="color:#888; font-size:12px; line-height:18px;">Уважаемые Клиенты!<br>
                                 Данный расчет приблизителен, служит для ознакомительных целей и&nbsp;не&nbsp;является публичной офертой. Данные могут варьироваться в&nbsp;зависимости от&nbsp;даты открытия вклада и&nbsp;операций снятия/пополнения средств.							</p>
                            </div><!-- .filter-list -->
                            <div class="list-bottom clearfix">
                                <h2 class="headline">Оформление вклада</h2>
                                <div  style="width: 88%"><?=nl2br($short)?></div>
                                <p>
                                    <a href="/personal/holdings/howto/" class="btn">Подробнее</a>
                                </p>
                                <img class="list-bottom-bg" src="/pics/bg/list/deposit.png">
                            </div>
				</div><!-- .pad-content -->
			</div><!-- .page-content -->
		</div><!-- .page-layout -->
		<?
			include 'inc/footer.php';
		?>
	</div><!-- .page-container -->
</div><!-- .page-bg -->
<?
	include 'inc/popup.php';
?>
