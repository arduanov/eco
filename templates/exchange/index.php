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
                    <h1 class="headline">Калькулятор обмена валют <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
                    <?
                        include $_SERVER['DOCUMENT_ROOT']."/templates/inc/aside_fixed.php";
                    ?>
                    <div class="page-content fixed-aside">
                        <div class="pad-content">
                            <div class="filter exchange-filter">
                                <div class="filter-pad clearfix">
                                    <div class="slider-rows clearfix">
                                        <h3 class="headline">Укажите операцию и сумму валюты</h3>
                                        <div class="slider first clearfix">
                                            <select name="exchange[operation]">
                                                <option value="buy">Купить</option>
                                                <option value="sell">Продать</option>
                                            </select>
                                        </div>
                                        <div class="slider input clearfix">
                                            <select name="exchange[currency]">
                                                <option value="usd">долларов</option>
                                                <option value="eur">евро</option>
                                            </select>
                                            <div class="inpC">
                                                <input class="inp" id="summ" name="transfer[summ]" value="200" data-buy-usd="30" data-sell-usd="31" data-buy-eur="40" data-sell-eur="41">
                                                <div class="slider-input"></div>
                                            </div>
                                        </div>
                                        <h2 style="margin:20px 0 0;" id="result"></h2>
                                    </div>
                                </div><!-- .filter-pad -->
                            </div><!-- .filter .card-filter -->
                            <p><strong>Внимание!</strong> Для операции обмена валют, вам потребуется предъявить пасспорт.</p>
                            <h2>Курсы валют сегодня</h2>
                            <table>
                                <tr>
                                    <th></th>
                                    <th>Покупка</th>
                                    <th>Продажа</th>
                                </tr>
                                <tr>
                                    <td><strong>Доллары, США</strong></td>
                                    <td>30,00 руб. <i class=" up"></i></td>
                                    <td>31,00 руб. <i class=" up"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>Евро</strong></td>
                                    <td>40,00 руб. <i class=" down"></i></td>
                                    <td>41,00 руб. <i class=" down"></i></td>
                                </tr>
                            </table>
                            <h2>История изменений курса за последний месяц</h2>

                            <table>
                                <tr>
                                    <th></th>
                                    <th>Покупка, $</th>
                                    <th>Продажа, $</th>
                                    <th>Покупка, &euro;</th>
                                    <th>Продажа, &euro;</th>
                                </tr>
                                <tr>
                                    <td>31.11.2012</td>
                                    <td>30,00 руб. <i class=" up"></i></td>
                                    <td>31,00 руб. <i class=" up"></i></td>
                                    <td>40,00 руб. <i class=" down"></i></td>
                                    <td>41,00 руб. <i class=" down"></i></td>
                                </tr>
                                <tr>
                                    <td>30.11.2012</td>
                                    <td>30,00 руб. <i class=" up"></i></td>
                                    <td>31,00 руб. <i class=" up"></i></td>
                                    <td>40,00 руб. <i class=" down"></i></td>
                                    <td>41,00 руб. <i class=" down"></i></td>
                                </tr>
                            </table>

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
