<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 20.03.12
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */

class CartForm extends CFormModel
{
    public $id;
    public $count;

    public function rules()
    {
        return array(

            array('id', 'required', 'on'=>'removeInCart'),
            array('id', 'numerical', 'integerOnly'=>true, 'on'=>'removeInCart'),

            array('id, count', 'required', 'on'=>'addToCart, replaceToCart'),
            array('id, count', 'numerical', 'integerOnly'=>true, 'on'=>'addToCart, replaceToCart'),
            array('count', 'numerical', 'min'=>1, 'max'=>512000, 'on'=>'addToCart, replaceToCart'),

            array('id', 'existProduct'),
        );
    }

    public function existProduct($attribute, $params){
        if(!ModuleCatalogProduct::model()->existsProduct($this->id)){
            $this->addError('id','Данный товар отсутствует в каталоге');
        }
    }


}