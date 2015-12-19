$(function () {
    var tabContainers = $('div.tabs > div,div.tabs > form > div'); // получаем массив контейнеров
	var rel = '';
	if(document.location.hash){
		var hash = document.location.hash;
		rel = hash.replace('#!/', '');
	}
	if(rel.substr(0,4)=='tab_'){
		var filter = '[href=#'+rel.substr(4)+']';
	}else{
		var filter = ':first';
	}
	var page_form_action = ($('#page-form').attr('data-action')!=undefined && $('#page-form').attr('data-action')!='');
	if(page_form_action){
		$('#page-form').attr('action',$('#page-form').attr('data-action')+'&/#!/tab_'+rel.slice(4));
	}
	tabContainers.hide().filter(filter).show(); // прячем все, кроме первого
	// далее обрабатывается клик по вкладке
	$('div.tabs ul.tabNavigation a').click(function () {
		if(page_form_action){
			$('#page-form').attr('action',$('#page-form').attr('data-action')+'&/#!/tab_'+$(this).attr('href').slice(1));
		}
		document.location.hash = '#!/tab_'+$(this).attr('href').slice(1);
		tabContainers.hide(); // прячем все табы
		tabContainers.filter(this.hash).show(); // показываем содержимое текущего
		$('div.tabs ul.tabNavigation a').parents('.tab_st').removeClass('selected'); // у всех убираем класс 'selected'
		$(this).parents('.tab_st').addClass('selected'); // текушей вкладке добавляем класс 'selected'
		return false;
	}).filter(filter).click();
});