<fieldset>
    <div class="actionsList">
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/project/create&page_id=<?php echo $page_id;?>">Добавить проект</a>
		<?php if (Yii::app()->user->login == 'reaktive'): ?>
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/category/create&page_id=<?php echo $page_id;?>">Добавить город</a>
		<?php endif;?>
    </div>
	<?php foreach ($data as $key => $value): ?>
    <p>
    <h4>
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/category/update&page_id=<?php echo $page_id;?>&id=<?php echo $key;?>"><?php echo ModuleProjectCategories::model()->findByPk($key)->name;?></a>
		<?php if (Yii::app()->user->login == 'reaktive'): ?>
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/category/delete&page_id=<?php echo $page_id;?>&id=<?php echo $key;?>"
           onclick=" return confirm('Вы действительно хотите удалить город?')" id="actions_delete"
           style="margin-left: 10px; font-size: 16px;">x</a>
		<?php endif;?>
    </h4>
	<?php foreach ($value as $vkey => $value_project): ?>
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/project/update&page_id=<?php echo $page_id;?>&id=<?php echo $vkey;?>"><?php echo $value_project['name'] . ' (' . $value_project['year'] . ')';?></a>
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/project/delete&page_id=<?php echo $page_id;?>&id=<?php echo $vkey;?>"
           onclick=" return confirm('Вы действительно хотите удалить проект ?')" id="actions_delete"
           style="margin-left: 10px; font-size: 16px;">x</a>&nbsp;<?php if($value_project['active']==0):?><i>Проект не активен</i><?php endif;?>
        <br/>
		<? endforeach; ?>
	<? endforeach;?>
</fieldset>
