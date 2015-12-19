<h1 class="pTitle">Редактирование акции</h1>
<div class="actionsList">
    <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin.php?r=/pages/update&id=<?php echo $page_id;?>">Назад к редактированию раздела</a>
    <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/action/create&page_id=<?php echo $page_id;?>">Добавить акцию</a>
</div>

<?php echo $this->renderPartial('_form', array('page_id'=>$page_id, 'model'=>$model, 'images' => $images)); ?>