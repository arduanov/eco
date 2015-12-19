<? include_once 'inc/meta.php'; ?>

<body>
<div id="container"><div class="pad">

	<? include_once 'inc/header.php'; ?>

	<div id="main" role="main" class="cf">
		<h1><?=$title?></h1>
		<div id="constructor">
			<dl class="constructorBody">
				<!-- Шаг 1 -->
				<dt class="step1 active">
					<div>
						<span class="wrap">
							1. Кого и во&nbsp;что одеваем?<br>
							<a href="javascript:void(0)" class="onPage hidden cclothtype"><span>Футболка для девочки</span></a>
						</span>
						<span class="iefix">&nbsp;</span>
					</div>
				</dt>
				<dd class="step1 active">
					<div class="pad">
						<h2>Кого и во что одеваем? <a href="javascript:void(0);" class="onPage active genderSelector" data-cgender="boy"><span>Мальчика</span><span class="tri"></span></a> <a href="javascript:void(0);" class="onPage genderSelector" data-cgender="girl"><span>Девочку</span><span class="tri"></span></a></h2>
						<div class="clothList active" data-cgender="boy">
							<div class="ovf">
								<?
								$wear2 = ModuleCatalogWear::model()->getList(2,0,0);
								foreach($wear2 as $b_id=>$b):
									if(!in_array($b_id,array(4,2))):
								?>
								<div class="clothItem">
									<a href="javascript:void(0)" data-cclothtype="<?=$b_id?>" data-cclothgender="boy">
										<span class="img">
											<img src="<?=$b->img[0]?>" alt="<?=$b->title?>">
										</span>
										<span class="txt">
											<?=$b->title?>
										</span>
                                        <span class="description hidden"><?=$b->description?></span>
									</a>
								</div>
									<? endif; ?>
								<? endforeach; ?>
							</div>
						</div><!-- clothList -->

						<div class="clothList" data-cgender="girl">
							<div class="ovf">
								<?
								$wear1 = ModuleCatalogWear::model()->getList(1,0,0);
								foreach($wear1 as $g_id=>$g):
									if(!in_array($g_id,array(12,3,1))):
								?>
								<div class="clothItem">
									<a href="javascript:void(0)" data-cclothtype="<?=$g_id?>" data-cclothgender="girl">
										<span class="img">
											<img src="<?=$g->img[0]?>" alt="<?=$g->title?>">
										</span>
										<span class="txt">
											<?=$g->title?>
										</span>
                                        <span class="description hidden"><?=$b->description?></span>
									</a>
								</div>
									<? endif; ?>
								<? endforeach; ?>
							</div>
						</div><!-- clothList -->

						<?/*<div class="loading"><img src="/pics/i/loading.gif"></div>*/?>
					</div>
					<?/*<a href="javascript:void(0)" class="onPage allClothes"><span class="bg"><span>Все категории товаров</span></span></a>*/?>
				</dd><!-- Шаг 1 -->

				<!-- Шаг 2 -->
				<dt class="step2 inactive">
					<div>
						<span class="wrap">
							2. Выбор размера<br>
							<a href="javascript:void(0)" class="onPage hidden"><span></span></a>
						</span>
						<span class="iefix">&nbsp;</span>
					</div>
				</dt>
				<dd class="step2">
					<div class="pad">
						<h2>Выберите размер</h2>
						<div class="sizeList">
							<div class="size size1 inactive">
								<a href="javascript:void(0)" class="sizeLink" data-csize="1"><span class="digits">12-18</span><br><span class="legend">месяцев</span></a>
								<div class="sizes">
									<table>
										<tr>
											<th>Рост</th>
											<td>80-86 см</td>
										</tr>
										<tr>
											<th>Обхват груди</th>
											<td>49-51 см</td>
										</tr>
										<tr>
											<th>Обхват талии</th>
											<td>50-51 см</td>
										</tr>
										<tr>
											<th>Обхват бедер</th>
											<td>52-54 см</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="size size2">
								<a href="javascript:void(0)" class="sizeLink" data-csize="2"><span class="digits">18-24</span><br><span class="legend">месяцев</span></a>
								<div class="sizes">
									<table>
										<tr>
											<th>Рост</th>
											<td>86-92 см</td>
										</tr>
										<tr>
											<th>Обхват груди</th>
											<td>51-53 см</td>
										</tr>
										<tr>
											<th>Обхват талии</th>
											<td>51-52 см</td>
										</tr>
										<tr>
											<th>Обхват бедер</th>
											<td>54-56 см</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="size size3">
								<a href="javascript:void(0)" class="sizeLink" data-csize="3"><span class="digits">2-3</span><br><span class="legend">года</span></a>
								<div class="sizes">
									<table>
										<tr>
											<th>Рост</th>
											<td>92-98 см</td>
										</tr>
										<tr>
											<th>Обхват груди</th>
											<td>53-55 см</td>
										</tr>
										<tr>
											<th>Обхват талии</th>
											<td>52-53 см</td>
										</tr>
										<tr>
											<th>Обхват бедер</th>
											<td>56-58 см</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="size size4">
								<a href="javascript:void(0)" class="sizeLink" data-csize="4"><span class="digits">3-4</span><br><span class="legend">года</span></a>
								<div class="sizes">
									<table>
										<tr>
											<th>Рост</th>
											<td>98-104 см</td>
										</tr>
										<tr>
											<th>Обхват груди</th>
											<td>55-57 см</td>
										</tr>
										<tr>
											<th>Обхват талии</th>
											<td>53-54 см</td>
										</tr>
										<tr>
											<th>Обхват бедер</th>
											<td>58-60 см</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div class="loading">
							<img src="/pics/i/loading.gif" alt="Загружаю данные с сервера">
						</div>
					</div>
				</dd><!-- Шаг 2 -->

				<!-- Шаг 3 -->
				<dt class="step3 inactive">
					<div>
						<span class="wrap">
							3. Тема апликации<br>
							<a href="javascript:void(0)" class="onPage hidden"><span></span></a>
						</span>
						<span class="iefix">&nbsp;</span>
					</div>
				</dt>
				<dd class="step3">
					<div class="pad">
						<h2>Выберите тему аппликации</h2>
						<p>В нашем конструкторе более 500 иллюстраций. Для удобства выбора они разделены на категории (темы).</p>
						<div class="appList">
							<div class="ovf">
								<?
								$app_category2 = ModuleCatalogAppCategory::model()->getList(2);
								foreach($app_category2 as $ac_id=>$ac):
								?>
								<div class="appItem boy">
									<a href="javascript:void(0)" data-capptype="<?=$ac_id?>">
										<span class="img">
											<img src="<?=$ac->img[0]?>" alt="<?=$ac->title?>">
										</span>
										<span class="title"><?=$ac->title?></span>
										<span class="small"></span>
									</a>
								</div>
								<? endforeach; ?>
								<?
								$app_category1 = ModuleCatalogAppCategory::model()->getList(1);
								foreach($app_category1 as $ac_id=>$ac):
								?>
								<div class="appItem girl">
									<a href="javascript:void(0)" data-capptype="<?=$ac_id?>">
										<span class="img">
											<img src="<?=$ac->img[0]?>" alt="<?=$ac->title?>">
										</span>
										<span class="title"><?=$ac->title?></span>
										<span class="small"></span>
									</a>
								</div>
								<? endforeach; ?>
							</div>
						</div>
					</div>
				</dd><!-- Шаг 3 -->

				<!-- Шаг 4 -->
				<dt class="step4 inactive">
					<div>
						<span class="wrap">
							4. Место для апликации
						</span>
						<span class="iefix">&nbsp;</span>
					</div>
				</dt>
				<dd class="step4">
					<div class="pad" style="padding-bottom:10px;">
						<h2>Выберите место для аппликации</h2>
					</div>
					<!--p class="help">Перетащите понравившуюся аппликацию на одно из возможных мест на базовой модели, модель можно перевернуть</p-->
					<div class="pad" style="padding-top:0;">
						<div class="constructor cf">
							<div class="lside">
								<h3>Базовая модель</h3>
								<div class="workarea">
									<div class="sideSelector" style="display:none;">
										<a href="javascript:void(0)" class="onPage front active"><span>Лицевая сторона</span><span class="tri"></span></a>
										<a href="javascript:void(0)" class="onPage back"><span>Задняя сторона</span><span class="tri"></span></a>
									</div>
									<div class="workareaImage">
										<img src="" alt="" id="workareaImageFront">
										<img src="" alt="" id="workareaImageBack">
										<div class="remove"></div>
									</div>
									<div class="loading">
								 		<img src="/pics/i/loading.gif" alt="Подождите, я строю список элементов">
								 	</div>
								</div>
								<div class="colorPicker">
									<div class="ovf">
									 	<!-- Список вариантов одежды -->
									 	<div class="loading">
									 		<img src="/pics/i/loading2.gif" alt="Подождите, я строю список элементов">
									 	</div>
									</div>
								</div>
							</div>
							<div class="rside">
								<h3>Аппликации <a href="javascript:void(0)" class="onPage appTypeChange"><span></span></a></h3>
								<div class="appPicker">
									<div class="ovf">
										<!-- Список аппликаций -->
									 	<div class="loading">
									 		<img src="/pics/i/loading.gif" alt="Подождите, я строю список элементов">
									 	</div>
									</div>
								</div>
								<div class="orderBlock" style="display:none;">
									<div class="pad">
										<p>Стоимость решения <span class="totalPrice">0</span> руб.</p>
										<a href="javascript:void(0)" class="btnBig orderLink cf"><span class="r"></span><span class="l">Оформить заказ</span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</dd><!-- Шаг 4 -->
			</dl>
			<div class="no-js"><p>Для работы конструктора, необходимо <a  rel="nofollow"  href="http://www.enable-javascript.com/ru/" target="_blank">включить поддержку JavaScript</a> в&nbsp;вашем браузере и&nbsp;перезагрузить страницу!</p></div>
		</div>
	</div>
    <?php include('inc/footer.php'); ?>
</div></div>
<?php include('inc/constructor_popup.php'); ?>
<?php include("inc/common_popup.php");?>