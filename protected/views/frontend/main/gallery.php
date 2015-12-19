<? include 'inc/meta.php'; ?>

<body>
<div id="container">
	<? include 'inc/header.php'; ?>
	<div class="page cf">
		<div class="pad contentPad cf">
			<div class="pageHeader">
				<h1><?=$title?></h1>
			</div>
			<?
			if(count($tree[$doc_id]['child'])){
				foreach($tree[$doc_id]['child'] as $t_id=>$t){
					$active_modules = Modules::model()->getActiveModule($t_id);
					if(count($t['child'])==0 && count($active_modules)==1 && array_key_exists(9,$active_modules)){
						$mpage_id = ModulesInPages::model()->getLink($t_id,'gallery');
						$gallery = ModuleGallery::model()->getListPhotos($mpage_id,1);
						if(count($gallery)){
			?>
			<h3><?=$t['title']?></h3>
				<section class="gallery">
					<div class="bigImage">
						<a href="javascript:void(0)" class="cLeft"><span class="arrow"></span></a>
						<a href="javascript:void(0)" class="cRight"><span class="arrow"></span></a>
						<div class="imgC">
							<?
							foreach($gallery as $g_id => $g){
								foreach($g->photos as $ph_id => $ph){
									echo '<img src="'.$ph->img[3].'" class="bI" />';
									break 2;
								}
							}?>
						</div>
					</div>
					<div class="galNavigation cf">
						<a href="javascript:void(0)" class="gLeft"><span></span></a>
						<a href="javascript:void(0)" class="gRight"><span></span></a>
						<nav class="photoNavigation">
							<ul>
								<?
								$i = 0;
								foreach($gallery as $g_id => $g){
									foreach($g->photos as $ph_id => $ph){
										$i++;
										echo '<li><a href="javascript:void(0)" data-rel="'.$i.'" data-src="'.$ph->img[3].'">';
										echo '<img src="'.$ph->img[2].'"><span class="bg"></span>';
										if($t_id != 26){
                                            echo '<span class="date"><strong>';
										    echo Yii::app()->dateFormatter->format('d', $g->date);
										    echo '</strong><br>';
										    echo Yii::app()->dateFormatter->format('MMMM<br>yyyy', $g->date),'</span>';
                                        }
										echo '</a></li>';

									}
								}?>
							</ul>
						</nav>
					</div>
					<div class="galSlide">
						<div class="slideContainer">
							<a href="javascript:void(0)" class="slider"></a>
						</div>
					</div>
					<a class="close" href="javascript:void(0)"></a>
				</section>

				<?
						}
					}else{
				?>
			   <h3><?=$t['title']?></h3>
				<nav class="galSelector">
					<ul>
						<? $active_class = 'active'; ?>
						<? foreach($t['child'] as $tch_id=>$tch): ?>
						<li><a href="javascript:void(0)" class="onPage <?=$active_class?>" data-gal="<?=$tch_id?>"><span><?=$tch['title']?></span></a></li>
							<? $active_class = ''; ?>
						<? endforeach; ?>
					</ul>
					<img class="rose2" src="/pics/i/rose2.png">
				</nav>
						<?
						$active_class = 'active';
						foreach($t['child'] as $tch_id=>$tch){
							$active_modules = Modules::model()->getActiveModule($tch_id);
							if(count($active_modules)==1 && array_key_exists(9,$active_modules)){
								$mpage_id = ModulesInPages::model()->getLink($tch_id,'gallery');
								$gallery = ModuleGallery::model()->getListPhotos($mpage_id,1);
								if(count($gallery)){
							?>
							<section class="gallery view <?=$active_class?>" data-gal="<?=$tch_id?>">
								<div class="bigImage">
									<a href="javascript:void(0)" class="cLeft"><span class="arrow"></span></a>
									<a href="javascript:void(0)" class="cRight"><span class="arrow"></span></a>
									<div class="imgC">
										<?
										foreach($gallery as $g_id => $g){
											foreach($g->photos as $ph_id => $ph){
												echo '<img src="'.$ph->img[3].'" class="bI" />';
												break 2;
											}
										}?>
									</div>
								</div>
								<div class="galNavigation cf">
									<a href="javascript:void(0)" class="gLeft"><span></span></a>
									<a href="javascript:void(0)" class="gRight"><span></span></a>
									<nav class="photoNavigation">
										<ul>
										<?
										$i = 0;
										foreach($gallery as $g_id => $g){
											foreach($g->photos as $ph_id => $ph){
												$i++;
												echo '<li><a href="javascript:void(0)" data-rel="'.$i.'" data-src="'.$ph->img[3].'">';
												echo '<img src="'.$ph->img[2].'"><span class="bg"></span></a></li>';
											}
										}
										?>
										</ul>
									</nav>
								</div>
								<div class="galSlide">
									<div class="slideContainer">
										<a href="javascript:void(0)" class="slider"></a>
									</div>
								</div>
								<a class="close" href="javascript:void(0)"></a>
							</section>
									<?
									$active_class = '';
								}
							}
						}
					}
				}
			}
			?>
		</div>
	</div>
	<? include 'inc/commonblock.php'; ?>
	<? include 'inc/footer.php'; ?>
</div>