<?php

class DefaultController extends BackEndController
{
	public function actionIndex()
	{
		$data = array();
		$save = Yii::app()->user->getFlash('action_banner');
		$data['model'] = new ModuleBanner();
		$data['failed'] = false;
		$data['save'] = false;
		if($save=='save_1') $data['save'] = true;
		if(isset($_POST['ModuleBanner'])){
			if($_POST['ModuleBanner']['img_id']=='NULL') $_POST['ModuleBanner']['img_id'] = '';
			$data['model']->attributes = $_POST['ModuleBanner'];
			$data['model']->img_id = $_POST['ModuleBanner']['img_id'];
			if((int)$_POST['ModuleBanner']['img_id']) Files::model()->saveTempFile((int)$_POST['ModuleBanner']['img_id']);
			if($data['model']->save()){
				Yii::app()->user->setFlash('action_banner','save_1');
				$this->redirect(Yii::app()->baseUrl.'?r=/banner/default/');
			}else{
				$data['failed'] = true;
			};
		};
		$data['save_order'] = false;
		if($save=='save_2') $data['save_order'] = true;
		if(isset($_POST['type']) && $_POST['type']=='banner'){
			foreach(array('ids'=>'rktv_module_banner') as $k=>$v){
				if(isset($_POST[$k]) && !empty($_POST[$k])){
					$out = "UPDATE $v SET order_id= CASE";
					$id = $_POST[$k];
					$id = explode(',',$id);
					for($i=count($id); $i>0; $i--){
						$out .= " WHEN id='".intval($id[count($id)-$i])."' THEN '$i'";
					};
					$out .= " ELSE order_id END";
					$connection = Yii::app()->db;
					$command = $connection->createCommand($out);
					$out = $command->execute();
				};
			};
			Yii::app()->user->setFlash('action_banner','save_2');
			$this->redirect(Yii::app()->baseUrl.'?r=/banner/default/');
		};
		$data['data'] = $data['model']->getList();
		$this->render('index',$data);
	}
	
	public function actionUpdate($id = null)
	{
        if(!is_null($id)){
			if(ModuleBanner::model()->existsItem((int)$id)){
				$data['model'] = ModuleBanner::model()->findByPk((int)$id);
				if(isset($_POST['ModuleBanner'])){
					$old_file_id = $data['model']->img_id;
					if($_POST['ModuleBanner']['img_id']=='NULL') $_POST['ModuleBanner']['img_id'] = '';
					$data['model']->attributes = $_POST['ModuleBanner'];
					$data['model']->img_id = $_POST['ModuleBanner']['img_id'];
					if((int)$_POST['ModuleBanner']['img_id']) Files::model()->saveTempFile((int)$_POST['ModuleBanner']['img_id']);
						elseif($_POST['ModuleBanner']['img_id']=='NULL') Files::model()->deleteFile($old_file_id,$this->module->id);
					if($data['model']->save()){
						if($old_file_id!=$data['model']->img_id) Files::model()->deleteFile($old_file_id,$this->module->id);
						$this->redirect(Yii::app()->baseUrl.'?r=/'.$this->module->id.'/default/update&id='.$id);
					};
				};
				$data['model'] = ModuleBanner::model()->getItem($id);
				$this->render('update',$data);
			}else{
				$this->redirect(Yii::app()->request->scriptUrl);
			};
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
	}

    public function actionDelete($id = null){
        if(!is_null($id)) ModuleBanner::model()->deleteItem((int)$id);
		$this->redirect(Yii::app()->baseUrl.'?r=/'.$this->module->id.'/default/');
    }

    public function actionActive($id = null){
        ModuleBanner::model()->updateByPk($id,array('active'=>1));
		$this->redirect(Yii::app()->baseUrl.'?r=/'.$this->module->id.'/default/');
    }

    public function actionDeactive($id = null){
        ModuleBanner::model()->updateByPk($id,array('active'=>0));
		$this->redirect(Yii::app()->baseUrl.'?r=/'.$this->module->id.'/default/');
    }
}