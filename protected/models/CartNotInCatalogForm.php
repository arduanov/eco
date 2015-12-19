<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 22.03.12
 * Time: 19:01
 * To change this template use File | Settings | File Templates.
 */

class CartNotInCatalogForm extends CFormModel
{
    public $count;
    public $name;

    public function rules()
    {
        return array(

            array('count, name', 'required', 'on'=>'AddNotInCatalog, ReplaceNotInToCart'),
            array('name', 'required', 'on'=>'RemoveNotInCatalog'),
            array('name', 'safe', 'on'=>'RemoveNotInCatalog'),
            array('count, name', 'safe', 'on'=>'AddNotInCatalog, replaceNotInToCart'),
        );
    }
}