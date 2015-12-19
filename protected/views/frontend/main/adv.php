<? include 'inc/meta.php'; ?>

<body>
<div id="container">
	<div class="pad">
		<? include 'inc/header.php'; ?>
		<div class="page cf">
			<section class="pageSelector">
				<?=$menu->getmenu('main|span',$url_for_menu,$tree,2,2);?>
			</section>
            <?
                if($doc_id == 15){
                    $spClass = ' lastPage';
                    $pClass = ' resumePage';
                    $cbClass = ' nobg';
                    $spStyle = 'style="height: 840px;"';
                    $pStyle = 'style="left: 0px; display: block;"';
                    $ppStyle = 'style="left: -100%;"';
                    $npStyle = 'style="left: -200%;"';
                }
            ?>
			<div class="scrollingPages <?=$spClass?>" <?=$spStyle?> role="main">
				<div class="pagesArrows">
					<a href="<?=$pages->make_url($doc_id_prev)?>" class="cleft"></a>
					<a href="<?=$pages->make_url($doc_id_next)?>" class="cright"></a>
				</div>
                <div class="page cf prevPage" <?=$ppStyle?>>
                    <div class="img">
                        <img src="/templates/pics/pages/2.jpg" alt="">
                    </div>
                    <div class="mainBlock">
                        <div class="pageHeader">

                        </div>
                    </div>
                </div>
				<div class="page cf curPage <?=$pClass?>" <?=$pStyle?>>
					<? if(count($page_images)): ?>
					<div class="img">
						<img src="<?=$page_images[0]?>" alt="<?=$longtitle?>">
					</div>
					<? endif; ?>
					<div class="mainBlock">
						<div class="pageHeader">
							<h1><?=$longtitle?></h1>
						</div>
						<?=$pages->set_url($content)?>
					</div>
				</div>
				<div class="page cf nextPage" <?=$npStyle?>>
					<div class="img">
						<img src="/templates/pics/pages/2.jpg" alt="">
					</div>
					<div class="mainBlock">
						<div class="pageHeader">

						</div>
					</div>
				</div>
			</div>
		</div>
	    <? include 'inc/commonblock2.php'; ?>
		<? include 'inc/footer.php'; ?>
	</div>
</div>

<script>
var adv_list = [
	<?
	$zpt = '';
	foreach($tree[$doc_id_top]['child'] as $t_id=>$t){
		$t_images = $pages->get_images($t_id);
	?>
		<?=$zpt?>{
		   id :<?=$t_id?>,
		   url :'/<?=$tree[$doc_id_top]['code']?>/<?=$t['code']?>/',
		   header :'<?=$t['name'].' — Хороший дом Подсолнух'?>',
		   title :'<?=$t['title']?>',
		   short:'<?=base64_encode($t['short'])?>',
		   text :'<?=base64_encode(str_replace('\'','\\\'',trim(str_replace("\n", '', $pages->getPageText($t_id)))))?>',
		   img :'<?=$t_images[0]?>'
	 }
		<?
		$zpt = ',';
	}
	?>
]
</script>