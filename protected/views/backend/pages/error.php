<h1 class="pTitle">Обнаруженые ошибки при <?=$action;?></h1>
	<dl class="slideRow">
        <dt><a href="javascript://void(0)" class="onPage open" style="color: red;"><span><?=$type;?></span></a></dt>
        <dd style="display: block;">
            <fieldset>
                    <ul>
                        <?foreach($error as $key => $value):?>
                            <li><a href="<?php echo Yii::app()->request->baseUrl;?>?r=pages/update&id=<?php echo $key;?>"><?=$value;?></a></li>
                        <?endforeach;?>
                    </ul>
            </fieldset>
        </dd>
    </dl>
