<?php

    class LeftMenu extends CWidget {

        public $action;

        public function run() {

            $this->render('leftMenu', array('action' => $this->action));

        }
    }
 
