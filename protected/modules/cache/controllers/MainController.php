<?php

class MainController extends BaseController
{
	public function actionIndex()
	{
            Yii::app()->cache->flush();
            $this->render('index');
	}
}