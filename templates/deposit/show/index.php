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
                    <div class="page-prev"><a href="#prev" data-hint="Вклад 1"><img src="/pics/i/page_prev.png"></a></div>
                    <div class="page-next"><a href="#next" data-hint="Вклад 3"><img src="/pics/i/page_next.png"></a></div>
                    <div class="breadcrumbs withNav">
                        <a href="#">Физическим лицам</a> — <a href="#">Банковские карты</a> — Помощник в выборе карты
                    </div>
                    <h1 class="headline withNav">Вклад Швейцарский <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
                    <div class="page-content">
                        <div class="pad-content">
                            <div class="list-page clearfix">
                                <div class="list-intro clearfix">
                                    <div class="list-intro-text">
                                        <p>VISA ELECTRON, MAESTRO&nbsp;&mdash; используется только в&nbsp;банкоматах и&nbsp;торгово-сервисных предприятиях, оснащенных электронными терминалами, все операции с&nbsp;этими картами проходят электронную авторизацию, что обеспечивает высокую степень безопасности расчетов.</p>
                                    </div>
                                </div>
                                <div class="list-page-services">
                                    <aside class="list-aside-services">
                                        <p class="file">
                                            <a href="/storages/file/test.pdf" class="file">Полные условия по вкладу АНГЛИЙСКИЙ </a>
                                        </p>
                                        <p class="file">
                                            <a href="/storages/file/test.pdf" class="file">Полные условия по вкладу АНГЛИЙСКИЙ </a>
                                        </p>
                                    </aside>
                                    <div class="list-description rightCol clearfix">
                                        <table>
                                            <tr>
                                                <td>Срок выпуска карты</td>
                                                <td><strong>1 день</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Валюта карты</td>
                                                <td><strong>руб.</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Тип карты</td>
                                                <td><strong>MasterCard</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Срок действия карты</td>
                                                <td><strong>36 месяцв</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Стоимость годового обслуживания</td>
                                                <td><strong>600 руб.</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Начисление % на остаток по карте</td>
                                                <td><strong>нет</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Снятие наличных без комиссии</td>
                                                <td><strong>нет</strong></td>
                                            </tr>
                                        </table>
                                    </div><!-- .list-description -->
                                    <div class="back">
                                        <a href="#" class="prev">Перейти к списку вкладов</a>
                                    </div>
                                    <div class="list-bottom clearfix">
                                        <h2 class="headline">Оформление вклада</h2>
                                        <p>Информация о&nbsp;том, что вклад можно оформить в&nbsp;центральном офисе банка по&nbsp;адресу, а&nbsp;дополнительную информацию можно узнать по&nbsp;телефону. Ссылка на&nbsp;инфомрацию по&nbsp;оформлению вклада</p>
                                        <p>
                                            <a href="#" class="btn">Подробнее</a>
                                        </p>
                                        <img class="list-bottom-bg" src="/pics/bg/list/deposit.png">
                                    </div>
                                </div><!-- .list-page-services -->

                            </div>
                        </div><!-- .pad-content -->
                    </div><!-- .page-content -->
                    <?
						include $_SERVER['DOCUMENT_ROOT']."/templates/inc/aside.php";
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
