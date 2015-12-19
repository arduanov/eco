<div class="page-aside <?= isset($aside_fixed_class) ? $aside_fixed_class : '' ?>">
	<div class="pad-aside">
		<?
		if ($doc_id_top != 0)
		{
			$sub_menu = $menu->getmenu('first', $url_for_menu, $tree, $doc_id_top);
			if (!empty($sub_menu))
			{
				?>
				<nav class="menu-third-level aside-leaf-block">
					<?= $sub_menu ?>

					[[[seo]]]
				</nav><!-- .menu-third-level -->
			<?
			}
		}
		?>
		<? if ($doc_id_last == 26): ?>
			<!--div class="aside-leaf-block" id="RegionTerminals">
				<div class="pad-aside">
					<a href="javascript:void(0)" class="onPage permRegBankomats">Банкоматы и&nbsp;терминалы в&nbsp;Пермском&nbsp;крае</a>
				</div>
			</div-->


		<? endif; ?>
		<? /* if($doc_id_last==103): ?>
				<div class="aside-leaf-block" id="RegionTerminals">
                    <div class="pad-aside">
                        <a href="javascript:void(0)" class="onPage permRegBankomats">Банкоматы и&nbsp;терминалы в&nbsp;Пермском&nbsp;крае</a>
                    </div>
                </div>
				<div class="filter filter-contacts">
					<div class="filter-pad clearfix">
                        <h3 class="headline addditional-headline geo-headline">Найти ближайший банкомат или терминал</h3>
                        <div class="geocoder">
                            <label for="GeocoderInput">По какому адресу вы находитесь?</label>
                            <div class="inpC">
                                <input type="text" name="contacts[geocoder]" id="GeocoderInput">
                            </div>
                            <button class="btn btn-small">Найти</button>
                        </div>
						<h3 class="headline">Что вам необходимо сделать?</h3>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="2_3_4"> Получить наличные</label>
							<div class="sub-row clearfix">
								<label><input name="contacts[getcashcurrency]" value="2" type="checkbox"> РУБ</label>
								<label><input name="contacts[getcashcurrency]" value="3" type="checkbox"> USD</label>
								<label><input name="contacts[getcashcurrency]" value="4" type="checkbox"> EUR</label>
							</div>
						</div>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="5_6_7"> Погасить кредит/пополнить карту</label>
							<div class="sub-row clearfix">
								<label><input name="contacts[rechargecard]" value="5" type="checkbox"> РУБ</label>
								<label><input name="contacts[rechargecard]" value="6" type="checkbox"> USD</label>
								<label><input name="contacts[rechargecard]" value="7" type="checkbox"> EUR</label>
							</div>
						</div>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="8_9_10"> Оплатить услуги с&nbsp;помощью карты</label>
							<div class="sub-row clearfix">
								<label><input name="contacts[payservices]" value="8" type="checkbox"> РУБ</label>
								<label><input name="contacts[payservices]" value="9" type="checkbox"> USD</label>
								<label><input name="contacts[payservices]" value="10" type="checkbox"> EUR</label>
							</div>
						</div>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="11_12_13"> Оплатить услуги наличными</label>
							<div class="sub-row clearfix">
								<label><input name="contacts[payservicescash]" value="11" type="checkbox"> РУБ</label>
								<label><input name="contacts[payservicescash]" value="12" type="checkbox"> USD</label>
								<label><input name="contacts[payservicescash]" value="13" type="checkbox"> EUR</label>
							</div>
						</div>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="14"> Сделать перевод между картами Экопромбанка</label>
						</div>
						<!--<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="15"> Пополнить счет без карты</label>
						</div>-->
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="16"> Подключить SMS-сервис</label>
						</div>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="17"> Изменить ПИН-код</label>
						</div>
						<h3 class="headline addditional-headline">Дополнительно</h3>
						<div class="row">
							<label><input type="checkbox" name="contacts[options]" value="18"> Круглосуточная работа</label>
						</div>
						<?/*<div class="row last">
							<label>
                                <input type="checkbox" name="contacts[options]" value="19"> Без комиссии *<br>
                                <small>* Операция без комиссии возможна, если это предусмотрено тарифом обслуживания Вашей карты</small>
                            </label>
						</div>*?>
						<? /*<div class="row last">
							<label><input type="checkbox" name="contacts[options]" value="20"> Операции с минимальной комиссией</label>
						</div>*?>
					</div>
					<div class="filter-reset">
						<a href="javascript:void(0)" class="onPage icon-link  js-filter-reset"><span>Сбросить настройки фильтра</span></a>
					</div>
				</div>
                
			<? endif; */
		?>

<!--		--><?// if ($doc_id_top == 2 && !in_array($doc_id_last, array(39, 40, 41, 42))): ?>
<!--			<a class="recharge-button aside-hotlink" href="/personal/cards/service/">Где погасить кредит&nbsp;/ пополнить карту&nbsp;/ счет?</a>-->
<!--		--><?// endif; ?>

		<div class="aside-contacts aside-leaf-block">
			<div class="block aside-phone">
				<strong><i class="icon icon-phone"></i><?= $additional_main_data['main_phone'] ?></strong><br>
				Круглосуточный контакт-центр
				
<!--				<span class="social_groups" style="display:block; vertical-align:middle; margin:5px 0 0;">Мы в социальных сетях: <a href="http://vk.com/bankecoprom"><img src="/pics/i/vkontakte.png" alt="Вконтакте" style="position:relative; top:-2px;"></a></span>-->
			</div>
			<div class="block main-office">
				<h6>Офис Банка</h6>
				<?= $additional_main_data['main_contacts'] ?>
				<a href="javascript:void(0)" class="onPage worktimeTrigger">Время работы</a>

				<div class="worktime wtblock" style="display:none">
					<?= $additional_main_data['main_worktime'] ?>
				</div>
				<br/>
				<a href="javascript:void(0)" class="onPage reqTrigger">Наши реквизиты</a>

				<div class="req rqblock" style="display:none">
					<?= $additional_main_data['main_req'] ?>
				</div>
			</div>
		</div>
		<!-- .aside-contacts -->

<!--		<div class="aside-services aside-leaf-block">-->
<!--			<div class="service-hotlink">-->
<!--				<a href="javascript:void(0)" class="hotlink calculator calculateCredit">-->
<!--					Рассчитать кредитный лимит-->
<!--				</a>-->
<!--			</div>-->
<!--			<ul class="service-list">-->
<!--				<li><a href="/personal/cards/all/#creditcards">Выбрать кредитную карту</a></li>-->
<!--				<li><a href="javascript:void(0)" class="onPage offerCardForm" data-id="47">Оформить заявку на&nbsp;кредит</a></li>-->
<!--			</ul>-->
<!--		</div>-->
<!--		<a class="aside-hotlink feedback-button js-feedback-trigger" href="javascript:void(0)">Оставить отзыв. Нам очень важно Ваше мнение!</a>-->
	</div>
	<!-- .pad-aside -->
</div><!-- .page-aside -->