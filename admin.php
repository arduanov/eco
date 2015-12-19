<?php
/*
 * @author: Kirilov Eldar
 * @company: reaktive
 * @comment: manage singelton
 *
 */

$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/backend.php';

/*
*  framework have two mode
* 1 - Debug
* 2 - Production
 *
 */
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
define('YII_ENABLE_ERROR_HANDLER',false);
require_once($yii);
Yii::createWebApplication($config)->runEnd('backend');
 
