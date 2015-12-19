<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
?>
<header>
    <div class="container">
        <div class="pad cf">
            <h1 class="appTitle"><?=CHtml::encode(Yii::app()->name); ?>
            <span style="float: right; display: block; text-align: right; font-size: 12px; font-weight: normal;">
                   <?='Вы вошли как:&nbsp;&nbsp;<strong>'.Yii::app()->user->name.'</strong>';?>
            </span>
            </h1>
			<?
			$menu_url = explode('/',$_GET['r']);
			$menu_url = $menu_url[0];
			?>
            <div class="headerBottom cf">
                <div class="hRight">
                    <nav>
                        <ul>
                            <?if ($role_id!=7):?>
                            <li class="settings"><?=($menu_url!='settings' && $menu_url!='cache')?'<a href="/admin.php?r=settings/main">':'<span>'?>Настройки<?=($menu_url!='settings' && $menu_url!='cache')?'</a>':'</span>'?></li>
                            <?endif;?>
                            <li class="exit"><a href="<?echo Yii::app()->request->baseUrl; ?>/admin.php?r=access/logout">Выход</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="hLeft">
                    <nav class="cf">
                        <ul>
                            <!-- добавить класс li.active, li.activeLink -->
                            <li>
								<?=($_GET['r']!='')?'<a href="/admin.php">':'<span>'?>Главная<?=($_GET['r']!='')?'</a>':'</span>'?>
							</li>
							<? if($role_id!=7):?>
							<li>
								<?=($_GET['r']!='/banner/default/')?'<a href="/admin.php?r=/banner/default/">':'<span>'?>Баннеры<?=($_GET['r']!='/banner/default/')?'</a>':'</span>'?>
							</li>
							<?endif; ?>
                            <?if($role_id<2):?>
								<li>
									<?=($_GET['r']!='files/clearfiles')?'<a href="/admin.php?r=files/clearfiles">':'<span>'?>Удаление неиспользуемых файлов<?=($_GET['r']!='files/clearfiles')?'</a>':'</span>'?>
								</li>
							<?endif;?>
							<? /*
							<li>
								<?=($menu_url!='xml')?'<a href="/admin.php?r=xml/main">':'<span>'?>Обновить каталог<?=($menu_url!='xml')?'</a>':'</span>'?>
							</li>
                            <li>
								<a href="/admin.php?r=/importcsv/default/rest/">Обновить цены</a>
							</li>
							<li>
								<?=($_GET['r']!='/catalog/main/')?'<a href="/admin.php?r=/catalog/main/">':'<span>'?>Готовые решения<?=($_GET['r']!='/catalog/main/')?'</a>':'</span>'?>
							</li>
							<li>
								<?=($_GET['r']!='/orders/main/')?'<a href="/admin.php?r=/orders/main/">':'<span>'?>Заказы<?=($_GET['r']!='/orders/main/')?'</a>':'</span>'?>
							</li>
							*/ ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>