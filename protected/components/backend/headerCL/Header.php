<?php

class Header extends CWidget {

    public $title;
    
    public function run() {

        if(empty($this->title))
            $this->title = '������� ����������';

        $this->render('header', array('title'=>$this->title));

    }
}

