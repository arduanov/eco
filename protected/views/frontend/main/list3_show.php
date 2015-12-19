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
			<h1 class="headline"><?=$item->title?> <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
			<div class="page-content">
				<div class="pad-content">
					<div class="list-page clearfix">
						<div class="list-intro clearfix">
							<? if(count($item->img)): ?>
								<img src="<?=$item->img[3]?>" alt="<?=$item->title?>" class="list-img">
							<? endif;?>
							<div class="list-intro-text">
								<?
								$item->text = $pages->set_url($item->text);
								$item_text = explode('</p>',$item->text);
								$item_text_bonus = '';
								if(count($item_text)>1){
									$item_text_bonus = $item_text;
									unset($item_text_bonus[0]);
									$item_text_bonus = implode('</p>',$item_text_bonus);
								}
								$item_text = $item_text[0].'</p>';
								?>
								<?=$item_text?>
								<? if(!empty($item_text_bonus)): ?>
								<div class="hidden-text">
									<?=$item_text_bonus?>
								</div>
								<p class="hidden-text-link"><a href="javascript:void(0)" class="onPage">Подробнее</a></p>
								<? endif; ?>
							</div>
						</div>
						<div class="list-page-services">
							<div class="list-description clearfix">
								<? //print_r($item->params); ?>
								<table>
									<? foreach($item->params as $code => $value): ?>
									<? //foreach(array('release_date','currency','limit','card_type','validity','cost') as $code): ?>
										<? if(isset($item->params[$code]) && is_array($item->params[$code]) && ($item->params[$code]['id']!=21) && in_array($item->params[$code]['data_type_id'],array(1,5,6))): ?>
										<tr>
											<td><?=$item->params[$code]['title']?></td>
											<td>
												<? if(isset($item->params[$code]['value']) && is_array($item->params[$code]['value']) && count($item->params[$code]['value'])): ?>
													<strong>
														<?
														$i = 0;
														$count = count($item->params[$code]['value']);
														foreach($item->params[$code]['value'] as $value){
															$i++;
															echo $value['title'];
															if($i<$count) echo '<br>';
														}
														?>
													</strong>
												<? elseif(isset($item->params[$code]['value']) && !is_array($item->params[$code]['value'])): ?>
													<strong><?=$item->params[$code]['value']?></strong>
												<? else: ?>
													&mdash;
												<? endif; ?>
											</td>
										</tr>
										<? endif; ?>
									<? endforeach; ?>

									<?
									$param = ModuleList3Params::model()->getItem(21);
									if($param->data_type_id==6):
									?>
											<?
											$params_values = ModuleList3ParamsValues::model()->getList($param->id);
											foreach($params_values as $key => $value):
													$exist_params_values = ModuleList3Values::model()->exist_value($item->id, $param->id, $value->id);
											?>
												<tr>
													<td><?=$value->title?></td>
													<td>
														<? if($exist_params_values): ?>
															<i class="icon icon-positive"></i>
														<? else: ?>
															<i class="icon icon-negative"></i>
														<? endif; ?>
													</td>
												</tr>
											<? endforeach; ?>
									<? endif; ?>
								</table>
								<? if(isset($item->params['benefits']) && is_array($item->params['benefits']) && isset($item->params['benefits']['value']) && !is_array($item->params['benefits']['value']) && !empty($item->params['benefits']['value'])): ?>
									<div class="list-advantages">
										<h2><?=$item->params['benefits']['title']?></h2>
										<?=$item->params['benefits']['value']?>
									</div>
								<? endif; ?>
								<!--<a href="#" class="btn btn-abs card-order">Заказать карту</a>-->

                        <? if($item->params['kredit_card']['value'] == 1):?>
                                    <button class="btn btn-abs card-order offerCardForm" data-id="<?=$item->id?>">Оформить карту</button>
                        <? endif;?>
									<?//зарплатные карты?>
									<? if($item->id == 28|| $item->id == 16):?>
	                                    <span class="card-order text">Карту можно оформить<br /> только при заключении<br /> работодателем <br />зарплатного проекта</span>
									<?//Убрать кнопку "Оформить карту" ТОЛЬКО из раздела моментальной карты?>
                                    <? endif;?>


							</div><!-- .list-description -->
							<div class="back">
								<a href="<?=$pages->make_url($doc_id_last)?>" class="prev">Перейти к списку карт</a>
							</div>
							<div class="list-bottom clearfix">
								<h2 class="headline">Как получить карту</h2>
                                <?
                                    if(in_array($item->id, array(4,5,6))):
                                ?>
								<p>Вы&nbsp;можете заказать карту прямо с&nbsp;сайта, подав <a href="javascript:void(0)" class="onPage offerCardForm" data-id="<?=$item->id?>">онлайн заявку</a>, либо <a href="/about/contacts/">в&nbsp;офисе Банка</a>, а&nbsp;также в&nbsp;любом из&nbsp;<a href="/about/locate/#cols">центров оперативного кредитования</a></p>
                                <? else: ?>
                                        <p>Вы&nbsp;можете заказать карту <a href="/about/contacts/">в&nbsp;офисе банка</a>, а&nbsp;также в&nbsp;любом из&nbsp;<a href="/about/locate/#cols">центров оперативного кредитования</a></p>
                                <?endif;?>
								<p>
									<a href="/personal/cards/howto/" class="btn">Подробнее</a>
								</p>
								<img class="list-bottom-bg" src="/pics/bg/list/cards.png">
							</div>
						</div><!-- .list-page-services -->

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
	include 'inc/popup.php';
?>