<div class="cf" style="margin-left: 20px;">
	<?
	$model = new Users();
	$role_id = $model->findByPk(Yii::app()->user->id)->role_id;
	if($role_id<=1):
	?>
    <div class="edit_line buttons">
        <button onclick="document.location.href = '<?php echo Yii::app()->baseUrl;?>/admin.php?r=settings/createUser'">Создать пользователя</button>
    </div>
	<?endif;?>
	<!--input type="text" name="search" style="width:300px"><input type="submit" value="Поиск"-->
	<?=$pagination?>
	<table class="users">
		<tbody class="header">
			<tr style="font-size: 16px; ">
				<th style="width: 200px;">Логин</th>
				<? if($role_id==1){?> <th style="width: 200px;">Роль</th> <?};?>
				<th style="width: 100px;">Действия</th>
			</tr>
		</tbody>
		<tbody class="pie">
		<?foreach($users as $key => $value):?>
			<tr<?=($value['login']==Yii::app()->user->login)?' style=""':''?>>
				<td>
					<a href="<?php echo Yii::app()->baseUrl;?>/admin.php?r=settings/updateUser&id=<?=$key;?>"><?=$value['login'];?></a>
				</td>
				<? if($role_id==1){?> <td><?=$value['role'];?></td> <?};?>
				<td>
					<!--span class="edit">
						<a href="<?php echo Yii::app()->baseUrl;?>/admin.php?r=settings/updateUser&id=<?=$key;?>">Редактировать</a>
					</span-->
					<span class="del">
						<a href="<?php echo Yii::app()->baseUrl;?>/admin.php?r=settings/deleteUser&id=<?=$key;?>" onclick="return confirm('Вы действительно хотите удалить пользователя «<?=$value['login'];?>»');">Удалить</a>
					</span>
				</td>
			</tr>
		<?endforeach;?>
		</tbody>
	</table>
	<?=$pagination?>
</div>