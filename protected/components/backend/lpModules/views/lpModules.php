<?php $action = Yii::app()->getModule($code);?>
<?php $controller = Yii::app()->createController($action->id.'/'.'main');?>
<?php echo $controller[0]->actionIndex($page_id, $module_id); ?>
