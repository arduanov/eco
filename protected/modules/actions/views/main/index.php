<fieldset>
    <div class="moduleNews">
        <div class="actionsList">
            <a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/action/create&page_id=<?php echo $page_id;?>&module_id=<?php echo $this->module->id;?>">Добавить акцию</a>
        </div>
        <?php if(count($data) > 0):?>
                <?php foreach($data as $key => $value): ?>

                            <fieldset>
                                <table id="actions_tb">
                                    <thead>
                                        <tr>
                                            <th>Наименование</th>
                                            <th>Дата начала</th>
                                            <th>Дата окончания</th>
                                            <th>Активность</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($value as $ak => $action):?>
                                        <tr>
                                            <td><a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/action/update&page_id=<?php echo $page_id;?>&id=<?php echo $ak;?>&module_id=<?php echo $this->module->id;?>"><?php echo $action['name'];?><a/></td>
                                            <td><?php echo $action['date_begin'];?></td>
                                            <td><?php echo $action['date_end'];?></td>
                                            <td><?php echo ($action['active'] > 0)?'<span id="active">активна</span>':'<span id="noactive">неактивна</span>';?></td>
                                            <td align="left"><a href="<?php echo Yii::app()->baseUrl; ?>/admin.php?r=<?php echo $this->module->id;?>/action/delete&page_id=<?php echo $page_id;?>&id=<?php echo $ak;?>" onclick=" return confirm('Вы действительно хотите удалить акцию ?')" id="actions_delete">x</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </fieldset>
                <?php endforeach; ?>
        <?php endif;?>
</fieldset>
