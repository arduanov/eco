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
			<div class="page-content">
				<div class="pad-content">
					<div class="filter transfer-filter">
						<div class="filter-pad clearfix">
							<div class="slider-rows clearfix">
								<h3 class="headline">Укажите сумму, и выберите валюту перевода</h3>
								<div class="slider first clearfix">
									<select name="transfer[currency]">
										<option value="rur">Рубли</option>
										<option value="usd">Доллары</option>
										<option value="eur">Евро</option>
									</select>
										<div class="inpC">
										<input class="inp" id="summ" name="transfer[summ]" value="10000">
										<div class="slider-input"></div>
									</div>
								</div>
								<p>Ваша комиссия составит: <strong id="comission">160 руб.</strong></p>
							</div>
						</div><!-- .filter-pad -->
					</div><!-- .filter .card-filter -->
					<?=$pages->set_url($content)?>
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