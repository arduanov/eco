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
			<?
				$aside_fixed_class = 'aside-fixed';
				include 'inc/aside.php';
			?>
			<div class="page-content fixed-aside">
				<div class="pad-content">
					<h3>Выберите срок аренды и&nbsp;габариты</h3>
					<table class="safe-table">
						<thead>
                        <tr >
                            <td colspan="6" class="checbuy">
                                <input type="checkbox" name="checbuy" id="checbuy"> Аренда сейфа для осуществления расчетов по сделкам купли-продажи
                            </td>
                        </tr>
							<tr class="safes">
								<td>

									Срок аренды, дней:<br>
									<div class="slider clearfix">
										<div class="inpC">
											<input type="tel" class="inp" name="creditSumm" value="31">
											<div class="slider-input"></div>
										</div>
									</div>
								</td>
								<td data-rel="1" data-hint="30.5 x 7.4 x 60" class="safe active"><img src="/pics/i/safe/1.png" alt="30.5x7.4x60"></td>
								<td data-rel="2" data-hint="30.5 x 12.6 x 60" class="safe"><img src="/pics/i/safe/2.png" alt="30.5x12.6x60"></td>
								<td data-rel="3" data-hint="30.5 x 25.6 x 60" class="safe"><img src="/pics/i/safe/3.png" alt="30.5x25.6x60"></td>
								<td data-rel="4" data-hint="30.5 x 39 x 60" class="safe"><img src="/pics/i/safe/4.png" alt="30.5x39x60"></td>
								<td data-rel="5" data-hint="30.5 x 52.5 x 60" class="safe"><img src="/pics/i/safe/5.png" alt="30.5x52.5x60"></td>
							</tr>
							<tr class="summary">
								<td colspan="6">Стоимость аренды сейфа на <span class="days">31</span> <span class="label">день</span> = <span class="summ">842 руб.</span></td>
							</tr>
						</thead>
						<tbody>
							<tr data-min="1" data-max="30">
								<td><strong>до 30 дней</td>
								<td class="line" data-rel="1">330 руб.</td>
								<td data-rel="2">360 руб.</td>
								<td data-rel="3">390 руб.</td>
								<td data-rel="4">450 руб.</td>
								<td data-rel="5">540 руб.</td>
							</tr>
							<tr data-min="31" data-max="90">
								<td><strong>от&nbsp;31 до&nbsp;90 дней</strong></td>
								<td class="line current" data-rel="1">842 руб.</td>
								<td data-rel="2">918 руб.</td>
								<td data-rel="3">995 руб.</td>
								<td data-rel="4">1148 руб.</td>
								<td data-rel="5">1377 руб.</td>
							</tr>
							<tr data-min="91" data-max="180">
								<td><strong>от&nbsp;91 до&nbsp;180 дней</strong></td>
								<td class="line" data-rel="1">1485 руб.</td>
								<td data-rel="2">1620 руб.</td>
								<td data-rel="3">1755 руб.</td>
								<td data-rel="4">2025 руб.</td>
								<td data-rel="5">2430 руб.</td>
							</tr>
							<tr data-min="181" data-max="270">
								<td><strong>от&nbsp;181 до&nbsp;270 дней</strong></td>
								<td class="line" data-rel="1">1931 руб.</td>
								<td data-rel="2">2106 руб.</td>
								<td data-rel="3">2282 руб.</td>
								<td data-rel="4">2633 руб.</td>
								<td data-rel="5">3159 руб.</td>
							</tr>
							<tr data-min="271" data-max="360">
								<td><strong>от&nbsp;271 до&nbsp;360 дней</strong></td>
								<td class="line" data-rel="1">2208 руб.</td>
								<td data-rel="2">2409 руб.</td>
								<td data-rel="3">2610 руб.</td>
								<td data-rel="4">3011 руб.</td>
								<td data-rel="5">3614 руб.</td>
							</tr>
						</tbody>
					</table>
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