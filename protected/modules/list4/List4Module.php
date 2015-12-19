<?php

class List4Module extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'list4.models.*',
			'list4.components.*',
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

    public function getData($data,$link_id,$filter = array(),$order = 'date DESC') {
        $list4 = array();
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->condition = 'mpage_id = :mpage_id AND active > 0';
        foreach ($filter as $key => $value) {
            $criteria->condition .= ' AND '.$key.' '.$value;
        }
        $criteria->order = $order;
        $criteria->params = array('mpage_id' => $link_id);
        $res1 = ModuleList4::model()->findAll($criteria);
        unset($criteria);
        foreach ($res1 as $val) {
            $list4['items'][$val->id] = ModuleList4::model()->getList4($val->id,$link_id,3);

        }
        $data['list4'] = $list4;
        $criteria = new CDbCriteria();
        $criteria->select = 'date';
        $criteria->condition = 'mpage_id = :mpage_id AND active > 0';
        $criteria->params = array('mpage_id' => $link_id);
        $dates = array();
        foreach (ModuleList4::model()->findAll($criteria) as $val) {
            $dates[] = strtotime($val->date);
        }
        sort($dates);
        $arr = array();
        foreach ($dates as $date) {
            $y = intval(date('Y',$date));
            if (!isset($arr[$y])) {
                $arr[$y] = array();
            }
            $m = intval(date('n',$date));
            if (!isset($arr[$y][$m])) {
                $arr[$y][$m] = array();
            }
            $d = intval(date('j',$date));
            if (!in_array($d,$arr[$y][$m])) {
                array_push($arr[$y][$m],$d);
            }
        }
        $data['list4']['dates'] = $arr;
        return $data;
    }

    public function getParamByCode($item,$code) {
        foreach ($item['params'] as $param) {
            if ($param['code'] == $code) return $param;
            if ($param['data_type_id'] == 9) {
                if (!isset($param['values'])) continue;
                foreach ($param['values'] as $value) {
                    $p = $this->getParamByCode($value['value'],$code);
                    if (!is_null($p)) return $p;
                }
            }
        }
        return NULL;
    }

    public function getDataSubcats($data,$parent_id) {
        $groups = array();
        foreach(Pages::model()->findAllByAttributes(array('parent_id' => $parent_id)) as $page) {
            $mpage_id = 0;
            foreach ($page->mPage as $mpage) {
                if ($mpage->module_id == 9) $mpage_id = $mpage->id;
            }
            if ($mpage_id !== 0) {
                $groups[$page->id] = array(
                    'page_id' =>  intval($page->id),
                    'title' => $page->title,
                    'mpage_id' => intval($mpage_id),
                );
            }
        }
        $url = Pages::model()->make_url($parent_id);
        $params = substr(Yii::app()->request->pathInfo,strlen($url)-1);
        $params = explode('/',$params);
        $curGroup = $groups[key($groups)];
        if ($params[0] !== false) {
            if (array_key_exists(intval($params[0]),$groups)) {
                $curGroup = $groups[intval($params[0])];
            }
        }
        $data = $this->getData($data,$curGroup['mpage_id']);
        $data['list4']['groups'] = $groups;
        $data['list4']['curGroup'] = $curGroup;
        return $data;
    }
	
    public function deactivation($page_id = null){
        $result = false;
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink($page_id, $this->id);
            if($link_id) $result = ModuleList4::model()->deactivation($link_id, $this->id);
        }
		return $result;
    }
	
	public function activation($page_id = null, $settings = array()){
        if(!is_null($page_id)){
			$module_id = Modules::model()->getModuleIdByCode($this->id);
			ModulesInPages::model()->addLink($module_id, $page_id);
			$link_id = ModulesInPages::model()->getLink($page_id, $this->id);
			$model = new ModuleList4Settings();
			$settings['mpage_id'] = $link_id;
			$settings['title'] = Pages::model()->findByPk($page_id)->name;
			$model->attributes = $settings;
			$model->save();
		}
	}	
}
