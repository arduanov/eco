<h1 class="pTitle">Редактирование пользователя</h1>

<?php echo $this->renderPartial('_createUserForm', array('model'=>$model, 'roles' => $roles, 'role_id' => $role_id, 'error' => $error, 'type' => 'update', 'success' => $success)); ?>