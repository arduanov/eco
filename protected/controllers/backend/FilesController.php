<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kai
 * Date: 20.02.12
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

class FilesController extends BackEndController {

    public function actionUploadImage($module = null, $width = null, $height = null, $resize = false, $compare_width = null, $compare_height = null){
        if(!is_null($module))
            echo htmlspecialchars(json_encode(Files::model()->imageUpload($module, $width, $height, $resize, $compare_width, $compare_height)), ENT_NOQUOTES);
        else
            return false;
    }
	
    public function actionUploadFile($module = null){
        if(!is_null($module))
            echo htmlspecialchars(json_encode(Files::model()->fileUpload($module)), ENT_NOQUOTES);
        else
            return false;
    }

    public function actionUploadImageToAlbum($album_id = null, $module = null, $width = null, $height = null, $resize = false, $compare_width = null, $compare_height = null){
        if(!is_null($module)){
            $album_id = Yii::app()->session->get('album_id', $album_id);
            echo htmlspecialchars(json_encode(Files::model()->imageUpload($module, $width, $height, $resize, $compare_width, $compare_height, true, $album_id)), ENT_NOQUOTES);
        }
        else
            return false;
    }

    public function actionClearTempFiles($module_name = null){

        $result = false;

        if(!is_null($module_name)){
            if(Files::model()->clearTempFiles($module_name))
                $result = true;
        } else
            $result = false;

        return $result;
    }

    public function actionClearFiles(){
		$this->pageTitle = 'Удаление неиспользуемых файлов';
		foreach(array('news','page','banner','list2','files') as $module){
			$connection = Yii::app()->db;
			$sql = "DELETE FROM rktv_files WHERE temp='1' AND download_date<DATE_SUB(NOW(),INTERVAL 60 MINUTE) AND module='$module'";
			$command = $connection->createCommand($sql);
			$command->execute();
			$result = false;
			$folder = Files::model()->getUploadFolder($module, false);
			$files = array();
			$criteria = new CDbCriteria();
			$criteria->condition = 'module = :module';
			$criteria->params = array('module' => $module);
			foreach(Files::model()->findAll($criteria) as $value){
				$files[] = $value->file_name;
			};
			$content = '';
			if(is_dir($folder)){
				if($handle = opendir($folder)){
					while(false !== ($file = readdir($handle))){
						if($file != "." && $file != ".."){
							if(!is_dir($folder.$file)){
								if(!in_array($file,$files)){
									$content .= $folder.$file;
									if(unlink($folder.$file)) $content .= ' — удалено'; else $content .= ' — ошибка удаления';
									$content .= '<br>';
								}
							}
						}
					}
				}
			};
			$folders = array(
				$folder.'cache/',
				// Yii::getPathOfAlias('webroot').'/fileupload/uploads/'
				);
			foreach($folders as $folder){
				if(is_dir($folder)){
					if($handle = opendir($folder)){
						while(false !== ($file = readdir($handle))){
							if($file != "." && $file != ".."){
								$content .= $folder.$file;
								if(unlink($folder.$file)) $content .= ' — удалено'; else $content .= ' — ошибка удаления';
								$content .= '<br>';
							};
						};
					};
				};
			};
		};
		if(empty($content)) $content = '<p><i>Файлов для удаления нет. Всё чисто.</i></p>';
		$this->render('index',array('content'=>$content));
    }

}