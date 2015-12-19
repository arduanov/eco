<?php

class MainController extends BaseController
{
	public function actionIndex()
	{
            $criteria = new CDbCriteria();
            $criteria->order = "date desc";
            $count = ModuleOrders::model()->count($criteria);
            $pages = new CPagination($count);

            // results per page
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);    
            $data = ModuleOrders::model()->findAll($criteria);

            $this->render('index', array('data' => $data, 'pages' => $pages));
	}
}