<?php

class ActionsModule extends CWebModule
{
	public function init()
	{
        /* Add module css file */
        $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'actions.css';
        Yii::app()->clientScript->registerCssFile(Yii::app()->getAssetManager()->publish($file));

		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'actions.models.*',
			'actions.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            $controller->module_id = Modules::model()->getModuleIdByCode($this->id);
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
    public function deactivation($page_id = null){
        $result = false;
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink($page_id, $this->id);
            if($link_id) $result = ModuleActions::model()->deactivation($link_id);
        }
		return $result;
    }
}
