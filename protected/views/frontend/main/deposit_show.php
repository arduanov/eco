<? include 'inc/meta.php'; ?>

<body>
<div class="page-bg">
<? include 'inc/leafs.php' ?>
<div class="page-container">
<?
include 'inc/header.php';
?>
<div class="page-layout clearfix">
<div class="page-prev">
	<? if ($prev != false)
	{
		?>
		<a href="<?= $pages->make_url($doc_id_last) ?>show_<?= $prev['id'] ?>/" data-hint="<?= 'Вклад ' . $prev['title'] ?>"><img
				src="/pics/i/page_prev.png"></a>
	<? } ?>
</div>
<div class="page-next">
	<? if ($next != false)
	{
		?>
		<a href="<?= $pages->make_url($doc_id_last) ?>show_<?= $next['id'] ?>/" data-hint="<?= 'Вклад ' . $next['title'] ?>"><img
				src="/pics/i/page_next.png"></a>
	<? } ?>
</div>
<div class="breadcrumbs">
	<?= $breadcrumbs ?> &mdash; <?= $item->title ?>
</div>
<h1 class="headline withNav">Вклад&nbsp;<?= $item->title ?> <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>

<div class="page-content">
<div class="pad-content">
<div class="clearfix">
<div style="float:right; margin-left:1em; padding-top:1.6em;">
    <a  href="javascript:void(0)" class="btn js-vklad-order-trigger" data-name="<?= $item->title ?>">Оформить вклад</a>
</div>
<div class="list-intro clearfix" style="overflow:hidden; *zoom:1;">
	<? if (count($item->img)): ?>
		<img src="<?= $item->img[3] ?>" alt="<?= $item->title ?>" class="list-img">
	<? endif; ?>
	<div class="list-intro-text" style="position: relative">
		<?= $pages->set_url($item->text) ?>


	</div>
</div>
<div class="list-page-services">
<aside class="list-aside-services">
	<?
	if (isset($files))
	{
		foreach ($files as $file)
		{
			?>
			<p class="file">
				<a href="/<?= $file['ref'] ?>" class="file"><?= $file['short'] ?></a>
			</p>
		<?
		}
	}
	?>
</aside>
<div class="list-description rightCol clearfix">
<? //print_r($item->params); ?>
<table>
	<tr>
		<td>
			Процентная ставка по вкладу
		</td>
		<td>
			<?
			$percents = explode("\n", $item->params['percents_stavka']['value']);

			foreach ($item->params['currency']['value'] as $key => $value)
			{
				?>
				<strong><?= trim($percents[$key]) ?>&nbsp;<?= str_replace('Доллары', 'Доллары США', $value['title']) ?></strong><br>
			<? } ?>
		</td>
	</tr>
	<tr>
		<td>
			Минимальная сумма вклада
		</td>
		<td>
			<?
			foreach ($item->params['currency']['value'] as $value)
			{
				?><strong><?
				switch ($value['id'])
				{
					case 39:
						?>
						<?= $item->params['min_sum_rur']['value'] ?>&nbsp;Рублей
						<?
						break;
					case 40:
						?>
						<?= $item->params['min_sum_usd']['value'] ?>&nbsp;Долларов&nbsp;США
						<?
						break;
					case 41:
						?>
						<?= $item->params['min_sum_eur']['value'] ?>&nbsp;Евро
						<?
						break;
					default:
						break;
				}
				?></strong><br/><?
			}
			?>
		</td>
	</tr>
	<tr>
		<td>
			Срок вклада
		</td>
		<td>
			<strong><?= $item->params['period']['value'] ?></strong>
		</td>
	</tr>
	<tr>
		<td>
			Частичное снятие средств
		</td>
		<td>
			<strong><?= $item->params['deposit_take_off']['value'] ? 'Да' : 'Нет' ?></strong>
		</td>
	</tr>
	<tr>
		<td>
			Возможность закрыть вклад досрочно без потери процентов
		</td>
		<td>
			<strong><?= $item->params['deposit_close']['value'] ? 'Да' : 'Нет' ?></strong>
		</td>
	</tr>
	<tr>
		<td>
			Порядок выплаты процентов
		</td>
		<td>
			<strong><?= $item->params['percents_pay']['value'] ?></strong>
		</td>
	</tr>
	<?
	/*
	foreach($item->params as $code => $value): ?>
		<? if(($value['id']<28 || $value['id']>63) && $value['id']!=25 && $value['id']!=27 && $value['id']!=68): ?>
			<? if(isset($item->params[$code]) && is_array($item->params[$code]) && in_array($item->params[$code]['data_type_id'],array(1,5,6))): ?>
				<? if(isset($item->params[$code]['value']) && (is_array($item->params[$code]['value']) || !is_array($item->params[$code]['value'] && !empty($item->params[$code]['value'])))): ?>
				<tr>
					<td><?=$item->params[$code]['title']?></td>
					<td>
						<? if(is_array($item->params[$code]['value']) && count($item->params[$code]['value'])): ?>
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
						<? elseif(!is_array($item->params[$code]['value'])): ?>
							<strong><?=$item->params[$code]['value']?></strong>
						<? else: ?>
							&mdash;
						<? endif; ?>
					</td>
				</tr>
				<? endif; ?>
			<? endif; ?>
		<? endif; ?>
	<? endforeach; */
	?>

