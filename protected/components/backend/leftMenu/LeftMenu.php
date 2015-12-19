<?php

    class LeftMenu extends CWidget {

        public function run() {

            $pages = array();

            $pages = Pages::model()->getTreePages2(false);

            $this->render('leftMenu',array('pages'=>$pages));

        }
    }
 
