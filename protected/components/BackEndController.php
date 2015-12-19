<?php
/*
 * @author: Kirilov Eldar
 * @company: reaktive
 * @comment: backend app config file
 *
 */
 

class BackEndController extends BaseController
{

    public $module_id = null;

    // лейаут
    public $layout = 'main';

    // меню
    public $menu = array();

    // крошки
    public $breadcrumbs = array();

    /*
        Фильтры
    */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /*
        Права доступа
    */
    public function accessRules()
    {
        return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                        'actions'=>array('install','login', 'logout', 'view', 'error'),
                        'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array('success', 'DeletePhotoById', 'UploadImageToAlbum', 'upload','GetProductsFromCategory', 'activation', 'deactivation', 'uploadImage', 'access','updateUser','unLinked', 'FileUpload', 'linked','admin','Modules','delete', 'deleteUser', 'index', 'view','create','update', 'error', 'main', 'mainUpdate', 'users', 'createUser','rest','ClearFiles','updatePrices','activate','deactivate','active','deactive','activate_in_order','deactivate_in_order','update_positions','update_remains','update_settings','delete_photo','load_flats','set_bought','unset_bought','settings','show','delete_point','activate_point','deactivate_point','params','update_value','delete_value','uploadFile','list4','import_csv'),
                        'users'=>array('@'),
                ),
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),
        );
    }
}