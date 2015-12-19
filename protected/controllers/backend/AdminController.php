<?php
/*
 * @author: Kirilov Eldar
 * @company: reaktive
 * @comment: backend app config file
 *
 */
 
class AdminController extends BackEndController {

    public $layout='main';

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionIndex() {
		$this->pageTitle = 'Система управления сайтом '.CHtml::encode(Yii::app()->name);
        $this->render('index');
	}

    public function actionError()
	{
        $this->layout = 'error';
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

}