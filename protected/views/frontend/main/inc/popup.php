		<div class="overlay" id="Overlay"></div>
		<div class="popup" id="feedback">
			<div class="pad">
				<form action="#" method="post" class="form">
					<h2 class="headline">Оставить отзыв.<br> Нам очень важно Ваше мнение!</h2>
					<div class="form-row">
						<label for="FeedbackFormName">Представьтесь, пожалуйста</label>
						<div class="inpC">
							<input type="text" name="feedbackName" class="inp" id="FeedbackFormName">
						</div>
					</div>
					<div class="form-row">
						<label for="FeedbackFormContacts">Оставьте Ваш e-mail для ответа</label>
						<div class="inpC">
							<input type="text" name="feedbackContacts" class="inp" id="FeedbackFormContacts">
						</div>
					</div>
					<div class="form-row">
						<label for="FeedbackFormMessage">Ваше сообщение</label>
						<div class="inpC">
							<textarea name="feedbackMessage" class="inp" id="FeedbackFormMessage"></textarea>
						</div>
					</div>
					<div class="form-row submit-row">
						<button type="submit" class="btn">Отправить</button>
					</div>
				</form>
				<div class="loading">
					<img src="/pics/i/loading.gif" width="128" height="128" alt="Подождите, мы отправляем ваше сообщение">
				</div>
				<div class="error">
					<h2>К сожалению произошла ошибка!<br> Попробуйте перезагрузить страницу или отправьте форму позже.</h2>
				</div>
				<div class="success">
					<h2>Спасибо за ваше сообщение!<br> Если это необходимо, мы свяжемся с вами в ближайшее время.</h2>
				</div>
				<a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
			</div>
		</div>


