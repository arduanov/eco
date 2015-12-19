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