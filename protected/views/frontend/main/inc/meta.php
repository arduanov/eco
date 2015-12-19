<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta charset="utf-8">
		<?
		if(empty($longtitle)) $longtitle = $title;
		?>
        <title><?=$code != 'index' ? $longtitle.' — ОАО АКБ «ЭКОПРОМБАНК»' : 'ОАО АКБ «ЭКОПРОМБАНК»'; ?></title>
		<meta name="keywords" content="<?=$meta_keywords?>">
        <meta name="description" content="<?=$meta_description?>">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="/css/normalize.min.css">
        <link rel="stylesheet" href="/css/main.css">
        <script src="/js/vendor/modernizr-2.6.2.min.js"></script>
        <!--[if gte IE 9]>
        <style type="text/css">
            .gradient {
                filter: none !important;
            }
        </style>
        <![endif]-->
    </head>