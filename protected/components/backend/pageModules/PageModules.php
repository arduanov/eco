<?php

    class PageModules extends CWidget {

        public $page_id = false;

        public function init(){
            $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pageModules.css';
            Yii::app()->clientScript->registerCssFile(Yii::app()->getAssetManager()->publish($file));
        }
        
        public function run() {

            $active = Modules::model()->getActiveModule($this->page_id);
            $data = Modules::model()->getAllModulesInPage($this->page_id);
            $this->render('pageModules', array('data' => $data, 'page_id' => $this->page_id, 'active' => $active));

        }
    }
 