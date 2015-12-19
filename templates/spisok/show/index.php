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
                    <h1 class="headline withNav">Заголовок списка <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
                    <div class="page-content">
                        <div class="pad-content">
                            <h2 class="headline">Заголовок элемента</h2>
                            <p>&laquo;ЭКОПРОМБАНК&raquo; предоставляет возможность осуществления платежей в&nbsp;адрес любых организаций, предоставляющих свои услуги:</p>
                            <ul>
                                <li>Квартплата</li>
                                <li>Электроэнергия</li>
                                <li>Интернет-услуги</li>
                                <li>Услуги пейджинговой связи</li>
                                <li>Туристические услуги</li>
                                <li>Медицинские услуги</li>
                                <li>Услуги страхования</li>
                                <li>Нотариальные услуги</li>
                                <li>Услуги детских садов, кружков, школ, институтов и&nbsp;т.д.</li>
                                <li>Налоговые платежи</li>
                                <li>Обучение</li>
                                <li>Благотворительные взносы</li>
                            </ul>
                            <p><em>Примечания:</em></p>
                            <ul>
                                <li>Для осуществления платежей за&nbsp;вышеперечисленные услуги необходимо точно знать платежные реквизиты получателя и&nbsp;заполнить платежный документ, являющийся поручением для проведения операции.</li>
                                <li>При перечислении платежа в&nbsp;адрес организации, с&nbsp;которой у&nbsp;банка заключен договор, комиссионное вознаграждение не&nbsp;взимается.</li>
                                <li>При перечислении платежа в&nbsp;адрес организации, с&nbsp;которой у&nbsp;банка не&nbsp;заключен договор, комиссионное вознаграждение составляет 1,5%.</li>
                                <li>При перечислении налоговых, бюджетных и&nbsp;иных подобных платежей, комиссионное вознаграждение с&nbsp;плательщика не&nbsp;взимается.</li>
                            </ul>
                            <div class="back">
                                <a href="#" class="prev">Перейти к списку услуг</a>
                            </div>
                            <h2>Контакты</h2>
                            <p>Отдел розничных операций:&nbsp;(342) 200-79-77</p>
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
