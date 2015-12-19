    <?if(Yii::app()->user->login == 'reaktive'):?>
                <fieldset>
                    <?foreach($data as $key => $value):?>
                        <div class="edit_line checkboxLine" >
                            <label class="labelCheckbox one" ><?php echo $value['name'];?> (<a href="<?php echo YII::app()->baseUrl;?>/admin.php?r=<?php echo $value['code'];?>/main/<?=((int)$value['active'] == 1)?'deactivation&page_id='.$page_id:'activation&page_id='.$page_id;?>" id="<?=$value['code'];?>_control" <?=((int)$value['active'] == 1)?'onclick="return confirm(\'Вы действительно хотите деактивировать модуль?\')"':'';?> style="color:<?=((int)$value['active'] == 1)?'#0B0':'red';?>"><?=((int)$value['active'] == 1)?'Деактивировать':'Активировать';?></a>)</label>
                        </div>
                    <?endforeach;?>
                </fieldset>
    <?endif;?>
