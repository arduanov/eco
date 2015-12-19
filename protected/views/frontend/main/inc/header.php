
	<?
    /**
     * @return Menu
     */
    $menu = $this->widget('application.components.frontend.menu.Menu');
    ?>

	<img src="/pics/i/logo.png" width="264" height="57" alt="Экопромбанк" class="print-logo">
	<header class="page-header"><!-- dark-shadow-->
	<div class="company-info clearfix">
	<?if($code != 'index'):?>
		<a href="/"><img src="/pics/i/logo.png" alt="Экопромбанк" class="company-logo" width="264" height="57"></a>
	<?else:?>
		<img src="/pics/i/logo.png" alt="Экопромбанк" class="company-logo" width="264" height="57">
	<?endif;?>
	<!-- 
      <div class="column header-contacts">
		<h6><i class="icon icon-phone"></i>8&nbsp;800&nbsp;200&nbsp;79&nbsp;77</h6>
		Круглосуточный контакт-центр<br>
		<a href="/about/contacts/#worktime">Часы работы</a> <a href="/about/locate/#atms">Банкоматы и терминалы</a>
	</div>
-->
	</div><!-- .company-info -->
	<hr class="divider-strong">
	<div class="header-navigation clearfix">
	<nav class="menu-top-level" id="MainMenu">
		<?=$menu->getmenu('first',$url_for_menu,$tree,0,1,0,4);?>
	</nav><!-- .menu-top-level -->
      <!-- 
	<form class="search-form" action="/search/" method="GET">
		<label for="HeaderSearchString">Поиск по сайту</label>
		<input type="search" autocomplete="off" name="searchString" id="HeaderSearchString">
		<button type="submit" class="search-submit">Поиск<i class="icon icon-search"></i></button>
	</form>
-->
	</div><!-- .header-navigation -->
	</header><!-- .page-header -->
	<div class="float-menu" id="FloatMenu">
	<? $col_count = 4; ?>
	<? foreach($tree as $key => $value): ?>
		<nav class="float-menu-container clearfix" data-rel="<?=$key?>">
			
			<?
			$count = count($value['child']);
			$limit = floor($count/$col_count);
			$count_of_more = $count-$limit*$col_count;
			$offset = 0;
			for($i=0; $i<$col_count; $i++):
				$new_limit = $limit;
				if($count_of_more>$i) $new_limit++;
			?>
			<div class="col <?=($i==0)?'first':''?>">
				<?=(count($value['child'])>$i)?$menu->getmenu('first',$url_for_menu,$tree,$key,1,$offset,$new_limit):''?>
			</div>
			<?
				$offset += $new_limit;
			endfor;
			?>
		</nav>
	<? endforeach; ?>
	<div class="bg"></div>
	</div><!-- .float-menu -->