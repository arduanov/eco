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
			<h1 class="headline"><?=$title?></h1>
			<div class="page-content">
				<div class="pad-content    fff">
					<? if(!empty($year_pagination)): ?>
						<nav class="section-navigator">
							<?=$year_pagination?>
						</nav>
					<? endif; ?>
					<?
					$news_count = count($newsList);
					$i = 0;
					foreach($newsList as $news):
						$i++;
					?>
						<div class="lenta-item <?=($news_count==$i)?'last':''?>">
							<p class="date"><?=Yii::app()->dateFormatter->format('dd MMMM yyyy', $news->date)?></p>
							<h3><a href="<?=$pages->make_url($doc_id_last)?>show_<?=$news->id?>/"><?=$news->title?></a></h3>
							<p><?=nl2br($news->short)?></p>
						</div>
					<? endforeach; ?>
					<? if(!empty($pagination)):?>
						<div class="paging cf">
							<?=$pagination?>
						</div>
					<?endif;?>
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