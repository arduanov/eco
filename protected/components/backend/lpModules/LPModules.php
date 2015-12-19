<?php

    class LPModules extends CWidget {

        public $page_id = false;
        public $code = false;
        public $module_id = null;

        public function run() {

            $this->render('lpModules', array( 'page_id' => $this->page_id, 'code' => $this->code, 'module_id' => $this->module_id));

        }
    }