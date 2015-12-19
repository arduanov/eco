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
                        <a href="#">Физическим лицам</a> — <a href="#">Банковские карты</a> — Помощник в выборе вклада
                    </div>
                    <h1 class="headline">Все вклады <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
                    <?
                        include $_SERVER['DOCUMENT_ROOT']."/templates/inc/aside_fixed.php";
                    ?>
                    <div class="page-content fixed-aside">
                        <div class="pad-content">
                            <div class="filter transfer-filter">
                                <div class="filter-pad clearfix">
                                    <div class="slider-rows clearfix">
                                        <h3 class="headline">Укажите валюту и сумму перевода</h3>
                                        <div class="slider first clearfix">
                                            <select name="transfer[currency]">
                                                <option value="rur">Рубли</option>
                                                <option value="usd">Доллары</option>
                                                <option value="eur">Евро</option>
                                            </select>
                                             <div class="inpC">
                                                <input class="inp" id="summ" name="transfer[summ]" value="10000">
                                                <div class="slider-input"></div>
                                            </div>
                                        </div>
                                        <p>Ваша комиссия составит: <strong id="comission">160 руб.</strong></p>
                                    </div>
                                </div><!-- .filter-pad -->
                            </div><!-- .filter .card-filter -->
                            <h2>Денежные переводы Migom</h2>
                            <p>MIGOM (МИГОМ)<sup><small>&reg;</small></sup>&nbsp;&mdash; это программа проведения неторговых денежных переводов физических лиц без открытия счета на&nbsp;пространстве СНГ и&nbsp;стран Балтии &laquo;Европейского Трастового Банка&raquo;.</p>
                            <p>Сеть агентских пунктов программы денежных переводов MIGOM<sup><small>&reg;</small></sup> строится на&nbsp;партнерских отношения КБ&nbsp;&laquo;ЕВРОТРАСТ&raquo; с&nbsp;банками России и&nbsp;СНГ, что обусловлено многолетним успешным сотрудничеством в&nbsp;рамках программы комплексного обслуживания финансовых институтов.</p>
                            <p>Достоинства программы денежных переводов MIGOM<sup><small>&reg;</small></sup> очевидны&nbsp;&mdash; быстрота (5&ndash;10&nbsp;минут), безопасность (передовые технологии защиты информации), дешевизна (комиссия 2&ndash;3% от&nbsp;суммы перевода), удобство оформления (без банковских реквизитов).</p>
                            <p>Денежные переводы MIGOM<sup><small>&reg;</small></sup>&nbsp;&mdash; это:</p>
                            <ul>
                                <li>максимальная скорость проведения денежного перевода&nbsp;&mdash; всего 5&ndash;10&nbsp;минут;</li>
                                <li>низкие комиссионные тарифы&nbsp;&mdash; от&nbsp;2 до&nbsp;3%;</li>
                                <li>сохранность Ваших денег, обеспеченная обязательствами крупнейших банков;</li>
                                <li>выплата денежного перевода без комиссии;</li>
                                <li>простота при оформлении денежного перевода</li>
                            </ul>
                            <h3>Кому это выгодно?</h3>
                            <p>Денежные переводы MIGOM<sup><small>&reg;</small></sup> удобны тем, кому необходимо срочно перевести или получить деньги: сезонным рабочим, студентам, туристам, людям, отправляющим деньги родным и&nbsp;близким.</p>
                            <h3>Как это работает?</h3>
                            <p>Программное обеспечение денежных переводов MIGOM<sup><small>&reg;</small></sup>, построенное на&nbsp;современных интернет-технологиях, предоставляемое банкам-агентам, удобно в&nbsp;применении и&nbsp;позволяет получать информацию не&nbsp;только по&nbsp;проводимым операциям, но&nbsp;и&nbsp;особенностям валютного законодательства стран СНГ.&nbsp;Программное обеспечение денежных переводов MIGOM<sup><small>&reg;</small></sup> разработано Компанией &laquo;Банк`с&nbsp;Софт Системс&raquo; при участии специалистов Банка в&nbsp;рамках комплексной системы ДБО BS-Client.</p>
                            <p>узнать о&nbsp;денежных переводах MIGOM<sup><small>&reg;</small></sup> подробнее можно на&nbsp;сайте www.migom.com</p>
                        </div><!-- .pad-content -->
                    </div><!-- .page-content -->
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