</table>
<h2>Процентные ставки</h2>
<table style="table-layout:fixed;">
	<?
	$table = array();
	$days = array();
	if (!isset($item->params['deposit_sum']))
	{
		foreach ($item->params as $key => $value)
		{
			$day = '';
			if (strpos($key, 'rur_') === 0 && $value['value'] != '')
			{
				$day                = substr($key, 4);
				$table['rur'][$day] = $value['value'];
			}
			else if (strpos($key, 'usd_') === 0 && $value['value'] != '')
			{
				$day                = substr($key, 4);
				$table['usd'][$day] = $value['value'];
			}
			else if (strpos($key, 'eur_') === 0 && $value['value'] != '')
			{
				$day                = substr($key, 4);
				$table['eur'][$day] = $value['value'];
			}
			if ($day != '' && !in_array($day, $days))
			{
				$days[] = $day;
			}
		}
	}
	else
	{
		foreach ($item->params as $key => $value)
		{
			$day = '';
			if (strpos($key, 'rur_') === 0 && $value['value'] != '')
			{
				$day                = substr($key, 4);
				$table['rur'][$day] = $value['value'];
			}
			else if (strpos($key, 'rur2_') === 0 && $value['value'] != '')
			{
				$day                 = substr($key, 5);
				$table['rur2'][$day] = $value['value'];
			}
			if ($day != '' && !in_array($day, $days))
			{
				$days[] = $day;
			}
		}
	}
	$keys = array_keys($table);
	?>
	<tr>
		<th style="width:120px;">Срок</th><?
		foreach ($keys as $value)
		{
			?>
			<th>
				<?
				if (!isset($item->params['deposit_sum']))
				{
					?>
					<?
					if (strtoupper($value) == 'RUR')
					{
						echo 'Рубли';
					}
					if (strtoupper($value) == 'USD')
					{
						echo 'Доллары США';
					}
					if (strtoupper($value) == 'EUR')
					{
						echo 'Евро';
					}
					?>
				<?
				}
				else
				{
					switch ($value)
					{
						case 'rur':
							?>
							При сумме вклада от&nbsp;5&nbsp;млн. до&nbsp;20&nbsp;млн.&nbsp;руб.
							<!--при сумме вклада до&nbsp;<?=$item->params['deposit_sum']['value']?>&nbsp;руб.-->
							<?
							break;
						case 'rur2':
							?>
							При сумме вклада свыше 20&nbsp;млн.&nbsp;руб.
							<!--при сумме вклада более&nbsp;<?=$item->params['deposit_sum']['value']?>&nbsp;руб.-->
							<?
							break;
					}

				}

				?>
			</th>
		<?
		}
		?></tr><?
	foreach ($days as $day)
	{
		?>
		<tr>
		<td><?= $day . $this->plural($day, " день", " дня", " дней") ?></td><?
		foreach ($keys as $value)
		{
			?>
			<td><?= $table[$value][$day] ?>%</td>
		<?
		}
		?></tr><?
	}
	?>

</table>
<? if (isset($item->params['benefits']) && is_array($item->params['benefits']) && isset($item->params['benefits']['value']) && !is_array($item->params['benefits']['value']) && !empty($item->params['benefits']['value'])): ?>
	<div class="list-advantages">
		<h2><?= $item->params['benefits']['title'] ?></h2>
		<?= $item->params['benefits']['value'] ?>
	</div>
<? endif; ?>
</div>
<!-- .list-description -->
<div class="back">
	<a href="<?= $pages->make_url($doc_id_last) ?>" class="prev">К списку вкладов</a>
</div>
<div class="list-bottom clearfix">
	<h2 class="headline">Оформление вклада</h2>

	<div style="width: 88%"><?=nl2br($short)?></div>

	<p>
		<a href="<?= $pages->make_url(38) ?>" class="btn">Подробнее</a>
	</p>
	<img class="list-bottom-bg" src="/pics/bg/list/deposit.png">
</div>
</div>
<!-- .list-page-services -->

</div>
</div>
<!-- .pad-content -->
</div>
<!-- .page-content -->
<?
include 'inc/aside.php';
?>
</div>
<!-- .page-layout -->
<?
include 'inc/footer.php';
?>
</div>
<!-- .page-container -->
</div>
<!-- .page-bg -->
<?
include 'inc/popup.php';
?>
