<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jo
 * Date: 25.04.12
 * Time: 6:44
 * To change this template use File | Settings | File Templates.
 */


class RequestForm extends CFormModel
{

    /* Форма заявки на товар */
    public $if_name;
    public $if_email;
    public $if_phone;
    public $if_city;
    public $if_address;
    public $if_comments;
    public $comments;

    public $f_check_org;
    public $f_check_inn;
    public $f_check_kpp;

    public $unknow;

    public $del = null;

    public function rules()
    {
        return array(
            array('if_name, if_email, if_phone, if_city, if_address', 'required'),
            array('if_comments', 'required', 'on' => 'request'),
            array('unknow', 'required', 'on' => 'unknow'),
            
            array('del', 'delCheck', 'on' => 'order'),
            //array('f_money_name', 'match', 'pattern'=>'/^([а-яА-Я0-9_ ])+$/', 'on'=>'OrderCash'),

            array('f_check_inn, f_check_kpp, f_check_org', 'required', 'on'=>'orderCashless'),

            array('f_check_inn, f_check_kpp', 'numerical', 'integerOnly'=>true, 'on'=>'orderCashless'),
            array('f_check_inn', 'length', 'is'=>10, 'on'=>'orderCashless'),
            array('f_check_kpp', 'length', 'is'=>9, 'on'=>'orderCashless'),

            array('if_phone', 'match', 'pattern'=>'/^([+]?[0-9 \-]+)$/'),
            array('if_email', 'email'),
            array('if_address, if_phone, if_name, f_check_org, if_email, if_city, unknow, if_comments, comments, del', 'safe'),
        );
    }

    public function delCheck($attribute,$params)
    {
        if(empty($this->del)){
            $this->addError('del','Необходимо выбрать <strong>«Способ доставки»</strong>.');
        }
    }


    public function attributeLabels()
    {
        return array(
            'if_name' => 'Имя получателя',
            'if_email' => 'Электронная почта',
            'if_phone' => 'Контактный телефон',
            'if_city' => 'Магазин',
            'if_address' => 'Адрес',
            'if_comments' => 'Интересующий вас товар',
            'comments' => 'Комментарий',
            'unknow' => 'Нужный способ оплаты',    
            
            'f_check_org' => 'Название организации',
            'f_check_inn' => 'ИНН',
            'f_check_kpp' => 'КПП',
        );
    }

}