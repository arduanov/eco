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
			<?
            $cards_code = array(
                40 => 'debit',
                41 => 'credit',
                110 => 'storage',
                111 => 'pension',
                112 => 'salary'
            );

            $debit_doc_id = 40;
            $credit_doc_id = 41;
            $storage_doc_id = 110;
            $pension_doc_id = 111;
            $salary_doc_id = 112;

			$fields_data_1 = ModuleFields::model()->getValueListByPageId($debit_doc_id);
			$fields_data_2 = ModuleFields::model()->getValueListByPageId($credit_doc_id);
            $fields_data_3 = ModuleFields::model()->getValueListByPageId($storage_doc_id);
            $fields_data_4 = ModuleFields::model()->getValueListByPageId($pension_doc_id);
            $fields_data_5 = ModuleFields::model()->getValueListByPageId($salary_doc_id);

            $criteria = new CDbCriteria();
            $criteria->order = 'sort ASC';
            $criteria->condition = 'active > 0 AND id IN (40,41,110,111,112)';
            $cards_list = Pages::model()->findAll($criteria);
            foreach ($cards_list as $v) {
                $cards_data[$v->id] = array(
                    'page' => $v->getAttributes(),
                    'nav' => '<li><a href="#'.$cards_code[$v->id].'cards" class="onPage" data-cardtype="doc_'.$v->id.'">'.$v->name.'</a></li>'
                );
            }
			?>
			<div class="page-content fixed-aside">
				<div class="pad-content">
					<?=$pages->set_url($content)?>
					<nav class="section-navigator js-navigator">
						<ul>
							<li class="active"><a href="#all" class="onPage" data-cardtype="0">Все карты</a></li>
                            <? foreach($cards_data as $v) echo $v['nav']; ?>
						</ul>
					</nav>
                    <?
                    $filter_block = array();
                    if($fields_data_1['all_hide']=='1') $filter_block[] = 'debit_hide';
                    else $filter_block[] = 'debit_show';
                    if($fields_data_2['all_hide']=='1') $filter_block[] = 'credit_hide';
                    else $filter_block[] = 'credit_show';
                    if($fields_data_3['all_hide']=='1') $filter_block[] = 'storage_hide';
                    else $filter_block[] = 'storage_show';
                    if($fields_data_4['all_hide']=='1') $filter_block[] = 'pension_hide';
                    else $filter_block[] = 'pension_show';
                    if($fields_data_5['all_hide']=='1') $filter_block[] = 'salary_hide';
                    else $filter_block[] = 'salary_show';
                    if(
                        $fields_data_1['all_hide']=='1' &&
                        $fields_data_2['all_hide']=='1' &&
                        $fields_data_3['all_hide']=='1' &&
                        $fields_data_4['all_hide']=='1' &&
                        $fields_data_5['all_hide']=='1'
                    ) $filter_block[] = 'hidden';
                    ?>
                    <div class="filter-close <?=implode(' ', $filter_block)?>">
                        <a href="javascript: void(0)" class="onPage"><span>Скрыть фильтр</span></a>
                        <a href="javascript: void(0)" class="onPage hidden"><span>Показать фильтр</span></a>
                        <div style="clear: both;"></div>
                    </div>
					<div class="filter card-filter <?=implode(' ', $filter_block)?>">
						<div class="filter-pad clearfix">
							<?
							foreach(array(
								array(16,17),
								array(18,19),
								array(20),
								array(21)
							) as $param_array):
							?>
							<div class="col first">
								<?
								foreach($param_array as $param_id):
                                    $param = ModuleList3Params::model()->getItem($param_id);

                                    $filter_block_class = array();
                                    if($fields_data_1[$param->code.'_hide']=='1') $filter_block_class[] = 'debit_hide';
                                        else $filter_block_class[] = 'debit_show';
                                    if($fields_data_2[$param->code.'_hide']=='1') $filter_block_class[] = 'credit_hide';
                                        else $filter_block_class[] = 'credit_show';
                                    if($fields_data_3[$param->code.'_hide']=='1') $filter_block_class[] = 'storage_hide';
                                        else $filter_block_class[] = 'storage_show';
                                    if($fields_data_4[$param->code.'_hide']=='1') $filter_block_class[] = 'pension_hide';
                                        else $filter_block_class[] = 'pension_show';
                                    if($fields_data_5[$param->code.'_hide']=='1') $filter_block_class[] = 'salary_hide';
                                        else $filter_block_class[] = 'salary_show';
                                    if(
                                        $fields_data_1[$param->code.'_hide']=='1' &&
                                        $fields_data_2[$param->code.'_hide']=='1' &&
                                        $fields_data_3[$param->code.'_hide']=='1' &&
                                        $fields_data_4[$param->code.'_hide']=='1' &&
                                        $fields_data_5[$param->code.'_hide']=='1'
                                    ) $filter_block_class[] = 'hidden';

									if($param->data_type_id==5):
								?>
										<div class="filter-block <?=implode(' ', $filter_block_class)?>"  <?=$param->code == 'limit' ? 'id="limitCred"' : ''?>>
											<h6><?=$param->title?><?= $param->code=='type' ? ' <a href="javascript:void(0)" class="cardseq onPage">Сравнить</a>' : ''?></h6>
											<?
											$params_values = ModuleList3ParamsValues::model()->getList($param->id);
                                            if($param->code=='type'){
                                                ?>
                                                <label class="row">
                                                    <input type="radio" name="cardfilter[<?=$param->code?>]" value="reset-value"> Любой
                                                </label>
                                                <?
                                            }
											foreach($params_values as $key => $value):
                                                $label_row_class = array();
                                                if($value->check_1=='1') $label_row_class[] = 'debit_hide';
                                                    else $label_row_class[] = 'debit_show';
                                                if($value->check_2=='1') $label_row_class[] = 'credit_hide';
                                                    else $label_row_class[] = 'credit_show';
                                                if($value->check_3=='1') $label_row_class[] = 'storage_hide';
                                                    else $label_row_class[] = 'storage_show';
                                                if($value->check_4=='1') $label_row_class[] = 'pension_hide';
                                                    else $label_row_class[] = 'pension_show';
                                                if($value->check_5=='1') $label_row_class[] = 'salary_hide';
                                                    else $label_row_class[] = 'salary_show';
                                                if(
                                                    $value->check_1=='1' &&
                                                    $value->check_2=='1' &&
                                                    $value->check_3=='1' &&
                                                    $value->check_4=='1' &&
                                                    $value->check_5=='1'
                                                ) $label_row_class[] = 'hidden';
											?>
												<label class="row <?=implode(' ', $label_row_class)?>" <?=($param->code=='features' && $value->id == '32') ? 'id="plusPercents"' : ''?>>
													<input type="radio" name="cardfilter[<?=$param->code?>]" value="<?=$value->id?>"> <?=$value->title?>
												</label>
											<? endforeach; ?>
										</div>
									<? endif; ?>
									<?
									if($param->data_type_id==6):
									?>
										<div class="filter-block <?=implode(' ', $filter_block_class)?>" <?=$param->code == 'limit' ? 'id="limitCred"' : ''?>>
											<h6><?=$param->title?><?= $param->code=='type' ? ' <a href="javascript:void(0)" class="cardseq onPage">Сравнить</a>' : ''?></h6>
											<?
											$params_values = ModuleList3ParamsValues::model()->getList($param->id);
											foreach($params_values as $key => $value):
                                                $label_row_class = array();
                                                if($value->check_1=='1') $label_row_class[] = 'debit_hide';
                                                else $label_row_class[] = 'debit_show';
                                                if($value->check_2=='1') $label_row_class[] = 'credit_hide';
                                                else $label_row_class[] = 'credit_show';
                                                if($value->check_3=='1') $label_row_class[] = 'storage_hide';
                                                else $label_row_class[] = 'storage_show';
                                                if($value->check_4=='1') $label_row_class[] = 'pension_hide';
                                                else $label_row_class[] = 'pension_show';
                                                if($value->check_5=='1') $label_row_class[] = 'salary_hide';
                                                else $label_row_class[] = 'salary_show';
                                                if(
                                                    $value->check_1=='1' &&
                                                    $value->check_2=='1' &&
                                                    $value->check_3=='1' &&
                                                    $value->check_4=='1' &&
                                                    $value->check_5=='1'
                                                ) $label_row_class[] = 'hidden';
											?>
												<label class="row <?=implode(' ', $label_row_class)?>" <?=($param->code == 'features' && $value->id == '32') ? 'id="plusPercents"' : ''?>>
													<input type="checkbox" name="cardfilter[<?=$param->code?>]" data-rel="additional-property" value="<?=$value->id?>"> <?=$value->title?>
												</label>
											<? endforeach; ?>
										</div>
									<? endif; ?>
								<? endforeach; ?>
							</div>
							<? endforeach; ?>
						</div><!-- .filter-pad -->
						<div class="filter-reset">
							<a href="javascript:void(0)" class="onPage icon-link  js-filter-reset"><span>Сбросить настройки фильтра</span></a>
						</div>
					</div><!-- .filter .card-filter -->
					<div class="remark remark-error empty-filter">
                        <p>Вы&nbsp;выбрали карту, которая пока еще находится в&nbsp;разработке. Возможно, Вам подойдет карта с&nbsp;другими параметрами (<a class="onPage js-filter-reset" href="javascript:void(0)">измените настройки фильтра</a>). Ваши пожелания Вы&nbsp;можете отправить нам через сервис  <a class="onPage js-feedback-trigger" href="javascript:void(0)">&laquo;Оставить отзыв&raquo;</a>.</p>
					</div>
                    <div class="div_debit hidden">
                        <?=(isset($fields_data_1['description']))?$pages->set_url($fields_data_1['description']):''?>
                    </div>
                    <div class="div_credit hidden">
                        <?=(isset($fields_data_2['description']))?$pages->set_url($fields_data_2['description']):''?>
                    </div>
                    <div class="div_storage hidden">
                        <?=(isset($fields_data_3['description']))?$pages->set_url($fields_data_3['description']):''?>
                    </div>
                    <div class="div_pension hidden">
                        <?=(isset($fields_data_4['description']))?$pages->set_url($fields_data_4['description']):''?>
                    </div>
                    <div class="div_salary hidden">
                        <?=(isset($fields_data_5['description']))?$pages->set_url($fields_data_5['description']):''?>
                    </div>
					<a href="javascript:void(0)" class="ctrlLeft"><span></span></a>
					<a href="javascript:void(0)" class="ctrlRight"><span></span></a>
					<div class="filter-list clearfix">
						<aside class="table-left">
							<table>
								<tbody>
									<tr data-id="-1">
										<th class="table-card-type">Тип карты</th>
									</tr>
									<? foreach(array($debit_cards, $credit_cards, $storage_cards, $pension_cards, $salary_cards) as $i => $array): ?>
										<? foreach($array as $key => $item): ?>
											<? 
											if($i==0) $url = $pages->make_url($debit_doc_id).'show_'.$key.'/';
                                            if($i==1) $url = $pages->make_url($credit_doc_id).'show_'.$key.'/';
                                            if($i==2) $url = $pages->make_url($storage_doc_id).'show_'.$key.'/';
                                            if($i==3) $url = $pages->make_url($pension_doc_id).'show_'.$key.'/';
                                            if($i==4) $url = $pages->make_url($salary_doc_id).'show_'.$key.'/';
											?>
										<tr data-id="<?=$key?>">
											<td class="table-card-type">
												<? if(count($item['img'])): ?>
													<a href="<?=$url?>"><img src="<?=$item['img'][4]?>" height="70" alt="<?=$item->title?>"></a>
												<? endif; ?>
												<a href="<?=$url?>"><?=$item->title?></a>
											</td>
										</tr>
										<? endforeach; ?>
									<? endforeach; ?>
								</tbody>
							</table>
						</aside>
						<aside class="table-right">
							<table>
								<tbody>
									<tr data-id="-1">
										<th></th>
									</tr>
									<? foreach(array($debit_cards, $credit_cards, $storage_cards, $pension_cards, $salary_cards) as $array): ?>
										<? foreach($array as $key => $item): ?>
										<tr data-id="<?=$key?>">
											<td>
												<?/*?>
                                                <? if(in_array($key, array(4,5,6))):?>
												    <button class="btn btn-small offerCardForm" data-id="<?=$key?>">Оформить</button>
                                                <? else:?>
													<?if($key !== 16):?>
                                                    <a href="/personal/cards/howto/">Оформить карту</a>
													<?endif;?>
                                                <? endif;?>
												<?*/?>
                                                <? if($item->params['kredit_card']['value'] == 1):?>
												    <button class="btn btn-small offerCardForm" data-id="<?=$key?>">Оформить</button>

                                                <?endif;?>
                                                <? /*if($key == 16|| $key == 27):?>
<!--													<a href="/personal/cards/howto/">Оформить карту</a>-->
                                                <? else:?>
													<button class="btn btn-small offerCardForm" data-id="<?=$key?>">Оформить</button>
												<? endif;*/?>
											</td>
										</tr>
										<? endforeach; ?>
									<? endforeach; ?>
								</tbody>
							</table>
						</aside><!-- .filter-list-aside -->
						<?
						$param_21 = ModuleList3Params::model()->getItem(21);
						if($param_21->data_type_id==6){
							$params_values_21 = ModuleList3ParamsValues::model()->getList($param_21->id);
						}
						?>
						<div class="ovf">
							<table class="scrollTable" id="TableL">
								<tr data-id="-1" class="js-FilterHead">
									<?/*<th>Валюта карты</th>*/?>
									<th>Стоимость годового обслуж.</th>
									<?
									$param_21 = ModuleList3Params::model()->getItem(21);
									if($param_21->data_type_id==6):
									?>
											<?
											foreach($params_values_21 as $key => $value):
											?>
												<th><?=$value->title?></th>
											<? endforeach; ?>
									<? endif; ?>
									<? foreach(array('additionally'/*,'limit','receipt','duration'*/) as $code): ?>
										<? if(isset($item->params[$code]) && is_array($item->params[$code])): ?>
											<th><?=$item->params[$code]['title']?></th>
										<? endif; ?>
									<? endforeach; ?>
									<!--th>Дополнит. возмож-ти и&nbsp;ограничения</th>
									<th>Кредитный лимит</th>
									<th>Срок выпуска</th>
									<th>Срок действия</th-->
								</tr>
								<?
                                foreach(array(
                                            $debit_doc_id => $debit_cards,
                                            $credit_doc_id => $credit_cards,
                                            $storage_doc_id => $storage_cards,
                                            $pension_doc_id => $pension_cards,
                                            $salary_doc_id => $salary_cards
                                       ) as $doc_id => $array):
                                ?>
                                    <? foreach($array as $key => $item): ?>
                                        <?
                                        $data_types = array();
                                        foreach(array('type','receipt','duration','currency','limit','features') as $code){
                                            if(isset($item->params[$code]) && is_array($item->params[$code]) && in_array($item->params[$code]['data_type_id'],array(1,5,6))){
                                                if(isset($item->params[$code]['value']) && is_array($item->params[$code]['value']) && count($item->params[$code]['value'])){
                                                    $data_types_i = array();
                                                    foreach($item->params[$code]['value'] as $value){
                                                        $data_types_i[] = $value['id'];
                                                    }
                                                    $data_types_i = 'data-'.$code.'="|'.implode('|',$data_types_i).'|"';
                                                    $data_types[] = $data_types_i;
                                                }
                                            }
                                        }
                                        $data_types = implode(' ',$data_types);
                                        ?>
                                        <tr data-id="<?=$key?>" class="doc_<?=$doc_id?>" <?=$data_types?>>
                                            <?/*<td class="table-card-currency">
                                                <? foreach(array('currency') as $code): ?>
                                                    <? if(isset($item->params[$code]) && is_array($item->params[$code]) && in_array($item->params[$code]['data_type_id'],array(1,5,6))): ?>
                                                        <? if(isset($item->params[$code]['value']) && is_array($item->params[$code]['value']) && count($item->params[$code]['value'])): ?>
                                                            <?
                                                            $i = 0;
                                                            $count = count($item->params[$code]['value']);
                                                            foreach($item->params[$code]['value'] as $value){
                                                                $i++;
                                                                echo $value['title'];
                                                                if($i<$count) echo '<br>';
                                                            }
                                                            ?>
                                                            <?//=$item->params[$code]['value'][0]['title']?>
                                                        <? elseif(isset($item->params[$code]['value']) && !is_array($item->params[$code]['value'])): ?>
                                                            <?=$item->params[$code]['value']?>
                                                        <? else: ?>
                                                            &mdash;
                                                        <? endif; ?>
                                                    <? endif; ?>
                                                <? endforeach; ?>
                                            </td>*/?>
                                            <td class="table-card-currency" data-hint="Стоимость годового обслуж.">
                                                <? if(isset($item->params['cost']) && is_array($item->params['cost']) && isset($item->params['cost']['value']) && !is_array($item->params['cost']['value']) && !empty($item->params['cost']['value'])): ?>
                                                    <?=$item->params['cost']['value']?>
                                                <? endif; ?>
                                            </td>
                                            <?
                                            if($param_21->data_type_id==6):
                                            ?>
                                                    <?
                                                    foreach($params_values_21 as $key => $value):
                                                            $exist_params_values = ModuleList3Values::model()->exist_value($item->id, $param_21->id, $value->id);
                                                    ?>
                                                        <td data-hint="<?=$value->title?>">
                                                            <? if($exist_params_values): ?>
                                                                <i class="icon icon-positive"></i>
                                                            <? else: ?>
                                                                <i class="icon icon-negative"></i>
                                                            <? endif; ?>
                                                        </td>
                                                    <? endforeach; ?>
                                            <? endif; ?>
                                            <td>
                                                <? if(isset($item->params['additionally']) && is_array($item->params['additionally']) && isset($item->params['additionally']['value']) && !is_array($item->params['additionally']['value']) && !empty($item->params['additionally']['value'])): ?>
                                                    <?=$item->params['additionally']['value']?>
                                                <? endif; ?>
                                            </td>
                                            <?/* foreach(array('limit','receipt','duration') as $code): ?>
                                                <td>
                                                <? if(isset($item->params[$code]) && is_array($item->params[$code]) && in_array($item->params[$code]['data_type_id'],array(1,5))): ?>
                                                    <? if(isset($item->params[$code]['value']) && is_array($item->params[$code]['value']) && count($item->params[$code]['value'])): ?>
                                                        <?=$item->params[$code]['value'][0]['title']?>
                                                    <? elseif(isset($item->params[$code]['value']) && !is_array($item->params[$code]['value'])): ?>
                                                        <?=$item->params[$code]['value']?>
                                                    <? else: ?>
                                                        &mdash;
                                                    <? endif; ?>
                                                <? endif; ?>
                                                </td>
                                            <? endforeach; */?>
                                        </tr>
                                    <? endforeach; ?>
								<? endforeach; ?>
							</table> <!-- .scrollTable -->
						</div>
					</div><!-- .filter-list -->
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