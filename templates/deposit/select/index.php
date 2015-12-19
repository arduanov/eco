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
                            <div class="filter deposit-filter">
                                <div class="filter-pad clearfix">
                                    <div class="slider-rows clearfix">
                                        <div class="slider first clearfix">
                                            <select name="deposit[currency]">
                                                <option value="rur">Руб.</option>
                                                <option value="usd">Долл.</option>
                                                <option value="eur">Евро</option>
                                            </select>
                                             <div class="inpC">
                                                <input class="inp" id="summ" name="deposit[summ]" value="5000000">
                                                <div class="slider-input"></div>
                                            </div>
                                        </div>
                                        <div class="slider selectOnly clearfix">
                                            <select name="deposit[period]">
                                                <option value="-1">Неважно</option>
                                                <option value="31">31 день</option>
                                                <option value="91">91 день</option>
                                                <option value="181">181 день</option>
                                                <option value="271">271 день</option>
                                                <option value="370">370 дней</option>
                                                <option value="740">740 дней</option>
                                                <option value="1110">1110 дней</option>
                                                <option value="1480">1480 дней</option>
                                                <option value="1850">1850 дней</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col first">
                                        <div class="filter-block">
                                            <label class="row">
                                                <input type="checkbox" name="deposit[options]" value="1"> возможность пополнения вклада
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="filter-block">
                                            <label class="row">
                                                <input type="checkbox" name="deposit[options]" value="2"> возможность снимать средства со вклада
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="filter-block">
                                            <label class="row">
                                                <input type="checkbox" name="deposit[options]" value="3"> возможность закрыть вклад досрочно

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col last">
                                        <div class="filter-block">
                                            <h6>Проценты</h6>
                                            <label class="row">
                                                <input type="radio" name="deposit[percents]" value="1"> прибавлять ко&nbsp;вкладу
                                            </label>
                                            <label class="row">
                                                <input type="radio" name="deposit[percents]" value="2"> получать на&nbsp;руки
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- .filter-pad -->
                                <div class="filter-reset">
                                    <a href="javascript:void(0)" class="onPage icon-link  js-filter-reset"><span>Сбросить настройки фильтра</span></a>
                                </div>
                            </div><!-- .filter .card-filter -->
                            <div class="remark remark-error empty-filter">
                                <p>К сожалению, у нас еще нет карт с такими параметрами, попробуйте выбрать другие или <a class="onPage js-filter-reset" href="javascript:void(0)">сбросить настройки фильтра</a></p>
                            </div>
                            <a href="javascript:void(0)" class="ctrlLeft"><span></span></a>
                            <a href="javascript:void(0)" class="ctrlRight"><span></span></a>
                            <div class="filter-list deposit-list clearfix">
                                <aside class="table-left">
                                    <table>
                                        <tbody>
                                        <tr data-id="-1">
                                            <th class="table-card-type">Название</th>
                                        </tr>
                                        <tr data-id="1">
                                            <td class="table-card-type"><strong><a href="#">Английский</a></strong></td>
                                        </tr>
                                        <tr data-id="2">
                                            <td class="table-card-type"><strong><a href="#">Французский</a></strong></td>
                                        </tr>
                                        <tr data-id="3">
                                            <td class="table-card-type"><strong><a href="#">Швейцарский</a></strong></td>
                                        </tr>
                                        <tr data-id="4">
                                            <td class="table-card-type"><strong><a href="#">Швейцарский Deluxe</a></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </aside>
                                <aside class="table-right">
                                    <table>
                                        <tbody>
                                        <tr data-id="-1">
                                            <th>Базовая годовая ставка по вкладу</th>
                                        </tr>
                                        <tr data-id="1">
                                            <td>
                                                от 4.5% для руб.<br> от 1% для $, &euro;
                                            </td>
                                        </tr>
                                        <tr data-id="2">
                                            <td>
                                                от 10.7% для руб.<br> от 3% для $, &euro;
                                            </td>
                                        </tr>
                                        <tr data-id="3">
                                            <td>
                                                от 11.2% для руб.<br> от 3% для $, &euro;
                                            </td>
                                        </tr>
                                        <tr data-id="4">
                                            <td>
                                                от 8.5%
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </aside>
                                <!-- .filter-list-aside -->
                                <div class="ovf">
                                    <table class="scrollTable">
                                        <tbody>
                                        <tr data-id="-1" class="js-FilterHead">
                                            <th>Валюта</th>
                                            <th>Минимальная сумма</th>
                                            <th>Срок</th>
                                            <th>Процентная ставка</th>
                                            <th>Минимальная сумма пополнения</th>
                                            <th>Частичное снятие средств</th>
                                            <th>Периодичность выплаты&nbsp;%</th>
                                            <th class="last">Порядок выплаты&nbsp;%</th>
                                        </tr>
                                        <tr data-id="1" data-period="|31|91|" data-currency="|rur|usd|eur|" data-options="|1|3|" data-percents="|2|" data-minrur="5000" data-minusd="200" data-mineur="200">
                                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                                            <td class="table-card-currency">5000 руб.<br>$200<br>€200</td>
                                            <td>от 31 дня</td>
                                            <td>4,5%&nbsp;&ndash;&nbsp;8%<br>1%&nbsp;&ndash;&nbsp;3%<br>1%&nbsp;&ndash;&nbsp;3%</td>
                                            <td>1000 руб.<br>$50<br>€50</td>
                                            <td><i class="icon icon-negative"></i></td>
                                            <td>По окончании срока вклада</td>
                                            <td>Присоеденение к сумме вклада</td>
                                        </tr>
                                        <tr data-id="2" data-period="|181|91|" data-currency="|rur|usd|eur|" data-options="|3|" data-percents="|1|" data-minrur="30000" data-minusd="1000" data-mineur="1000">
                                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                                            <td class="table-card-currency">5000 руб.<br>$200<br>€200</td>
                                            <td>от 31 дня</td>
                                            <td>4,5%&nbsp;&ndash;&nbsp;8%<br>1%&nbsp;&ndash;&nbsp;3%<br>1%&nbsp;&ndash;&nbsp;3%</td>
                                            <td>1000 руб.<br>$50<br>€50</td>
                                            <td><i class="icon icon-negative"></i></td>
                                            <td>По окончании срока вклада</td>
                                            <td>Присоеденение к сумме вклада</td>
                                        </tr>
                                        <tr data-id="3" data-period="|181|271|370|" data-currency="|rur|usd|eur|" data-options="|1|2|" data-percents="|1|" data-minrur="350000" data-minusd="7500" mineur="7500">
                                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                                            <td class="table-card-currency">5000 руб.<br>$200<br>€200</td>
                                            <td>от 31 дня</td>
                                            <td>4,5%&nbsp;&ndash;&nbsp;8%<br>1%&nbsp;&ndash;&nbsp;3%<br>1%&nbsp;&ndash;&nbsp;3%</td>
                                            <td>1000 руб.<br>$50<br>€50</td>
                                            <td><i class="icon icon-negative"></i></td>
                                            <td>По окончании срока вклада</td>
                                            <td>Присоеденение к сумме вклада</td>
                                        </tr>
                                        <tr data-id="4" data-period="|740|1110|1480|1850|" data-currency="|rur|" data-options="|1|2|3|" data-percents="|1|" data-minrur="5000000">
                                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                                            <td class="table-card-currency">5000 руб.<br>$200<br>€200</td>
                                            <td>от 31 дня</td>
                                            <td>4,5%&nbsp;&ndash;&nbsp;8%<br>1%&nbsp;&ndash;&nbsp;3%<br>1%&nbsp;&ndash;&nbsp;3%</td>
                                            <td>1000 руб.<br>$50<br>€50</td>
                                            <td><i class="icon icon-negative"></i></td>
                                            <td>По окончании срока вклада</td>
                                            <td>Присоеденение к сумме вклада</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <script>
                                        /*Проценты вклады и методы вычисления*/
                                        var DEPOSIT_PERCENTS = {
                                            deposit1 : {
                                                trigger : 'period',
                                                periods : {
                                                    rur : [
                                                        {period : 31, percents : 4.5},
                                                        {period : 91, percents : 5.5},
                                                        {period : 181, percents : 6.5},
                                                        {period : 271, percents : 7.5},
                                                        {period : 370, percents : 8.5}
                                                    ],
                                                    usd : [
                                                        {period : 31, percents : 1},
                                                        {period : 91, percents : 1.5},
                                                        {period : 181, percents : 2},
                                                        {period : 271, percents : 2.5},
                                                        {period : 370, percents : 3}
                                                    ],
                                                    eur : [
                                                        {period : 31, percents : 1},
                                                        {period : 91, percents : 1.5},
                                                        {period : 181, percents : 2},
                                                        {period : 271, percents : 2.5},
                                                        {period : 370, percents : 3}
                                                    ]
                                                },
                                                percentsMin : "от 4.5% для руб.<br> от 1% для $, &euro;"
                                            },
                                            deposit2 : {
                                                trigger : 'period',
                                                periods : {
                                                    rur : [
                                                        {period : 370, percents : 10.7}
                                                    ],
                                                    usd : [
                                                        {period : 370, percents : 3}
                                                    ],
                                                    eur : [
                                                        {period : 370, percents : 3}
                                                    ]
                                                },
                                                percentsMin : "от 10.7% для руб.<br> от 3% для $, &euro;"
                                            },
                                            deposit3 : {
                                                trigger : 'period',
                                                periods : {
                                                    rur : [
                                                        {period : 370, percents : 11.2}
                                                    ],
                                                    usd : [
                                                        {period : 370, percents : 3}
                                                    ],
                                                    eur : [
                                                        {period : 370, percents : 3}
                                                    ]
                                                },
                                                percentsMin : "от 11.2% для руб.<br> от 3% для $, &euro;"
                                            },
                                            deposit4 : {
                                                trigger : 'summ',
                                                summ : 20000000,
                                                periodsMore : {
                                                    rur : [
                                                        {period : 740, percents : 10.5},
                                                        {period : 1110, percents : 10},
                                                        {period : 1480, percents : 9.5},
                                                        {period : 1850, percents : 9}
                                                    ]
                                                },
                                                periodsLess : {
                                                    rur : [
                                                        {period : 740, percents : 10},
                                                        {period : 1110, percents : 9.5},
                                                        {period : 1480, percents : 9},
                                                        {period : 1850, percents : 8.5}
                                                    ]
                                                },
                                                percentsMin : "от 8.5%"
                                            }
                                        }
                                    </script>
                                    <!-- .scrollTable -->
                                </div>
                            </div><!-- .filter-list -->
                            <div class="list-bottom clearfix">
                                <h2 class="headline">Оформление вклада</h2>
                                <p>Информация о&nbsp;том, что вклад можно оформить в&nbsp;центральном офисе банка по&nbsp;адресу, а&nbsp;дополнительную информацию можно узнать по&nbsp;телефону. Ссылка на&nbsp;инфомрацию по&nbsp;оформлению вклада</p>
                                <p>
                                    <a href="#" class="btn">Подробнее</a>
                                </p>
                                <img class="list-bottom-bg" src="/pics/bg/list/deposit.png">
                            </div>
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
