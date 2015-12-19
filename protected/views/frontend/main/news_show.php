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
			<h1 class="headline"><?=$page_title?></h1>
			<div class="page-content">
				<div class="pad-content">
					<div class="lenta-body cf">
						<h2 class="headline"><?=$lenta->title?></h2>
						<?=$pages->set_url($lenta->text)?>
						<? if(count($lenta->img)): ?>
							<img class="image-left" src="<?=$lenta->img[2]?>" alt="<?=$lenta->title?>">
						<? endif;?>
					</div>
					<div class="back">
						<?
						$href_sufix = '';
						if(isset($_GET['p']) && (int)$_GET['p']) $href_sufix .= 'page_'.(int)$_GET['p'].'/';
						if(isset($_GET['y']) && (int)$_GET['y']) $href_sufix .= '?y='.(int)$_GET['y'];
						?>
						<a href="<?=$pages->make_url($doc_id_last)?><?=$href_sufix?>" class="prev">Перейти к списку новостей</a>
					</div>
					<? if(count($lastNews)): ?>
						<h3>Еще новости</h3>
						<div class="additional-news">
							<?
							$i = 0;
							$news_count = count($lastNews);
							foreach($lastNews as $news):
								$i++;
							?>
								<div class="lenta-item <?=($i==$news_count)?' last':''?>">
									<p class="date"><?=Yii::app()->dateFormatter->format('dd MMMM yyyy', $news->date);?></p>
									<h3><a href="<?=$pages->make_url($doc_id_last)?>show_<?=$news->id?>/"><?=$news->title?></a></h3>
									<p><?=nl2br($news->short)?></p>
								</div>
							<? endforeach;?>
						</div>
					<? endif; ?>
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