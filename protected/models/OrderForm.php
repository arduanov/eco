<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 21.03.12
 * Time: 18:30
 * To change this template use File | Settings | File Templates.
 */

class OrderForm extends CFormModel
{

    /* Форма расчёта по пластику */

    public $f_card_name;
    public $f_card_phone;
    public $f_card_address;
    public $f_card_email;

    /* Форма безналичного расчёта */

    public $f_check_name;
    public $f_check_phone;
    public $f_check_address;
    public $f_check_org;
    public $f_check_inn;
    public $f_check_kpp;
    public $f_check_email;

    /* Форма расчёта наличными курьером */

    public $f_money_name;
    public $f_money_phone;
    public $f_money_address;
    public $f_money_email;

    public function rules()
    {
        return array(
            array('f_money_name, f_money_phone, f_money_address', 'required', 'on'=>'OrderCash'),
            //array('f_money_name', 'match', 'pattern'=>'/^([а-яА-Я0-9_ ])+$/', 'on'=>'OrderCash'),
            array('f_money_phone', 'match', 'pattern'=>'/^([+]?[0-9 \-]+)$/', 'on'=>'OrderCash'),
            array('f_money_address, f_money_phone, f_money_name', 'safe', 'on'=>'OrderCash'),

            array('f_check_name, f_check_phone, f_check_address, f_check_org, f_check_inn, f_check_kpp', 'required', 'on'=>'orderCashless'),
            //array('f_check_name', 'match', 'pattern'=>'/^([а-яА-Я0-9_ ])+$/', 'on'=>'orderCashless'),
            array('f_check_phone', 'match', 'pattern'=>'/^([+]?[0-9 \-]+)$/', 'on'=>'orderCashless'),
            array('f_check_name, f_check_phone, f_check_address, f_check_org, f_check_inn, f_check_kpp', 'safe', 'on'=>'orderCashless'),
            array('f_check_inn, f_check_kpp', 'numerical', 'integerOnly'=>true, 'on'=>'orderCashless'),
            array('f_check_inn', 'length', 'is'=>10, 'on'=>'orderCashless'),
            array('f_check_kpp', 'length', 'is'=>9, 'on'=>'orderCashless'),
            array('f_check_email, f_money_email', 'email'),
        );
    }

    public function attributeLabels()
    {
        return array(

            'f_money_name' => 'Представьтесь, пожалуйста',
            'f_money_phone' => 'Контактный телефон',
            'f_money_address' => 'Адрес доставки',

            'f_check_name' => 'Представьтесь, пожалуйста',
            'f_check_phone' => 'Контактный телефон',
            'f_check_address' => 'Адрес доставки',
            'f_check_org' => 'Название организации',
            'f_check_inn' => 'ИНН',
            'f_check_kpp' => 'КПП',
            'f_money_email' => 'Электронная почта',
            'f_check_email' => 'Электронная почта',
        );
    }

}