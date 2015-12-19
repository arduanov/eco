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
				<?//=$breadcrumbs?>
			</div>
			<h1 class="headline"><?=$title?></h1>
			<?
				$aside_fixed_class = 'aside-fixed';
				include 'inc/aside.php';
			?>
			<div class="page-content fixed-aside">
				<div class="pad-content">
					<?
					$quotes_mapge_id = ModulesInPages::model()->getLink(1, 'quotes');
					$quotes_1 = ModuleQuotes::model()->getList($quotes_mapge_id,0,1,1);
					foreach($quotes_1 as $value) $quotes_1 = $value;
					$quotes_2 = ModuleQuotes::model()->getList($quotes_mapge_id,1,1,1);
					foreach($quotes_2 as $value) $quotes_2 = $value;
					if(count($quotes_2)==0) $quotes_2 = $quotes_1;
					if(count($quotes_1)>0):
					?>
						<div class="filter exchange-filter">
							<div class="filter-pad clearfix">
								<div class="slider-rows clearfix">
									<h3 class="headline">Выберите операцию, сумму и&nbsp;валюту</h3>
									<div class="slider first clearfix">
										<select name="exchange[operation]">
											<option value="buy">Купить</option>
											<option value="sell">Продать</option>
										</select>
									</div>
									<div class="slider input clearfix">
										<select name="exchange[currency]">
											<option value="usd">долларов</option>
											<option value="eur">евро</option>
										</select>
										<div class="inpC">
											<input class="inp" id="summ" name="transfer[summ]" value="200" data-buy-usd="<?=$quotes_1->usd_purchase?>" data-sell-usd="<?=$quotes_1->usd_selling?>" data-buy-eur="<?=$quotes_1->eur_purchase?>" data-sell-eur="<?=$quotes_1->eur_selling?>">
											<div class="slider-input"></div>
										</div>
									</div>
									<h2 style="margin:20px 0 0;" id="result"></h2>
								</div>
							</div><!-- .filter-pad -->
						</div><!-- .filter .card-filter -->
						<p><strong>Внимание!</strong> Для операции обмена валют Вам потребуется предъявить паспорт.</p>
						<h2>Курсы валют сегодня</h2>
						<table>
							<tr>
								<th></th>
								<th>Покупка</th>
								<th>Продажа</th>
							</tr>
							<tr>
								<td><strong>Доллары США</strong></td>
								<td><?=$quotes_1->usd_purchase?> р. <i class="<?=($quotes_1->usd_purchase>$quotes_2->usd_purchase)?'up':''?> <?=($quotes_1->usd_purchase<$quotes_2->usd_purchase)?'down':''?>"></i></td>
								<td><?=$quotes_1->usd_selling?> р. <i class="<?=($quotes_1->usd_selling>$quotes_2->usd_selling)?'up':''?> <?=($quotes_1->usd_selling<$quotes_2->usd_selling)?'down':''?>"></i></td>
							</tr>
							<tr>
								<td><strong>Евро</strong></td>
								<td><?=$quotes_1->eur_purchase?> р. <i class="<?=($quotes_1->eur_purchase>$quotes_2->eur_purchase)?'up':''?> <?=($quotes_1->eur_purchase<$quotes_2->eur_purchase)?'down':''?>"></i></td>
								<td><?=$quotes_1->eur_selling?> р. <i class="<?=($quotes_1->eur_selling>$quotes_2->eur_selling)?'up':''?> <?=($quotes_1->eur_selling<$quotes_2->eur_selling)?'down':''?>"></i></td>
							</tr>
						</table>
					<? endif; ?>
					<h2>История изменений курса валют, установленных Банком</h2>

					<?
					$quotes_mapge_id = ModulesInPages::model()->getLink(1, 'quotes');
					$quotes_by_id = ModuleQuotes::model()->getList($quotes_mapge_id,0,31,1);
					$quotes = array();
					foreach($quotes_by_id as $value) $quotes[] = $value;
					$count = count($quotes);
					if($count==31) $count = 30;
					if(count($quotes)>0):
					?>
						<table>
							<tr>
								<th></th>
								<th>Покупка, $</th>
								<th>Продажа, $</th>
								<th>Покупка, &euro;</th>
								<th>Продажа, &euro;</th>
							</tr>
							<? for($i = 0; $i<$count; $i++): ?>
								<tr>
									<td><?=Yii::app()->dateFormatter->format('dd.MM.yyyy', $quotes[$i]->date)?></td>
									<td><?=$quotes[$i]->usd_purchase?> руб. <i class="<?=(isset($quotes[$i+1]) && $quotes[$i]->usd_purchase>$quotes[$i+1]->usd_purchase)?'up':''?> <?=($quotes[$i]->usd_purchase<$quotes[$i+1]->usd_purchase)?'down':''?>"></i></i></td>
									<td><?=$quotes[$i]->usd_selling?> руб. <i class="<?=(isset($quotes[$i+1]) && $quotes[$i]->usd_selling>$quotes[$i+1]->usd_selling)?'up':''?> <?=($quotes[$i]->usd_selling<$quotes[$i+1]->usd_selling)?'down':''?>"></i></i></td>
									<td><?=$quotes[$i]->eur_purchase?> руб. <i class="<?=(isset($quotes[$i+1]) && $quotes[$i]->eur_purchase>$quotes[$i+1]->eur_purchase)?'up':''?> <?=($quotes[$i]->eur_purchase<$quotes[$i+1]->eur_purchase)?'down':''?>"></i></i></td>
									<td><?=$quotes[$i]->eur_selling?> руб. <i class="<?=(isset($quotes[$i+1]) && $quotes[$i]->eur_selling>$quotes[$i+1]->eur_selling)?'up':''?> <?=($quotes[$i]->eur_selling<$quotes[$i+1]->eur_selling)?'down':''?>"></i></i></td>
								</tr>
							<? endfor; ?>
						</table>
					<? endif; ?>
					<?=$pages->set_url($content)?>
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