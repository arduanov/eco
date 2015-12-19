<?php

class HelperModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'helper.models.*',
			'helper.components.*',
		));
	}

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $controller->module_id = Modules::model()->getModuleIdByCode($this->id);
            $controller->pageTitle = Modules::model()->getModuleNameByCode($this->id);
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

    public function deactivation($page_id = null){
        $result = false;
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink($page_id, $this->id);
            if($link_id) $result = ModuleHelper::model()->deactivation($link_id, $this->id);
        }
        return $result;
    }

    public function activation($page_id = null){
        if(!is_null($page_id)){
            $module_id = Modules::model()->getModuleIdByCode($this->id);
            ModulesInPages::model()->addLink($module_id, $page_id);
        }
    }
}
