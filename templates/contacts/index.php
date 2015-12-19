<?
	include $_SERVER['DOCUMENT_ROOT']."/templates/inc/meta.php";
?>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">Ваш браузер <strong>давно устарел</strong>. Пожалуйста <a href="http://browsehappy.com/">обновите браузер</a> или <a href="http://www.google.com/chromeframe/?redirect=true">установите Google Chrome Frame</a> для комфортной работы с этим сайтом.</p>
        <![endif]-->
        <div class="page-bg">
            <div class="page-container">
                <?
					include $_SERVER['DOCUMENT_ROOT']."/templates/inc/header.php";
				?>
                <div class="page-layout clearfix">
                    <div class="breadcrumbs">
                        <a href="#">Физическим лицам</a> — <a href="#">Банковские карты</a> — Помощник в выборе карты
                    </div>
                    <h1 class="headline">Как нас найти? <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
                    <div class="page-content">
                        <div class="pad-content">
                            <nav class="section-navigator js-navigator">
                                <ul>
                                    <li class="active"><a href="#atms" class="onPage">Банкоматы и терминалы</a></li>
                                    <li><a href="#cols" class="onPage">Центры оперативного кредитования</a></li>
                                </ul>
                            </nav>
                            <div class="atms js-page" style="display:block;">
                                <nav class="section-navigator js-navigator sub-navigation">
                                    <ul>
                                        <li class="active"><a href="#atms/list" class="onPage">Списком</a></li>
                                        <li><a href="#atms/map" class="onPage">Посмотреть на карте</a></li>
                                    </ul>
                                </nav>
                                <div class="atms-list js-sub-page" style="display:block;">
                                    <div class="remark remark-error empty-filter">
                                        <p>К сожалению, у нас еще нет карт с такими параметрами, попробуйте выбрать другие или <a
                                                class="onPage js-filter-reset" href="javascript:void(0)">сбросить настройки фильтра</a></p>
                                    </div>
                                    <div class="filter-list contacts-list">
                                        <h2>Банкоматы в Перми</h2>
                                        <table class="atms-table">
                                            <tr data-id="-1" class="js-FilterHead">
                                                <th>Наменование</th>
                                                <th>Время работы</th>
                                                <th>Адрес</th>
                                                <th>Услуги</th>
                                            </tr>
                                            <tr data-id="1" data-options="|1|2|3|4|5|6|7|8|9|" data-lat="55.76" data-lon="37.64" data-icon="/pics/i/maps/mainoffice.png" data-getcashcurrency="|1|2|3|" data-rechargecard="|1|2|3|" data-payservices="|1|2|3|" data-payservicecash="|1|2|3|" data-title="Центральный офис ОАО АКБ «ЭКОПРОМБАНК»" data-type="mainoffice">
                                                <td><strong>Центральный офис ОАО АКБ «ЭКОПРОМБАНК»</strong></td>
                                                <td><img src="/pics/i/24.png" alt="24 часа"> часа</td>
                                                <td><a href="#atms/map/1" class="onPage">Екатерининская, 120</a></td>
                                                <td>выдача RUR<br>пополнение RUR, USD, EUR</td>
                                            </tr>
                                            <tr data-id="2"  data-options="|1|9|" data-lat="55.76" data-lon="37.65" data-icon="/pics/i/maps/atm.png" data-getcashcurrency="|1|" data-rechargecard="|1|" data-payservices="|1|"data-title="Центральный офис ОАО АКБ «ЭКОПРОМБАНК»" data-type="atm">
                                                <td><strong>Легкоатлетический манеж «Спартак»</strong></td>
                                                <td>8.00 - 23.00</td>
                                                <td><a href="#atms/map/2" class="onPage">Рабочая, 9</a></td>
                                                <td>выдача RUR</td>
                                            </tr>
                                            <tr data-id="3" data-options="|1|2|3|4|5|" data-lat="55.75" data-lon="37.66" data-icon="/pics/i/maps/24.png" data-getcashcurrency="|1|2|3|" data-rechargecard="|1|2|3|" data-payservices="|1|2|3|" data-payservicecash="|1|2|3|" data-title="Центральный офис ОАО АКБ «ЭКОПРОМБАНК»" data-type="24">
                                                <td><strong>Центральный Универмаг (ЦУМ) </strong><img class="partner" src="/pics/i/partner.png" alt="Петрокомерц банк"></td>
                                                <td>ПН-СБ<br>10:00—21:00<br>ВС<br> 10:00—20:00</td>
                                                <td><a href="#atms/map/3" class="onPage">Ленина, 45</a></td>
                                                <td>выдача RUR</td>
                                            </tr>
                                            <tr data-id="4" data-options="|1|2|3|4|5|6|7|8|9|" data-lat="55.74" data-lon="37.67" data-icon="/pics/i/maps/petro.png" data-getcashcurrency="|1|2|3|" data-rechargecard="|1|2|3|" data-payservices="|1|2|3|" data-payservicecash="|1|2|3|" data-title="Центральный офис ОАО АКБ «ЭКОПРОМБАНК»" data-type="petro">
                                                <td><strong>Центральный офис ОАО АКБ «ЭКОПРОМБАНК»</strong></td>
                                                <td><img src="/pics/i/24.png" alt="24 часа"> часа</td>
                                                <td><a href="#atms/map/1" class="onPage">Екатерининская, 120</a></td>
                                                <td>выдача RUR<br>пополнение RUR, USD, EUR</td>
                                            </tr>
                                            <tr data-id="5" data-options="|7|8|9|" data-lat="55.73" data-lon="37.68" data-icon="/pics/i/maps/petro.png" data-getcashcurrency="|1|2|3|" data-rechargecard="|1|2|3|" data-payservices="|1|2|3|" data-payservicecash="|1|2|3|" data-title="Центральный офис ОАО АКБ «ЭКОПРОМБАНК»" data-type="petro">
                                                <td><strong>Легкоатлетический манеж «Спартак»</strong><img class="partner" src="/pics/i/partner_magia.png" alt="Практическая магия"></td>
                                                <td>8.00 - 23.00</td>
                                                <td><a href="#atms/map/2" class="onPage">Рабочая, 9</a></td>
                                                <td>выдача RUR</td>
                                            </tr>
                                            <tr data-id="6" data-options="|7|8|9|" data-lat="55.72" data-lon="37.69" data-icon="/pics/i/maps/magic.png" data-getcashcurrency="|3|" data-rechargecard="|3|" data-payservices="|2|3|" data-payservicecash="|2|3|" data-title="Центральный офис ОАО АКБ «ЭКОПРОМБАНК»" data-type="magic">
                                                <td><strong>Центральный Универмаг (ЦУМ) </strong><img class="partner" src="/pics/i/partner.png" alt="Петрокомерц банк"></td>
                                                <td>ПН-СБ<br>10:00—21:00<br>ВС<br> 10:00—20:00</td>
                                                <td><a href="#atms/map/3" class="onPage">Ленина, 45</a></td>
                                                <td>выдача RUR</td>
                                            </tr>
                                        </table>

                                        <h2>Банкоматы в области</h2>
                                        <table>
                                            <tr data-id="-1" class="js-FilterHead">
                                                <th>Наменование</th>
                                                <th>Время работы</th>
                                                <th>Адрес</th>
                                                <th>Услуги</th>
                                            </tr>
                                            <tr>
                                                <td><strong>Центральный офис ОАО АКБ «ЭКОПРОМБАНК»</strong></td>
                                                <td><img src="/pics/i/24.png" alt="24 часа"> часа</td>
                                                <td>г. Чернушка, Екатерининская, 120</td>
                                                <td>выдача RUR<br>пополнение RUR, USD, EUR</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Легкоатлетический манеж «Спартак»</strong></td>
                                                <td>8.00 - 23.00</td>
                                                <td>г. Чернушка, Екатерининская, 120</td>
                                                <td>выдача RUR</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Центральный Универмаг (ЦУМ) </strong><img class="partner" src="/pics/i/partner.png" alt="Петрокомерц банк"></td>
                                                <td>ПН-СБ<br>10:00—21:00<br>ВС<br> 10:00—20:00</td>
                                                <td>г. Чернушка, Екатерининская, 120</td>
                                                <td>выдача RUR</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Центральный офис ОАО АКБ «ЭКОПРОМБАНК»</strong></td>
                                                <td><img src="/pics/i/24.png" alt="24 часа"> часа</td>
                                                <td>г. Чернушка, Екатерининская, 120</td>
                                                <td>выдача RUR<br>пополнение RUR, USD, EUR</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="atms-map  js-sub-page">
                                    <div class="legend clearfix">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="javascript:void(0)" class="clearfix" data-type="mainoffice">
                                                        <img src="/pics/i/maps/mainoffice.png" alt="Центральный офис Экопромбанка"> <span>Главный офис</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="clearfix" data-type="atm">
                                                        <img src="/pics/i/maps/atm.png" alt="Банкоматы Экопромбанка"> <span>Банкоматы Экопромбанка</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="clearfix" data-type="24">
                                                        <img src="/pics/i/maps/24.png" alt="Круглосуточные банкоматы"> <span>Круглосуточные банкоматы</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="clearfix" data-type="petro">
                                                        <img src="/pics/i/maps/petro.png" alt="Банкоматы партнера Петрокомерц"> <span>Банкоматы партнера Петрокомерц</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="clearfix" data-type="magic">
                                                        <img src="/pics/i/maps/magic.png" alt="Банкоматы партнера Петрокомерц"> <span>Сеть салонов Практическая магия</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="atmMap" class="map"></div>
                                </div>
                            </div>
                            <div class="cols  js-page">
                                <nav class="section-navigator js-navigator sub-navigation">
                                    <ul>
                                        <li class="active"><a href="#cols/list" class="onPage">Списком</a></li>
                                        <li><a href="#cols/map" class="onPage">Посмотреть на карте</a></li>
                                    </ul>
                                </nav>
                                <div class="cols-list  js-sub-page">
                                    <table class="cols-table">
                                        <tr class="js-FilterHead">
                                            <th>Наменование</th>
                                            <th></th>
                                            <th>Адрес</th>
                                            <th>Время работы</th>
                                        </tr>
                                        <tr data-id="1" data-lat="55.74" data-lon="37.67" data-icon="/pics/i/maps/mainoffice.png" data-title="ТРК «СемьЯ», 2 очередь">
                                            <td><strong>ТРК «КОЛИЗЕЙ-Cinema»</strong></td>
                                            <td><a href="javascript:void(0)" class="colsScheme" data-id="1">Схема</a></td>
                                            <td><a href="#cols/map/1" class="onPage">Куйбышева, 16 этаж</a></td>
                                            <td>10:00 - 21:00</td>
                                        </tr>
                                        <tr data-id="2" data-lat="55.64" data-lon="37.77" data-icon="/pics/i/maps/mainoffice.png" data-title="ТРК «СемьЯ», 2 очередь">
                                            <td><strong>ТРК «СемьЯ», 2 очередь</strong></td>
                                            <td><a href="javascript:void(0)" class="colsScheme" data-id="2">Схема</a></td>
                                            <td><a href="#cols/map/2" class="onPage">Куйбышева, 16 этаж</a></td>
                                            <td>10:00 - 21:00</td>
                                        </tr>
                                        <tr data-id="3" data-lat="55.54" data-lon="37.87" data-icon="/pics/i/maps/mainoffice.png" data-title="ТРК «СемьЯ», 2 очередь">
                                            <td><strong>ТРК «КОЛИЗЕЙ-Cinema»</strong></td>
                                            <td><a href="javascript:void(0)" class="colsScheme" data-id="3">Схема</a></td>
                                            <td><a href="#cols/map/3" class="onPage">Куйбышева, 16 этаж</a></td>
                                            <td>10:00 - 21:00</td>
                                        </tr>
                                        <tr data-id="4" data-lat="55.44" data-lon="37.97" data-icon="/pics/i/maps/mainoffice.png" data-title="ТРК «СемьЯ», 2 очередь">
                                            <td><strong>ТРК «КОЛИЗЕЙ-Cinema»</strong></td>
                                            <td><a href="javascript:void(0)" class="colsScheme" data-id="4">Схема</a></td>
                                            <td><a href="#cols/map/4" class="onPage">Куйбышева, 16 этаж</a></td>
                                            <td>10:00 - 21:00</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="cols-map  js-sub-page">
                                    <div id="colMap" class="map"></div>
                                </div>

                            </div>
                        </div><!-- .pad-content -->
                    </div><!-- .page-content -->
                    <?
						include $_SERVER['DOCUMENT_ROOT']."/templates/inc/aside_contacts.php";
					?>
                </div><!-- .page-layout -->
					<?
						include $_SERVER['DOCUMENT_ROOT']."/templates/inc/footer.php";
					?>
            </div><!-- .page-container -->
        </div><!-- .page-bg -->
        <?
			include $_SERVER['DOCUMENT_ROOT']."/templates/inc/popup.php";
		?>
		<?
			include $_SERVER['DOCUMENT_ROOT']."/templates/inc/end.php";
		?>
    </body>
</html>
