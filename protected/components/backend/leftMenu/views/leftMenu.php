<?
// роль авторизованного пользователя
$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
$page_id = explode('pages/update',$_GET['r']);
if(count($page_id)>1) $page_id = $_GET['id'];
	else $page_id = 0;
if(isset($_GET['page_id'])) $page_id = $_GET['page_id'];
?>
<aside class="mLeft">
    <div class="pad">
        <nav class="jsTree">
            <ul class="lvl1">
                <?php
                    function showTree(&$data,$page_id,$role_id){
                        foreach($data  as $key => $value){
                            if ($role_id==7 && $key!=1)
                                continue;
							if($page_id==$key) $link = '<span style="color:#F15A22">'.$value['name'].'&nbsp;('.$key.')</span>';
								else $link = '<a href="'.Yii::app()->request->baseUrl.'/admin.php?r=pages/update&id='.$key.'">'.$value['name'].'</a>&nbsp;('.$key.')';
							if($value['active']=='0') $link = '<span style="color:#CCC;">'.$link.'</span>';
							if(ModulesInPages::model()->find('page_id = '.$key)) $link = '<b>'.$link.'</b>';
							if(count($value['child']) > 0){
								echo '<li>'.$link.'&nbsp;<a href="'.Yii::app()->request->baseUrl.'/admin.php?r=pages/delete&id='.$key.'" onclick="return confirm(\'Вы действительно хотите удалить страницу ?\')"><img src=\'/admin/pics/i/del-small.png\' alt="Удалить раздел" class="deletePage"></a></li>';
								echo '<ul class="lvl2">';
									showTree($value['child'],$page_id,$role_id);
								echo '</ul>';
							} else {
								  echo '<li>'.$link.'&nbsp;<a href="'.Yii::app()->request->baseUrl.'/admin.php?r=pages/delete&id='.$key.'" onclick="return confirm(\'Вы действительно хотите удалить страницу ?\')"><img src=\'/admin/pics/i/del-small.png\' alt="Удалить раздел" class="deletePage"></a></li></li>';
							}
                        }
                    }
                    showTree($pages,$page_id,$role_id);
                 ?>
            </ul>
        </nav>
    </div>

    <div class="bottomPad">
        <?if($role_id!=7):?>
        <!--a href="javascript:void(0)" class="onPage opened" id="allTreeTrigger"><span class="openAll">Развернуть</span><span class="closeAll">Свернуть</span></a-->
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin.php?r=pages/create" class="buttonLink">Добавить раздел</a>
        <?endif;?>
    </div>

</aside>