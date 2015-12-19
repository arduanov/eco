<?php

class SettingsController extends BackEndController {

    public $layout='main';
	
	/* ПАГИНАЦИЯ */
	protected function pagination($href,$count,&$page,$lim){
		$slipanie = TRUE;	//TRUE — в случае, когда «...» заменяет всего одну страницу, вместо «...» пишется та самая, заменяемая, страница; FALSE — «...» может заменять и всего одну страницу
		$next_button = FALSE;
		//$count - количество записей по запросу
		//$page — страница
		//$lim — количество записей на странице
		$near = 2; //количество страниц слева и справа от выбранной
		$begend = 1; //количество отображаемых страниц вначале и сконца
		$href_sufix = '';
		/*выполнение программы*/
		$maxpage = round($count/$lim);
		if($maxpage<$count/$lim) $maxpage++;
		if($page>$maxpage) $page=$maxpage;
		$pagination_menu = '';
		// $pagination_menu_prev = '<li><span class="prev">&larr;</span></li>';
		$pagination_menu_prev = '';
		// $pagination_menu_next = '<li><span class="next">&rarr;</span></li>';
		$pagination_menu_next = '';
		if($count > $lim){
			$pagination_menu = '';
			if($page-($near+$begend+1)>0){
				if($page>1) $pagination_menu_prev = '<li><a href="'.$href.($page-1).$href_sufix.'" class="prev">&larr;</a></li>';
				for($i=1; $i<$begend+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				/**/
				if($slipanie && $i+1==$page-$near){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				};
				/**/
				for($i=$page-$near; $i<$page; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
			};
			if($page-($near+$begend+1)<1){
				if($page>1) $pagination_menu_prev = '<li><a href="'.$href.($page-1).$href_sufix.'" class="prev">&larr;</a></li>';
				for($i=1; $i<$page; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
			};
			$pagination_menu .= '<li class="active"><span>'.$page.'</span></li>';
			if($page+($near+$begend)<$maxpage){
				for($i=$page+1; $i<$page+$near+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				/**/
				if($slipanie && $i==$maxpage-$begend){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				}else{
					$pagination_menu .= '<li><span>...</span></li>';
				};
				/**/
				for($i=$maxpage-$begend+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				if($page<$maxpage){
					$pagination_menu_next = '<li><a href="'.$href.($page+1).$href_sufix.'" class="next">&rarr;</a></li>';
					$next_button = TRUE;
				};
			};
			if($page+($near+$begend)>$maxpage-1){
				for($i=$page+1; $i<$maxpage+1; $i++){
					$pagination_menu .= '<li><a href="'.$href.$i.$href_sufix.'">'.$i.'</a></li>';
				};
				if($page<$maxpage){
					$pagination_menu_next = '<li><a href="'.$href.($page+1).$href_sufix.'" class="next">&rarr;</a></li>';
					$next_button = TRUE;
				};
			};
			$pagination_menu .= '';
		};
		if($pagination_menu!=''){
			/*$pagination_menu = '
				<div class="pTop">
					'.$pagination_menu_prev.$pagination_menu_next.'
				</div>
				<div class="pages">
					'.$pagination_menu.'
				</div>';*/
			$pagination_menu = '
				<nav class="paging">
					<ul><li class="name"><span>Страницы:</span></li>'.$pagination_menu_prev.$pagination_menu.$pagination_menu_next.'</ul>
				</nav>';
		};
		return $pagination_menu;
	}

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
		$this->pageTitle = 'Настройки';
        $this->render('index');
	}

    public function actionMain() {
        $this->pageTitle = 'Основные настройки сайта';
		
        $settings = new Settings();
        $model=  $settings->findByPk($settings->getActiveSettings());

        $this->render('main', array(
            'model'=>$model,
        ));
    }

    public function actionUpdateUser($id = 0){
		// все пользователи
		$users = new Users();
		// авторизованный пользователь
		$role_id = $users->findByPk(Yii::app()->user->id)->role_id;
		if($role_id<=2){
            if($id>0){
				// редактируемый пользователь
                $model = Users::model()->findByPk($id);
				$this->pageTitle = 'Редактирование пользователя — '.$model->login;
				if($model['role_id']>=$role_id){
					if(isset($_POST['Users'])){
						$success = '';
						$fields = array('login','username','role_id','state','old_password','password','password_replace','email');
						$error = array();
						$attributes = $_POST['Users'];
						if(empty($attributes['login'])){
							$error['login'] = 'Введите логин';
						}else{
							if($model->getCountUsers(0,'login="'.$attributes['login'].'" AND id!='.$id)) $error['login'] = 'Такой пользователь уже есть';
						};
						// if(empty($attributes['password'])) $error['password'] = 'Введите пароль';
						if(!empty($attributes['password']) && empty($attributes['password_replace'])) $error['password_replace'] = 'Повторите пароль';
						if(!empty($attributes['password']) && !empty($attributes['password_replace']) && $attributes['password']!=$attributes['password_replace']) $error['password_equal'] = 'Вы неправильно повторно ввели пароль';
						foreach($fields as $v){
							if(!isset($attributes[$v])){
								$attributes[$v] = $model[$v];
							};
						};
						if(count($error)==0){
							if(empty($attributes['password'])){
								unset($attributes['password']);
							}else{
								$attributes['password'] = md5($attributes['password']);
								$attributes['password_replace'] = md5($attributes['password_replace']);
							};
						};
						$model->attributes = $attributes;
						if(count($error)==0){
							try
							{
								$model->save();
								$model['password'] = '';
								$success = 'Сохранено';
								// $auth=Yii::app()->authManager;
								// $user = Yii::app()->request->getParam('Users');
								// $auth->assign($roles->getRoleCodeById($user['role_id']), $model->id);
								// $this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/users');
							}
							catch(Exception $e)
							{
							}
						}
					}else{
						$model['password'] = '';
					};
					if(count($error)>0){
						foreach($error as $k=>$v){
							$error[$k] = '<span class="errorMessage">'.$v.'</span>';
						};
					};
					$this->render('updateUser',array(
							'model'=>$model,
							'roles' =>Users::model()->getRoles(),
							'role_id' => $role_id,
							'error' => $error,
							'success' => $success
						));
				}else{
					$this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/access');
				}
            }
        }else
            $this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/access');

    }

    public function actionCreateUser(){
		$this->pageTitle = 'Создание пользователя';
		$model = new Users();
		$role_id = $model->findByPk(Yii::app()->user->id)->role_id;
		if($role_id<=2){
			$roles = new Roles();
			if(isset($_POST['Users'])){
				$fields = array('login','username','role_id','state','old_password','password','password_replace','email');
				$error = array();
				$attributes = $_POST['Users'];
				if(empty($attributes['login'])){
					$error['login'] = 'Введите логин';
				}else{
					if($model->getCountUsers(0,'login="'.$attributes['login'].'"')) $error['login'] = 'Такой пользователь уже есть';
				};
				if(empty($attributes['password'])) $error['password'] = 'Введите пароль';
				if(!empty($attributes['password']) && empty($attributes['password_replace'])) $error['password_replace'] = 'Повторите пароль';
				if(!empty($attributes['password']) && !empty($attributes['password_replace']) && $attributes['password']!=$attributes['password_replace']) $error['password_equal'] = 'Вы неправильно повторно ввели пароль';
				foreach($fields as $v){
					if(!isset($attributes[$v])){
						switch($v){
							case 'role_id':
								$attributes[$v] = 4;
								break;
							case 'state':
								$attributes[$v] = 1;
								break;
							default:
								$attributes[$v] = '';
						};
					};
				};
				if(count($error)==0){
					$attributes['password'] = md5($attributes['password']);
					$attributes['password_replace'] = md5($attributes['password_replace']);
				};
				$model->attributes = $attributes;
				if(count($error)==0){
					try
					{
						$model->save();
						$model['password'] = '';
						// $auth=Yii::app()->authManager;
						// $user = Yii::app()->request->getParam('Users');
						// $auth->assign($roles->getRoleCodeById($user['role_id']), $model->id);
						$this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/users');
					}
					catch(Exception $e)
					{
					}
				}
			}
			if(count($error)>0){
				foreach($error as $k=>$v){
					$error[$k] = '<span class="errorMessage">'.$v.'</span>';
				};
			};
			$this->render('createUser',array(
				'model'=>$model,
				'roles' => $model->getRoles(),
				'role_id' => $role_id,
				'error' => $error
			));
        }else
            $this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/access');
    }


    public function actionDeleteUser($id = false){
		$model = new Users();
		$role_id = $model->findByPk(Yii::app()->user->id)->role_id;
		if($role_id<=2){
            if($id){
				$model = Users::model()->findByPk($id);
				if($model['role_id']>=$role_id){
					Users::model()->findByPk($id)->delete();
					// $this->redirect(Yii::app()->url->returnUrl);
					$this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/users');
				}
            }
        } else
            $this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/access');
    }

    public function actionMainUpdate() {
		$this->pageTitle = CHtml::encode(Yii::app()->name);
		
        $settings = new Settings();
        $model=  $settings->findByPk($settings->getActiveSettings());

        if(isset($_POST['Settings'])){
            $model->attributes=$_POST['Settings'];
            $model->save();
        }

        $this->render('main', array(
            'model'=>$model,
        ));
    }

    public function actionAccess(){
		$this->pageTitle = CHtml::encode(Yii::app()->name);
        $this->render('access');
    }

	public function actionUsers($page = 1){
		$this->pageTitle = 'Управление пользователями';
		$users = new Users();
		$records_on_page = 6;
		$role_id = $users->findByPk(Yii::app()->user->id)->role_id;
		if($role_id<=2){
			$count = $users->getCountUsers($role_id);
			$pagination = $this->pagination('/admin.php?r=settings/users&page=',$count,$page,$records_on_page);
			$offset = ($page-1)*$records_on_page;
			$limit = $records_on_page;
			$users = $users->getUsers($role_id,$offset,$limit);
			$this->render('users', array('users' => $users, 'pagination' => $pagination, 'role_id' => $role_id));
		}else
			$this->redirect(Yii::app()->baseUrl.'/admin.php?r=settings/access');
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

	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionModules(){
        var_dump(Yii::app()->controller->module);
    }

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='createUser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
