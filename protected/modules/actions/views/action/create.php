<h1 class="pTitle">Создание акций</h1>
<div class="actionsList">
    <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin.php?r=/pages/update&id=<?php echo $page_id;?>">Назад к редактированию раздела</a>  
</div>

<?php echo $this->renderPartial('_form', array('page_id'=>$page_id, 'model'=>$model)); ?>