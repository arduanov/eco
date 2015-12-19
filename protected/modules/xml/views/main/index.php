<div class="form">
    <div class="tabs">
        <!-- Это сами вкладки -->
        <ul class="cf tabNavigation">
            <li class="tab_st"><a href="#catalog">Загрузка каталога</a></li>
        </ul>

        <div id="catalog">
            <fieldset>

                <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'page-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array('enctype'=>'multipart/form-data'),
                        'action' => Yii::app()->baseUrl.'?r=xml/main/upload/',
                    ));
                ?>

                <div class="edit_line buttons">
                    <?php echo CHtml::submitButton('Загрузить каталог'); ?>
                </div>

                <?php $this->endWidget(); ?>

            </fieldset>
        </div>
    </div>
</div>