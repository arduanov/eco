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
                    <h1 class="headline">Аренда сейфов</h1>
                    <?
                        include $_SERVER['DOCUMENT_ROOT']."/templates/inc/aside_fixed.php";
                    ?>
                    <div class="page-content fixed-aside">
                        <div class="pad-content">
                            <h3>Выберите срок аренды и&nbsp;габариты</h3>
                            <table class="safe-table">
                                <thead>
                                    <tr class="safes">
                                        <td>
                                            Срок аренды, дней:<br>
                                            <div class="slider clearfix">
                                                <div class="inpC">
                                                    <input type="tel" class="inp" name="creditSumm" value="31">
                                                    <div class="slider-input"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-rel="1" data-hint="30.5 x 7.4 x 60" class="safe active"><img src="/pics/i/safe/1.png" alt="30.5x7.4x60"></td>
                                        <td data-rel="2" data-hint="30.5 x 12.6 x 60" class="safe"><img src="/pics/i/safe/2.png" alt="30.5x12.6x60"></td>
                                        <td data-rel="3" data-hint="30.5 x 25.6 x 60" class="safe"><img src="/pics/i/safe/3.png" alt="30.5x25.6x60"></td>
                                        <td data-rel="4" data-hint="30.5 x 39 x 60" class="safe"><img src="/pics/i/safe/4.png" alt="30.5x39x60"></td>
                                        <td data-rel="5" data-hint="30.5 x 52.5 x 60" class="safe"><img src="/pics/i/safe/5.png" alt="30.5x52.5x60"></td>
                                    </tr>
                                    <tr class="summary">
                                        <td colspan="6">Стоимость аренды сейфа на <span class="days">180</span> <span class="label">дней</span> = <span class="summ">10 000</span> руб.</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-min="0" data-max="1">
                                        <td><strong>До&nbsp;1 дня</strong></td>
                                        <td class="line" data-rel="1">1000 руб.</td>
                                        <td data-rel="2">1100 руб.</td>
                                        <td data-rel="3">1200 руб.</td>
                                        <td data-rel="4">1300 руб.</td>
                                        <td data-rel="5">1400 руб.</td>
                                    </tr>
                                    <tr data-min="2" data-max="30">
                                        <td><strong>до 30 дней</td>
                                        <td class="line" data-rel="1">2000 руб.</td>
                                        <td data-rel="2">2100 руб.</td>
                                        <td data-rel="3">2200 руб.</td>
                                        <td data-rel="4">2300 руб.</td>
                                        <td data-rel="5">2400 руб.</td>
                                    </tr>
                                    <tr data-min="31" data-max="90">
                                        <td><strong>от&nbsp;31 до&nbsp;90 дней</strong></td>
                                        <td class="line current" data-rel="1">5000 руб.</td>
                                        <td data-rel="2">5100 руб.</td>
                                        <td data-rel="3">5200 руб.</td>
                                        <td data-rel="4">5300 руб.</td>
                                        <td data-rel="5">5400 руб.</td>
                                    </tr>
                                    <tr data-min="91" data-max="180">
                                        <td><strong>от&nbsp;91 до&nbsp;180 дней</strong></td>
                                        <td class="line" data-rel="1">6000 руб.</td>
                                        <td data-rel="2">6100 руб.</td>
                                        <td data-rel="3">6200 руб.</td>
                                        <td data-rel="4">6300 руб.</td>
                                        <td data-rel="5">6400 руб.</td>
                                    </tr>
                                    <tr data-min="181" data-max="270">
                                        <td><strong>от&nbsp;181 до&nbsp;270 дней</strong></td>
                                        <td class="line" data-rel="1">8000 руб.</td>
                                        <td data-rel="2">8100 руб.</td>
                                        <td data-rel="3">8200 руб.</td>
                                        <td data-rel="4">8300 руб.</td>
                                        <td data-rel="5">8400 руб.</td>
                                    </tr>
                                    <tr data-min="271" data-max="360">
                                        <td><strong>от&nbsp;271 до&nbsp;360 дней</strong></td>
                                        <td class="line" data-rel="1">10&nbsp;000 руб.</td>
                                        <td data-rel="2">10&nbsp;100 руб.</td>
                                        <td data-rel="3">10&nbsp;200 руб.</td>
                                        <td data-rel="4">10&nbsp;300 руб.</td>
                                        <td data-rel="5">10&nbsp;400 руб.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h2>Для аренды сейфа необходимо</h2>
                            <p>После подписания с&nbsp;банком договора и&nbsp;после внесения арендной платы вы&nbsp;получаете ключи от&nbsp;сейфа и&nbsp;имеете право распоряжаться сейфом. Арендную плату вы&nbsp;можете перечислить безналичным путем или путем внесения наличных денежных средств в&nbsp;кассу банка. Внесение залога за&nbsp;ключ, не&nbsp;требуется, ключ находится у&nbsp;вас до&nbsp;окончания срока действия договора.</p>
                            <p>Клиент может разрешить допуск к&nbsp;арендованному индивидуальному сейфу поверенного лица в&nbsp;рамках действующих договоров аренды. Поверенный (физическое лицо) должен предъявить оригинал нотариально оформленной доверенности.</p>
                            <p>ЭКОПРОМБАНК гарантирует полную конфиденциальность аренды сейфа, не&nbsp;требует извещения о&nbsp;предмете хранения, а&nbsp;также обеспечивает полную сохранность содержимого вашего сейфа. При необходимости клиент может воспользоваться оборудованием для пересчета и&nbsp;проверки денежных купюр бесплатно.</p>
                            <p>Банк обеспечивает клиенту беспрепятственный доступ к&nbsp;сейфу в&nbsp;соответствии с&nbsp;режимом работы Депозитария.</p>
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
