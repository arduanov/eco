<?php

return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),

    array(


        'language' => 'ru',
        'sourceLanguage' => 'ru',

        // стандартный контроллер
        'defaultController' => 'main',
        'modules'=>array(
            'xml',
            'helper'
        ),
        // компоненты
        'components'=>array(
            'thumb'=>array(
                'class'=>'ext.EPhpThumb.EPhpThumb',
            ),
            'mailer' => array(
                'class' => 'application.extensions.mailer.EMailer',
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                //'class' => 'application.components.ReUrlManager',
                'rules'=>array(
					'ajax/<id:\w+>' => 'ajax/<id>/',
					'search' => 'main/search/',
					'basket' => 'main/basket/',
					'orders/h/<id:\w+>' => 'main/orders/h/<id>/',
					'orders/h/<id:\w+>/type/<id2:\w+>' => 'main/orders/h/<id>/type/<id2>/',
            		'<id:\w+>/<id2:\w+>/<id3:\w+>/<id4:\w+>/<id5:\w+>' => 'main/index/<id>/<id2>/<id3>/<id4>/<id5>/',
            		'<id:\w+>/<id2:\w+>/<id3:\w+>/<id4:\w+>' => 'main/index/<id>/<id2>/<id3>/<id4>/',
            		'<id:\w+>/<id2:\w+>/<id3:\w+>' => 'main/index/<id>/<id2>/<id3>/',
            		'<id:\w+>/<id2:\w+>' => 'main/index/<id>/<id2>/',
					'<id:\w+>' => 'main/index/<id>/',
                ),
            ),
            'errorHandler'=>array(
                'errorAction'=>'main/error',
            ),
            // пользователь
            'user'=>array(
                'loginUrl'=>array('/site/login'),
            ),

            // site
            'site'=>array(
                'pathViews' => 'application.views.frontend.site',
                'pathLayouts' => 'application.views.email.frontend.layouts'
            ),

        ),
    )
);
