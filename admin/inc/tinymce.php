<script type="text/javascript" src="/admin/kcfinder/js/browser/joiner.php"></script>
<script type="text/javascript" src="/admin/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<script type="text/javascript">
tinyMCE.init({
		//Основные параметры
        mode : "specific_textareas",
		theme : "advanced",
		language : "ru",
		editor_selector : "mceEditorFull",
		file_browser_callback: 'openKCFinder',
		plugins : "typograf,spellchecker,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		//Параметры оформления
		/*
						theme_advanced_buttons5 : "table,|,row_props,cell_props,|,row_before,row_after,delete_row,|,col_after,col_before,delete_col,|,merge_cells,split_cells",
							то же самое, что и
						theme_advanced_buttons5 : "tablecontrols",
		*/
		theme_advanced_buttons1 : "typograf,|,save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,spellchecker,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "forecolor,backcolor,|,selectall,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
		//Подключение CSS
		content_css : "/css/tinymce.css",
		//Форматы стилей
		style_formats : [
			{title : 'Жирный текст', inline : 'b'},
			{title : 'Красный текст', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Красный заголовок', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Класс «example1»', inline : 'span', classes : 'example1'},
			{title : 'Стиль для таблиц'},
			{title : 'Класс «tablerow1» для строки', selector : 'tr', classes : 'tablerow1'},
			{title : 'Стиль для абзацев'},
			{title : 'Класс «example2»', selector : 'p', classes : 'example2'}
		],
		//Выпадающие списки для Ссылки/Изображения/Клипы/Шаблоны диалоговых окон
		external_link_list_url : "/admin/tinymce/lists/link_list.js",
		external_image_list_url : "/admin/tinymce/lists/image_list.js",
		media_external_list_url : "/admin/tinymce/lists/media_list.js",
		template_external_list_url : "/admin/tinymce/lists/template_list.js",
		//Значения переменных для шаблонов
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
});
tinyMCE.init({
		//Основные параметры
        mode : "specific_textareas",
		theme : "advanced",
		language : "ru",
		editor_selector : "mceEditor",
		file_browser_callback: 'openKCFinder',
		plugins : "typograf,autolink,lists,pagebreak,style,table,save,advimage,advlink,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",
		//Параметры оформления
		theme_advanced_buttons1 : "typograf,|,justifyleft,justifycenter,justifyright,justifyfull,|,bold,italic,underline,strikethrough,|,sub,sup,styleselect,formatselect, template,|,search,replace,|,cleanup,removeformat,preview,print,fullscreen",
		theme_advanced_buttons2 : "selectall,|,newdocument,|,cut,copy,paste,pastetext,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,hr,charmap,insertdate,inserttime,|,code",
		theme_advanced_buttons3 : "table,|,row_before,row_after,delete_row,|,col_after,col_before,delete_col,|,merge_cells,split_cells,|,visualaid",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
		//Подключение CSS
		content_css : "/css/tinymce.css",
		//Форматы стилей
		style_formats : [
			{title : 'Заголовок 2 без отступа сверху', selector : 'h2', classes : 'first'},
			{title : 'Заголовок 3 без отступа сверху', selector : 'h3', classes : 'first'}
		],
		//Список выбора формата
		theme_advanced_blockformats : "p,h1,h2,h3"
});
tinyMCE.init({
		language : "ru",
        mode : "specific_textareas",
		editor_selector : "mceEditorSimple",
        theme : "advanced",
		file_browser_callback: 'openKCFinder',
        plugins : "typograf,paste", 
        theme_advanced_buttons1 : "typograf,|,justifyleft,justifycenter,justifyright,justifyfull,|,bold,italic,underline,strikethrough,|,sub,sup,|,cut,copy,paste,pastetext,|,bullist,numlist,|,undo,redo",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
		//Подключение CSS
		content_css : "/css/tinymce.css",
		style_formats : [
			{title : 'Заголовок 2 без отступа сверху', selector : 'h2', classes : 'first'},
			{title : 'Заголовок 3 без отступа сверху', selector : 'h3', classes : 'first'}
		],
		theme_advanced_blockformats : "p,h1,h2,h3"
});
function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: '/admin/kcfinder/browse.php?opener=tinymce&lng=ru&type=' + type,
        title: 'KCFinder',
        width: 700,
        height: 500,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}
</script>