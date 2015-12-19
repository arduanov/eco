<h1 class="pTitle">Управление пользователями</h1>

<?php echo $this->renderPartial('_usersForm', array('users'=>$users,'pagination'=>$pagination,'role_id'=>$role_id)); ?>
