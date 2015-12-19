<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 13.03.12
 * Time: 15:16
 * To change this template use File | Settings | File Templates.
 */

class Meta extends CWidget {

    public $title = '';
    public $keywords = '';
    public $description = '';

    public function run() {

        if($meta = ModuleSeo::model()->compareUrl($_SERVER['REQUEST_URI'])){
            $this->title = $meta->title;
            $this->keywords = $meta->keywords;
            $this->description = $meta->description;
        }

        $this->render('meta', array('title' => $this->title, 'keywords' => $this->keywords, 'description' => $this->description));

    }
}