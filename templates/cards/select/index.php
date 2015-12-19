<?
include $_SERVER['DOCUMENT_ROOT'] . "/templates/inc/meta.php";
?>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">Ваш браузер <strong>давно устарел</strong>. Пожалуйста <a href="http://browsehappy.com/">обновите
    браузер</a> или <a href="http://www.google.com/chromeframe/?redirect=true">установите Google Chrome Frame</a> для
    комфортной работы с этим сайтом.</p>
<![endif]-->
<div class="page-bg">
    <div class="page-container">
    <?
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/inc/header.php";
    ?>
    <div class="page-layout clearfix">
    <div class="breadcrumbs">
        <a href="#">Физическим лицам</a> — <a href="#">Банковские карты</a> — Помощник в выборе карты
    </div>
    <h1 class="headline">Помощник в выборе карты <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
    <?
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/inc/aside_fixed.php";
    ?>
    <div class="page-content fixed-aside">
        <div class="pad-content">
            <nav class="section-navigator js-navigator">
                <ul>
                    <li class="active"><a href="javascript:void(0)" class="onPage" data-cardtype="0">Все карты</a></li>
                    <li><a href="javascript:void(0)" class="onPage" data-cardtype="doc_40">Дебетовые карты</a></li>
                    <li><a href="javascript:void(0)" class="onPage" data-cardtype="doc_41">Кредитные карты</a></li>
                </ul>
            </nav>
            <div class="filter card-filter">
                <div class="filter-pad clearfix">
                    <div class="col first">
                        <div class="filter-block">
                            <h6>Срок выпуска карты</h6>
                            <label class="row">
                                <input type="radio" name="cardfilter[receipt]" value="12"> Моментально </label>
                            <label class="row">
                                <input type="radio" name="cardfilter[receipt]" value="13"> За 1 день </label>
                            <label class="row">
                                <input type="radio" name="cardfilter[receipt]" value="14"> За 3 дня </label>
                        </div>
                        <div class="filter-block">
                            <h6>Срок действия карты</h6>
                            <label class="row">
                                <input type="radio" name="cardfilter[duration]" value="15"> 12 месяцев </label>
                            <label class="row">
                                <input type="radio" name="cardfilter[duration]" value="16"> 24 месяца </label>
                            <label class="row">
                                <input type="radio" name="cardfilter[duration]" value="17"> 36 месяцев </label>
                        </div>
                    </div>
                    <div class="col first">
                        <div class="filter-block">
                            <h6>Валюта карты</h6>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[currency]" data-rel="additional-property" value="18"> Рубли
                            </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[currency]" data-rel="additional-property" value="19">
                                Доллары </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[currency]" data-rel="additional-property" value="20"> Евро
                            </label>
                        </div>
                        <div class="filter-block">
                            <h6>Кредитный лимит</h6>
                            <label class="row">
                                <input type="radio" name="cardfilter[limit]" value="21"> Не нужен </label>
                            <label class="row">
                                <input type="radio" name="cardfilter[limit]" value="22"> До 100 000 руб. </label>
                            <label class="row">
                                <input type="radio" name="cardfilter[limit]" value="23"> До 300 000 руб. </label>
                        </div>
                    </div>
                    <div class="col first">
                        <div class="filter-block">
                            <h6>Тип карты</h6>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="24"> Maestro
                            </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="25"> Mastercard
                                Standart </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="26"> Mastercard
                                Gold </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="27"> Mastercard
                                Platinum </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="28"> Visa
                                Electron </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="29"> Visa
                                Classic </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="30"> Visa Gold
                            </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[type]" data-rel="additional-property" value="31"> Visa
                                Platinum </label>
                        </div>
                    </div>
                    <div class="col first">
                        <div class="filter-block">
                            <h6>Дополнительные возможности</h6>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[features]" data-rel="additional-property" value="32">
                                Начисление % на остаток средств по карте </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[features]" data-rel="additional-property" value="33"> Снятие
                                наличных без комиссии </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[features]" data-rel="additional-property" value="34">
                                Начисление бонусных баллов </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[features]" data-rel="additional-property" value="35">
                                Возможность дополнительной карты </label>
                            <label class="row">
                                <input type="checkbox" name="cardfilter[features]" data-rel="additional-property" value="36">
                                SMS-сервис </label>
                        </div>
                    </div>
                </div>
                <!-- .filter-pad -->
                <div class="filter-reset">
                    <a href="javascript:void(0)"
                       class="onPage icon-link  js-filter-reset"><span>Сбросить настройки фильтра</span></a>
                </div>
            </div>
        <!-- .filter .card-filter -->
        <div class="remark remark-error empty-filter">
            <p>К сожалению, у нас еще нет карт с такими параметрами, попробуйте выбрать другие или <a
                    class="onPage js-filter-reset" href="javascript:void(0)">сбросить настройки фильтра</a></p>
        </div>
        <a href="javascript:void(0)" class="ctrlLeft"><span></span></a>
        <a href="javascript:void(0)" class="ctrlRight"><span></span></a>
        <div class="filter-list clearfix">
            <aside class="table-left">
                <table>
                    <tbody>
                        <tr data-id="-1">
                            <th class="table-card-type">Тип карты</th>
                        </tr>
                        <tr data-id="1">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_1/">Классическая карта Visa Electron</a></td>
                        </tr>
                        <tr data-id="2">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_2/">
                                <img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_card_big.png" height="70" alt="Классическая карта Maestro"></a>
                                <a href="/personal/cards/debet/show_2/">Классическая карта Maestro</a>
                            </td>
                        </tr>
                        <tr data-id="3">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_3/">Классическая карта Visa Сlassic</a></td>
                        </tr>
                        <tr data-id="7">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_7/">Классическая карта MasterCardStandard</a></td>
                        </tr>
                        <tr data-id="8">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_8/">Классическая карта Gold</a></td>
                        </tr>
                        <tr data-id="4">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_4/">
                                <img src="/upload/9e637728a390d0514ce9a589ae94132e/cache/size5_card_big13.png" height="70" alt="Кредитная карта 112 Standard"></a>
                                <a href="/personal/cards/debet/show_4/">Кредитная карта 112 Standard</a>
                            </td>
                        </tr>
                        <tr data-id="5">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_5/">Кредитная карта 112 Gold</a></td>
                        </tr>
                        <tr data-id="6">
                            <td class="table-card-type"><a href="/personal/cards/debet/show_6/">Практически-магическая карта</a></td>
                        </tr>
                    </tbody>
                </table>
            </aside>
            <aside class="table-right">
                <table>
                    <tbody>
                    <tr data-id="-1">
                        <th></th>
                    </tr>
                    <tr data-id="1">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="2">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="3">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="7">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="8">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="4">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="5">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
                        </td>
                    </tr>
                    <tr data-id="6">
                        <td>
                            <button class="btn btn-small" data-href="#">Заказать</button>
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
                            <th>Валюта карты</th>
                            <th>Стоим-ть годового обслуж.</th>
                            <th>Начисление % на остаток средств по карте</th>
                            <th>Снятие наличных без комиссии</th>
                            <th>Начисление бонусных баллов</th>
                            <th>Возможность дополнительной карты</th>
                            <th>SMS-сервис</th>
                            <th>Дополнительные возможности и ограничения</th>
                            <th>Кредитный лимит</th>
                            <th>Срок выпуска карты</th>
                            <th class="last">Срок действия карты</th>
                        </tr>
                        <tr data-id="1" class="doc_40" data-type="|28|" data-receipt="|14|"
                            data-duration="|15|" data-currency="|18|19|20|" data-limit="|21|" data-features="|33|35|36|">
                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                            <td class="table-card-currency">200 руб.<br>$5<br>€5</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td></td>
                            <td>Не нужен</td>
                            <td>За 3 дня</td>
                            <td>12 месяцев</td>
                        </tr>
                        <tr data-id="2" class="doc_40" data-type="|24|" data-receipt="|14|"
                            data-duration="|15|" data-currency="|19|" data-limit="|21|" data-features="|33|35|36|">
                            <td class="table-card-currency">Доллары</td>
                            <td class="table-card-currency">200 руб.<br>$5<br>€5</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td></td>
                            <td>Не нужен</td>
                            <td>За 3 дня</td>
                            <td>12 месяцев</td>
                        </tr>
                        <tr data-id="3" class="doc_40" data-type="|29|" data-receipt="|14|"
                            data-duration="|15|" data-currency="|18|19|20|" data-limit="|21|" data-features="|33|35|36|">
                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                            <td class="table-card-currency">600 руб.<br>$20<br>€20</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td></td>
                            <td>Не нужен</td>
                            <td>За 3 дня</td>
                            <td>12 месяцев</td>
                        </tr>
                        <tr data-id="7" class="doc_40" data-type="|25|" data-receipt="|14|"
                            data-duration="|15|" data-currency="|18|19|20|" data-limit="|21|" data-features="|33|35|36|">
                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                            <td class="table-card-currency">600 руб.<br>$20<br>€20</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td></td>
                            <td>Не нужен</td>
                            <td>За 3 дня</td>
                            <td>12 месяцев</td>
                        </tr>
                        <tr data-id="8" class="doc_40" data-type="|26|30|" data-receipt="|14|"
                            data-duration="|16|" data-currency="|18|19|20|" data-features="|33|35|36|">
                            <td class="table-card-currency">Рубли<br>Доллары<br>Евро</td>
                            <td class="table-card-currency">2100 руб.<br>$70<br>€70</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td></td>
                            <td></td>
                            <td>За 3 дня</td>
                            <td>24 месяца</td>
                        </tr>
                        <tr data-id="4" class="doc_41" data-type="|25|" data-receipt="|13|"
                            data-duration="|17|" data-currency="|18|" data-limit="|22|" data-features="|36|">
                            <td class="table-card-currency">Рубли</td>
                            <td class="table-card-currency">600 руб.</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><p>от 22 лет, граждане РФ, регистрация на территории Пермского края</p></td>
                            <td>До 100 000 руб.</td>
                            <td>За 1 день</td>
                            <td>36 месяцев</td>
                        </tr>
                        <tr data-id="5" class="doc_41" data-type="|26|" data-receipt="|13|"
                            data-duration="|17|" data-currency="|18|" data-limit="|23|" data-features="|36|">
                            <td class="table-card-currency">Рубли</td>
                            <td class="table-card-currency">2500 руб.</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><p>от 22 лет, граждане РФ, регистрация на территории Пермского края</p></td>
                            <td>До 300 000 руб.</td>
                            <td>За 1 день</td>
                            <td>36 месяцев</td>
                        </tr>
                        <tr data-id="6" class="doc_41" data-type="|25|" data-receipt="|13|"
                            data-duration="|17|" data-currency="|18|" data-limit="|23|" data-features="|34|36|">
                            <td class="table-card-currency">Рубли</td>
                            <td class="table-card-currency">600 руб.</td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><i class="icon icon-negative"></i></td>
                            <td><i class="icon icon-positive"></i></td>
                            <td><p>от 22 лет, граждане РФ, регистрация на территории Пермского края</p></td>
                            <td>До 300 000 руб.</td>
                            <td>За 1 день</td>
                            <td class="last">36 месяцев</td>
                        </tr>
                    </tbody>
                </table>
            <!-- .scrollTable -->
            </div>
        </div>
        <!-- .filter-list -->
        </div>
    <!-- .pad-content -->
    </div>
    <!-- .page-content -->
    </div>
    <!-- .page-layout -->
    <?
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/inc/footer.php";
    ?>
    </div>
<!-- .page-container -->
</div>
<!-- .page-bg -->
<?
include $_SERVER['DOCUMENT_ROOT'] . "/templates/inc/popup.php";
?>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/templates/inc/end.php";
?>
</body>
</html>
