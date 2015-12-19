<aside class="mLeft">
    <div class="pad">
        <nav class="jsTree">
            <ul class="lvl1">
                <?if($action == 'main'):?>
                <li><span>Основные настройки</span></li>
                <?if(Users::model()->findByPk(Yii::app()->user->id)->role_id==1 || Users::model()->findByPk(Yii::app()->user->id)->role_id==2):?>
                <li><a href="<?php echo Yii::app()->request->baseUrl.'/admin.php?r=settings/users'; ?>">Управление пользователями</a></li>
                <?endif;?>
                <?elseif($action == 'modules'):?>
                <li><a href="<?php echo Yii::app()->request->baseUrl.'/admin.php?r=settings/main'; ?>">Основные настройки</a></li>
                <?//if(Yii::app()->user->login == 'reaktive'):?>
                <li><span>Управление модулями</span></li>
                <?if(Users::model()->findByPk(Yii::app()->user->id)->role_id==1 || Users::model()->findByPk(Yii::app()->user->id)->role_id==2):?>
                <li><a href="<?php echo Yii::app()->request->baseUrl.'/admin.php?r=settings/users'; ?>">Управление пользователями</a></li>
                <?endif;?>
                <?elseif($action == 'users'):?>
                <li><a href="<?php echo Yii::app()->request->baseUrl.'/admin.php?r=settings/main'; ?>">Основные настройки</a></li>
                <li><span>Управление пользователями</span></li>
                <?else:?>
                <li><a href="<?php echo Yii::app()->request->baseUrl.'/admin.php?r=settings/main'; ?>">Основные настройки</a></li>
                    <?if(Users::model()->findByPk(Yii::app()->user->id)->role_id==1 || Users::model()->findByPk(Yii::app()->user->id)->role_id==2):?>
                <li><a href="<?php echo Yii::app()->request->baseUrl.'/admin.php?r=settings/users'; ?>">Управление пользователями</a></li>
                <?endif;?>
                <?endif;?>
                <?/*<li><?=($_GET['r']!='cache/main')?'<a href="/admin.php?r=cache/main">':'<span>'?>Очистка кэша<?=($_GET['r']!='cache/main')?'</a>':'</span>'?></li>*/?>
            </ul>
        </nav>
    </div>
    <div class="bottomPad">
    </div>
</aside>