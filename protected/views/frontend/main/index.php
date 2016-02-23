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
			<div class="visual">
				<div class="visual-content clearfix">
					<div class="visual-control-left"><a href="javascript:void(0)" class="visual-left">
						<img src="/pics/i/page_prev.png" width="23" alt="Предыдущий">
					</a></div>
					<div class="visual-control-right"><a href="javascript:void(0)" class="visual-right">
						<img src="/pics/i/page_next.png" width="23" alt="Следующий">
					</a></div>
					<div class="ovf">
						<?
						$banner = new ModuleBanner();
						$banner = $banner->getActiveList();
                        $keys = array();
                        $i = 2;
                        foreach ($banner as $b_id=>$b) {
                            $keys[$b->id] = $i;
							if($b->id==1) $keys[$b->id] = 1;
								else $i++;
                        }
                        // shuffle($banner);
                        $i = 0;
                        foreach($banner as $b_id=>$b):
							$i++;
						?>
							<div class="visual-page page<?=$keys[$b->id]?>" data-page="<?=$i?>">
								<div class="vtext">
									<div class="tcont">
										<h2><?=$b->title?></h2>
                                        <?=$b->text?>
										<a class="btn btn-abs" href="<?=$pages->set_url($b->link)?>"><i></i>Подробнее</a>
									</div>
								</div>
								<img src="<?=$b->img[0]?>" alt="<?=strip_tags($b->title)?>" class="visualImg">
							</div>
						<?endforeach;?>
					</div>
				</div><!-- .visual-content-->
				<nav class="visual-controls clearfix">
					<?
					$i = 0;
					foreach($banner as $b_id=>$b):
						$i++;
					?>
						<a href="javascript:void(0)" data-page="<?=$i?>" class="<?=($i==1)?'active':''?>"></a>
					<?endforeach;?>
				</nav>
			</div><!-- .visual -->

			<div class="main-content-block">

				<div class="main-content clearfix">
<!--
					<div class="additional">
						<div class="pad">

							<h6><i class="icon icon-phone"></i><?=$additional_main_data['main_phone']?></h6>
							<span class="rem">Круглосуточный контакт-центр</span>
						</div>
					</div>
-->
					<div class="lenta">

                        <?
                        $i=0;
                        if(count($news_common_list)):
                            foreach($news_common_list as $news):
                            ?>
                            <div class="pad">
                                <?$i++?>
	                            <?=$i!==2?'':'[[[seo]]]'?>
                                <p class="date"><?=Yii::app()->dateFormatter->format('dd MMMM yyyy', $news->date);?></p>
                                <h3><a href="<?=$pages->make_url($news_common_doc_id)?>show_<?=$news->id?>/"><?=$news->title?></a></h3>
                                <p><?=nl2br($news->short)?></p><br>
                                <?if($i==count($news_common_list)):?><p><a href="<?=$pages->make_url($news_common_doc_id)?>">Все новости</a></p><?endif;?>
                            </div>
                            <?php
                            endforeach;
                        endif;
                        ?>
					</div>
				</div>
			</div>
		</div><!-- .page-layout -->
		<?
			include 'inc/footer.php';
		?>
	</div><!-- .page-container -->
</div><!-- .page-bg -->
<?
	include 'inc/popup.php';
?>