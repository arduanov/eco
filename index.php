<?php
/**
 * @Date: 12.12.11
 * @Time: 18:22
 * @File: admin.php
 * @Author: Kirilov Eldar
 * @Modify: Kirilov Eldar
 * @ModifyDate: 12.12.11
 * @Studio: Reaktive
 * @Comments: Сингелтон frontend части сайта.
 */

// Тут всё понятно...
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/frontend.php';

/*
*  Фрейм поддерживает два режима рабоыты:
* 1 - Debug
* 2 - Production
 *
 */
defined('YII_DEBUG') or define('YII_DEBUG',false);
define('YII_ENABLE_ERROR_HANDLER',false);
define('YII_ENABLE_EXCEPTION_HANDLER.',false);
// Выбираем метод протоколирования а также его вложенность
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->runEnd('frontend');
