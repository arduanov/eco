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
					<? if(!empty($year_pagination) && $records_on_page>0): ?>
						<nav class="section-navigator">
							<?=$year_pagination?>
						</nav>
					<? endif; ?>
					<?
					$date = '';
					$list_count = count($list);
					$i = 0;
					$j = 0;
                    ?>


                    <?
                    if($records_on_page==0){
                        ?><?=$pages->set_url($content)?><?
                    }
                    ?>


                    <?
					foreach($list as $file):
						$i++;
						$j++;
						if($group_of_files==0){
							if($date!=Yii::app()->dateFormatter->format('yyyy-MM-dd', $file->date) && $records_on_page>0){
								$date = Yii::app()->dateFormatter->format('yyyy-MM-dd', $file->date);
								if($i>1 && $table_of_files!=0) echo '</tbody></table>';
								echo '<h3>',Yii::app()->dateFormatter->format('d MMMM yyyy', $file->date),'</h3>';
								if($table_of_files!=0) echo '
										<table class="discount-table">
											<thead>
												<tr><th style="width: 30px;">№</th><th style="width: 105px;">Дата</th><th>Файл</th></tr>
											</thead>
											<tbody>';
								$j = 1;
							}
						}else{
							if(!is_null($file->group_id)) $group_title = $file->group->title;
								else $group_title = 'Без группы';
							if($date!=$group_title && $records_on_page>0){
								$date = $group_title;
								if($i>1 && $table_of_files!=0) echo '</tbody></table>';
								echo '<h3>',$date,'</h3>';
								if($table_of_files!=0) echo '
										<table class="discount-table">
											<thead>
												<tr><th style="width: 30px;">№</th><th style="width: 105px;">Дата</th><th>Файл</th></tr>
											</thead>
											<tbody>';
								$j = 1;
							}
						}
						if($table_of_files==0):
					?>
						<a href="<?=$file->link?>" class="file"><?=$file->title?></a>
						<? else: ?>
							<tr>
								<td><?=$j?></td>
								<td><nobr><?=Yii::app()->dateFormatter->format('d MMMM yyyy', $file->date)?></nobr></td>
								<td>
									<a href="<?=$file->link?>" class="file"><?=$file->title?></a>
									<? if(!empty($file->text)): ?>
										<p style="padding-left: 44px;"><?=str_replace("\n\r",'<br>',$file->text)?></p>
									<? endif; ?>
								</td>
							</tr>
						<? endif; ?>
					<? endforeach; ?>
					<?=($table_of_files==0)?'':'</tbody></table>'?>
					<? if(!empty($pagination) && $records_on_page>0):?>
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