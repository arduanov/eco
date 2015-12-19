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
				<?=$breadcrumbs?> &mdash; <?=$item->title?>
			</div>
			<h1 class="headline"><?=$title_original?> <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
			<div class="page-content">
				<div class="pad-content">
                    <h2 class="headline"><?=$item->title?></h2>
					<?=$pages->set_url($item->text)?>
					<div class="back">
						<a href="<?=$pages->make_url($doc_id_last)?>" class="prev">Перейти к списку услуг</a>
					</div>
                    <hr>
					<?=$pages->set_url($short)?>
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