<!--        </div>-->
        <div class="popup-hint"></div>


	<? if($doc_id_last==26 && isset($ymaps_popup) && $ymaps_popup): ?>
        <div class="popup" id="colSchemes">
            <div class="pad">
				<? foreach($list[3]->points as $point): ?>
					<div class="item" data-id="<?=$point->id?>">
						<h2 class="headline"><?=$point->title?></h2>
						<nav class="scheme-navigator section-navigator">
							<ul>
								<? if(count($point->params['img_p']->img)): ?>
									<li class="active"><a href="javascript:void(0)" data-rel="photo">Фото</a></li>
								<? endif; ?>
								<? if(count($point->params['img_s']->img)): ?>
									<li <?=(count($point->params['img_p']->img)==0)?'class="active"':''?>><a href="javascript:void(0)" data-rel="scheme">Схема</a></li>
								<? endif; ?>
							</ul>
						</nav>
						<? if(count($point->params['img_p']->img)): ?>
							<div class="imgpage photo">
								<img src="<?=$point->params['img_p']->img[2]?>" alt="<?=str_replace('"','\"',$point->title)?>">
							</div>
						<? endif; ?>
						<? if(count($point->params['img_s']->img)): ?>
							<div class="imgpage scheme" <?=(count($point->params['img_p']->img)==0)?'style="display: block;"':''?>>
								<img src="<?=$point->params['img_s']->img[2]?>" alt="<?=str_replace('"','\"',$point->title)?>">
							</div>
						<? endif; ?>
					</div>
				<? endforeach; ?>
                <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
            </div>
        </div>
	<? endif; ?>
	
	<?/* if($doc_id_last==103 && isset($ymaps_popup) && $ymaps_popup): ?>
        <div class="popup" id="colSchemes">
            <div class="pad">
				<? foreach($list[3]->points as $point): ?>
					<div class="item" data-id="<?=$point->id?>">
						<h2 class="headline"><?=$point->title?></h2>
						<nav class="scheme-navigator section-navigator">
							<ul>
								<? if(count($point->params[25]->img)): ?>
									<li class="active"><a href="javascript:void(0)" data-rel="photo">Фото</a></li>
								<? endif; ?>
								<? if(count($point->params[26]->img)): ?>
									<li <?=(count($point->params[25]->img)==0)?'class="active"':''?>><a href="javascript:void(0)" data-rel="scheme">Схема</a></li>
								<? endif; ?>
							</ul>
						</nav>
						<? if(count($point->params[25]->img)): ?>
							<div class="imgpage photo">
								<img src="<?=$point->params[25]->img[2]?>" alt="<?=str_replace('"','\"',$point->title)?>">
							</div>
						<? endif; ?>
						<? if(count($point->params[26]->img)): ?>
							<div class="imgpage scheme" <?=(count($point->params[25]->img)==0)?'style="display: block;"':''?>>
								<img src="<?=$point->params[26]->img[2]?>" alt="<?=str_replace('"','\"',$point->title)?>">
							</div>
						<? endif; ?>
					</div>
				<? endforeach; ?>
                <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
            </div>
        </div>
	<? endif; */?>


    <div class="popup" id="cardsEqual">
        <div class="pad">
            <h2 class="headline">Сравнение банковских карт</h2>
            <table class="cardsEqual">
                <tr>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_electron.png" height="70" alt="Visa Electron"> Visa Electron</td>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_MC_MAESTRO.png" height="70" alt="MasterCard Maestro"> MasterCard Maestro</td>
                    <td>Visa Electron, MasterCard Maestro&nbsp;&mdash; используется только в&nbsp;банкоматах и&nbsp;торгово-сервисных предприятиях, оснащенных электронными терминалами, все операции с&nbsp;этими картами проходят электронную авторизацию, что обеспечивает высокую степень безопасности расчетов. Расчеты по&nbsp;карте производятся только в&nbsp;пределах собственных средств клиента</td>
                </tr>
                <tr>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_classic.png" alt="Visa Сlassic"> Visa Сlassic</td>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_MC_STANDART.png" alt="MasterCard Standard"> MasterCard Standard</td>
                    <td>Visa Сlassic, MasterCard Standard&nbsp;— универсальный платежный инструмент, который принимается во&nbsp;всем мире в&nbsp;любых точках обозначенных логотипом Visa или MasterCard, включая банкоматы, реальные и&nbsp;виртуальные магазины, а&nbsp;также магазины, предлагающие товары и&nbsp;услуги по&nbsp;почте и&nbsp;телефону. Расчеты по&nbsp;карте могут производиться как за&nbsp;счет собственных средств клиента, так и&nbsp;за&nbsp;счет предоставленного банком овердрафта</td>
                </tr>
                <tr>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_VISA_GOLD.png" height="70" alt="Visa Gold"> Visa Gold</td>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_MC_GOLD.png" height="70" alt="MasterCard Gold"> MasterCard Gold</td>
                    <td>Visa Gold, MasterCard Gold&nbsp;— универсальный платежный инструмент, который помимо этого позволяет получать скидки и&nbsp;льготы при обслуживании в&nbsp;торгово-сервисных предприятиях по&nbsp;всему миру, а&nbsp;также участвует в&nbsp;международной программе специальных предложений Visa и&nbsp;MasterCard. Расчеты по&nbsp;карте могут производиться как за&nbsp;счет собственных средств клиента, так и&nbsp;за&nbsp;счет предоставленного банком овердрафта</td>
                </tr>
                <tr>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_VISA_PLATINUM.png" height="70" alt="Visa Platinum"> Visa Platinum</td>
                    <td><img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_MC_PLATINUM.png" height="70" alt="MasterCard Platinum"> MasterCard Platinum</td>
                    <td>Visa Platinum, MasterCard Platinum&nbsp;— откроет перед Вами двери в&nbsp;мир привилегий и&nbsp;возможностей. Карты Visa Platinum, MasterCard Platinum признаются и&nbsp;ценятся во&nbsp;всем мире. Карта Visa Platinum, MasterCard Platinum с&nbsp;высоким кредитным лимитом и&nbsp;всемирной сетью приема позволит Вам насладиться впечатляющей финансовой свободой</td>
                </tr>
            </table>
            <p>Предлагаем ознакомиться с&nbsp;эксклюзивными предложениями Visa и&nbsp;MasterCard для держателей карт Visa Gold, MasterCard Gold и&nbsp;Visa Platinum, MasterCard Platinum:</p>
            <ul>
                <li><a rel="nofollow" href="http://www.visa.com.ru/wv/cards_premium.jsp" target="_blank">Visa Premium</a></li>
                <li><a rel="nofollow" href="http://www.mastercardpremium.ru/" target="_blank">MasterCard Premium</a></li>
            </ul>
            <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
        </div>
    </div>

