<?php $this->widget('application.components.backend.header.Header', array('title'=>$this->pageTitle)); ?>
<body>
<div id="container">
    <?if(!Yii::app()->user->isGuest):?>
    <?php $this->widget('application.components.backend.topMenu.TopMenu'); ?>
    <?endif;?>
    <div id="main" role="main">
        <div class="container">
            <div class="pad cf">
                <?if(!Yii::app()->user->isGuest):?>
                <?if($this->id == 'settings' || $this->module->id == 'cache'):?>
                    <?php $this->widget('application.components.backend.settingsLeftMenu.LeftMenu', array('action'=>$this->action->id)); ?>
                    <?else:?>
                    <?php $this->widget('application.components.backend.leftMenu.LeftMenu'); ?>
                    <?endif;?>
                <?endif;?>
                <div class="mContent">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
    <?if(!Yii::app()->user->isGuest):?>
    <?php $this->widget('application.components.backend.footer.Footer'); ?>
    <?endif;?>
</div>
<?php $this->widget('application.components.backend.down.Down'); ?>
</body>
</html>

