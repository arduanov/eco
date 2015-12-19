<?php
/*
 * @author: Kirilov Eldar
 * @company: reaktive
 * @comment: backend app config file
 *
 */
 
class FrontEndController extends BaseController
{
    // лейаут
    public $layout = 'main';
    
    // меню
    public $menu = array();

    // крошки
    public $breadcrumbs = array();
}