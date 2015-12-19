<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 20.03.12
 * Time: 13:25
 * To change this template use File | Settings | File Templates.
 */

class SearchForm extends CFormModel
{
    public $query;

    public function rules()
    {
        return array(
            array('query', 'required'),
            array('query', 'length', 'min'=>2, 'max'=>127),
            array('query', 'safe'),
        );
    }

}