<?/*?>
    <div class="popup" id="offerCardForm">
        <div class="pad">
            <h2 class="headline">Заказ карты</h2>
            <!--https://service.ecoprombank.ru:443/credit112
                https://service.ecoprombank.ru:443/creditmagic
                https://service.ecoprombank.ru:443/credit100500-->
            <iframe src="https://service.ecoprombank.ru:443/credit112" frameborder="0"></iframe>
            <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
        </div>
    </div>

    <div class="popup" id="calculateCredit">
        <div class="pad">
            <h2 class="headline">Кредитный калькулятор</h2>
            <iframe src="https://service.ecoprombank.ru/calc/" frameborder="0"></iframe>
            <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
        </div>
    </div>
	
	<div class="popup" id="GetTourCard">
        <div class="pad">
            <h2 class="headline">Турпакет «Все включено+»</h2>
            <iframe src="https://service.ecoprombank.ru/tourist" frameborder="0"></iframe>
            <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
        </div>
    </div>
<?*/?>

    <div class="popup" id="atmsFilter">
        <div class="pad">
            <div class="filter filter-contacts">
                <div class="filter-pad clearfix">
                    <h3 class="headline addditional-headline geo-headline">Найти ближайший банкомат или терминал</h3>
                    <div class="geocoder cf">
                        <div class="clearfix">
                            <label for="GeocoderInput" class="geoStreetLabel">Введите улицу</label>
                            <label for="GeocoderHouse" class="geoHouseLabel">№ дома</label>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-small">Найти</button>
                            <div class="inpC geoStreetInput">
                                <input type="text" name="contacts[geocoder]" id="GeocoderInput">
                            </div>
                            <div class="inpC geoHouseInput">
                                <input type="text" name="contacts[geocoderHouse]" id="GeocoderHouse">
                            </div>
                        </div>
                        <p class="remark">Поиск осуществляется в&nbsp;радиусе 1&nbsp;км от&nbsp;указанного адреса (не&nbsp;более 20&nbsp;минут ходьбы).</p>
                    </div>
                    <h3 class="headline">Что вам необходимо сделать?</h3>
                    <div class="clearfix cols">
                        <div class="col">
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="nal_rur"> Получить наличные (RUR)</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="pay_card_rur_eur_usd"> Пополнить счет наличными с&nbsp;помощью карты</label>
                                <div class="sub-row clearfix">
                                    <label><input name="contacts[rechargecard]" value="pay_card_rur" type="checkbox"> RUR</label>
                                    <label><input name="contacts[rechargecard]" value="pay_card_usd" type="checkbox"> USD</label>
                                    <label><input name="contacts[rechargecard]" value="pay_card_eur" type="checkbox"> EUR</label>
                                </div>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="pay_account"> Пополнить счет наличными по&nbsp;номеру карты&nbsp;/ счета (RUR)</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="pay_credit"> Погасить кредит</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="pay_rur_nal_rur"> Оплатить услуги</label>
                                <div class="sub-row clearfix">
                                    <label><input name="contacts[payservices]" value="pay_nal_rur" type="checkbox"> с помощью карты</label>
                                    <label><input name="contacts[payservices]" value="pay_rur" type="checkbox"> наличными</label>
                                </div>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="eco_perevod"> Сделать перевод между картами ЭКОПРОМБАНКа</label>
                            </div>
                        </div>
                        <div class="col last">
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="po_operations"> Совершить операции в&nbsp;личном кабинете</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="sms"> Подключить SMS-сервис</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="pin"> Изменить PIN-код</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="credit_request"> Сделать заявку на кредит</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="credit_order"> Получить счет выписку по кредиту</label>
                            </div>
                            <div class="row">
                                <label><input type="checkbox" name="contacts[options]" value="24_hours"> Круглосуточная работа</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="remark remark-error empty-filter">
                    <p>К сожалению, ни один банкомат или терминал не подходит под выбранные настройки фильтра, попробуйте выбрать другие или <a
                            class="onPage js-filter-reset" href="javascript:void(0)">сбросить настройки фильтра</a></p>
                </div>
                <div class="filter-controls clearfix">
                    <div class="submit">
                        <a class="btn">Выбрать</a>
                    </div>
                    <div class="filter-reset">
                        <a href="javascript:void(0)" class="onPage icon-link  js-filter-reset"><span>Сбросить настройки фильтра</span></a>
                    </div>
                </div>
            </div>


            <a href="javascript:void(0)" class="close" title="Закрыть окно"><img src="/pics/i/close.png" alt="Закрыть"></a>
        </div>
    </div>