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
				<div class="pad-content">
                    <?=$pages->set_url($content)?>
					<?
					$i = 0;
					$count_of_list3 = count($list3);
					foreach($list3 as $item):
						$i++;
					?>
						<a href="<?=$pages->make_url($doc_id_last)?>show_<?=$item['id']?>/" class="list-item <?=($i==$count_of_list3)?'last':''?> gradient clearfix">
							<? if(count($item['img'])): ?>
							<span class="list-img">
								<img src="<?=$item['img'][2]?>" alt="<?=$item->title?>">
							</span>
							<? endif; ?>
							<span class="list-text">
								<span class="headline"><?=$item->title?></span>
								<span class="description"><?=nl2br($item->short)?></span>

                                <? if(in_array($item->id, array(4,5,6))):?>
                                    <button class="btn btn-small offerCardForm" data-id="<?=$item->id?>">Оформить карту</button>
                                <? endif;?>

								<!--<button class="btn btn-small" data-href="#order-card-link/<?=$item['id']?>">Заказать карту </button>-->
							</span>
						</a>
					<? endforeach; ?>
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