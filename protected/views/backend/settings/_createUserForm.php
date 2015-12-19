<a href="/admin.php?r=settings/users">&larr; Назад</a>
<div class="form">
	<form id="createUser-form" action="" method="post">
		<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>
		<?if($type=='update'){?><p class="note">Если поле с паролем не заполнено, то пароль не меняется.</p><?}?>
		<div class="edit_line">
			<label for="Users_login" class="required">Логин <span class="required">*</span></label>
			<div class="inpC">
				<input maxlength="255" class="inp" name="Users[login]" id="Users_login" type="text" value="<?=$model['login']?>">
			</div>
			<?=$error['login']?>
		</div>
<?
	if($role_id==1){
?>
		<div class="edit_line">
			<label for="Users_username" class="required">Имя пользователя</label>
			<div class="inpC">
				<input maxlength="255" class="inp" name="Users[username]" id="Users_username" type="text" value="<?=$model['username']?>">
			</div>
		</div>
		<div class="edit_line lastLine">
            <label for="Users_role_id" class="required">Группа пользователей <span class="required">*</span></label>
			<div class="inpC">
                <select class="inp" name="Users[role_id]" id="Users_role_id">
				<?foreach($roles as $k=>$v){
					$selected = '';
					if($model['role_id']==$k) $selected = ' selected="selected"';
					echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>';
				}?>
				</select>
			</div>
			<?=$error['role_id']?>
		</div>
		<div class="edit_line checkboxLine">
			<input name="Users[state]" id="Users_state" value="1"<?=($model['state'])?' checked="checked"':''?> type="checkbox">
			<label class="labelCheckbox" for="Users_state">Активен</label>
			<?=$error['state']?>
		</div>
<?
	};
	if(!$model->isNewRecord && $role_id==1):?>
        <dl class="slideRow">
            <dt><a href="javascript://void(0)" class="onPage<?=(!empty($error['old_password']) || !empty($error['password']) || !empty($error['password_replace']) || !empty($error['password_equal']))?' open':''?>"><span>Изменение пароля</span></a></dt>
            <dd<?=(!empty($error['old_password']) || !empty($error['password']) || !empty($error['password_replace']) || !empty($error['password_equal']))?' style="display:block"':''?>>
                <fieldset>
                    <!--div class="edit_line">
						<label for="Users_old_password" class="">Старый пароль</label>
                        <div class="inpC">
							<input maxlength="255" class="inp" name="Users[old_password]" id="Users_old_password" type="password" value="">
                        </div>
                        <?=$error['old_password']?>
                    </div-->
                    <div class="edit_line">
                        <label for="Users_password" class="required">Пароль<?if($type!='update'){?> <span class="required">*</span><?}?></label>
                        <div class="inpC">
                            <input maxlength="255" class="inp" name="Users[password]" id="Users_password" type="password" value="<?=$model['password']?>">
                        </div>
                        <?=$error['password']?>
                    </div>
                    <div class="edit_line">
                        <label for="Users_password_replace" class="required">Повторно введите пароль<?if($type!='update'){?> <span class="required">*</span><?}?></label>
                        <div class="inpC">
                            <input maxlength="255" class="inp" name="Users[password_replace]" id="Users_password_replace" type="password" value="">
                        </div>
                        <?=$error['password_replace']?>
                        <?=$error['password_equal']?>
                    </div>
                </fieldset>
            </dd>
        </dl>
    <?else:?>
        <div class="edit_line">
            <label for="Users_password" class="required">Пароль<?if($type!='update'){?> <span class="required">*</span><?}?></label>
            <div class="inpC">
                <input maxlength="255" class="inp" name="Users[password]" id="Users_password" type="password" value="<?=$model['password']?>">
            </div>
            <?=$error['password']?>
        </div>
        <div class="edit_line">
            <label for="Users_password_replace" class="required">Повторно введите пароль<?if($type!='update'){?> <span class="required">*</span><?}?></label>
            <div class="inpC">
                <input maxlength="255" class="inp" name="Users[password_replace]" id="Users_password_replace" type="password" value="">
            </div>
            <?=$error['password_replace']?>
            <?=$error['password_equal']?>
        </div>
    <?endif;?>
<?
	if($role_id==1){
?>
		<dl class="slideRow">
			<dt><a href="javascript://void(0)" class="onPage"><span>Дополнительные Параметры</span></a></dt>
			<dd>
				<fieldset>
					<div class="edit_line">
						<label for="Users_email">Электронная почта</label>
						<div class="inpC">
							<input maxlength="255" class="inp" name="Users[email]" id="Users_email" type="text" value="<?=$model['email']?>">
						</div>
						<?=$error['email']?>
					</div>
				</fieldset>
			</dd>
		</dl>
<?
	}
?>
		<div class="row buttons">
			<?=($model->isNewRecord)?'<input style="float:left;" type="submit" name="yt0" value="Сохранить">':'<input style="float:left;" type="submit" name="yt0" value="Обновить">'?>
			<?if(!empty($success)) echo '<h2 style="color:#00bb00; float:left; margin:5px 0 0 20px;">'.$success.'</h2>';?>
		</div>
	</form>​
</div><!-- form -->
