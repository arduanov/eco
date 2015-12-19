<?php
/*
 * @author: Kirilov Eldar
 * @company: reaktive
 * @comment: backend app config file
 *
 */
 
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),

    array(
        'name'=>'ОАО АКБ «ЭКОПРОМБАНК»',
        'language' => 'ru',
        'defaultController' => 'admin',
        'modules'=>array(
            'actions',
            'banner',
            'cache',
            'catalog',
            'categories',
    		'fields',
    		'fields_files',
            'gallery',
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'password'=>'rktv_rktv',
                'ipFilters'=>array('*','::1'),
            ),
            'helper',
            'importcsv'=>array(
                'path'=>'upload/importCsv/', 
            ),
    		'list',
    		'list2',
    		'list3',
    		'list4',
            'mfiles',
    		'news',
            'orders',
    		'quotes',
    		'seo',
            'xml',
            'ymaps',
        ),

        // компоненты
        'components'=>array(
            'thumb'=>array(
                'class'=>'ext.EPhpThumb.EPhpThumb',
            ),
            'request'=>array(
                'enableCookieValidation'=>false,
                'enableCsrfValidation'=>false,
            ),
            // пользователь
            'user'=>array(
                'loginUrl'=>array('access/login'),
            ),
            'zip'=>array(
                'class'=>'application.extensions.zip.EZip',
            ),
            'file'=>array(
                'class'=>'application.extensions.file.CFile',
            ),
            // mailer
            'mailer'=>array(
                'pathViews' => 'application.views.backend.email',
                'pathLayouts' => 'application.views.email.backend.layouts'
            ),

            'errorHandler'=>array(
                'errorAction'=>'admin/error',
            ),
        ),
    )
);