<?php

/**
 * This is the model class for table "rktv_files".
 *
 * The followings are the available columns in table 'rktv_files':
 * @property integer $id
 * @property string $file_name
 * @property string $short
 * @property string $text
 * @property integer $temp
 * @property string $download_date
 * @property string $module
 *
 * The followings are the available model relations:
 * @property RktvModuleActionsData[] $rktvModuleActionsDatas
 * @property RktvModuleActionsData[] $rktvModuleActionsDatas1
 * @property RktvModuleCatalogAccessories[] $rktvModuleCatalogAccessories
 * @property RktvModuleCatalogItem[] $rktvModuleCatalogItems
 * @property RktvModuleCatalogSuite[] $rktvModuleCatalogSuites
 * @property RktvModuleNews[] $rktvModuleNews
 * @property RktvPages[] $rktvPages
 * @property RktvSettings[] $rktvSettings
 */
class Files extends CActiveRecord
{

    public function clearTempFiles($module_name){

        $criteria = new CDbCriteria();
        $criteria->condition = 'temp = 1';
        $result = true;

        if($this->count($criteria) > 0 && is_dir($path = $this->getUploadFolder($module_name, false))){
            foreach($this->findAll($criteria) as $value){
                try {

                    if(!unlink($path.$value->file_name)){
                        throw new Exception("Не удаётся удалить файл.");
                    } else {
                        $this->findByPk($value->id)->delete();
                    }

                } catch(Exception $e) {
                    $result = false;
                    break;
                }
            }
        }

        return $result;

    }


    public function filesUpload($module_name){

        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $result = false;

        try {

            $uploader = new qqFileUploader(array("jpeg, gif, png, bmp"), 100 * 1024 * 1024 * 1024);
            $upload_folder = $this->getUploadFolder($module_name);

            $result = $uploader->handleUpload($upload_folder);

            if(isset($result["error"]) && strlen($result["error"]) > 0){
                throw new Exception("Не удаётся загрузить файл.");
            } else {

                //Тут вставляем свой  код ;)

            }

        }   catch (Exception $e) {
            $result = array('error' => $result["filename"]);
        }

        return $result;

    }
	
    public function fileUpload($module_name){
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $result = false;
        try {
            $uploader = new qqFileUploader(array("pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "odf", "rtf", "txt", "rar", "zip", "7z", "jpeg","jpg", "png", "gif", "bmp"), 100000000);
            $upload_folder = $this->getUploadFolder($module_name);
            $result = $uploader->handleUpload($upload_folder);
            if(isset($result["error"]) && strlen($result["error"]) > 0){
                throw new Exception("Не удаётся загрузить файл.");
            } else {
                $image_path = $upload_folder.$result["filename"];
                if(!isset($result["error"])){
                    $model = new Files();
                    $model->file_name = $result["filename"];
                    $model->temp = 1;
                    $model->module = $module_name;
                    $model->save();
                    $result["image_id"] = $model->id;
                }
            }
        }   catch (Exception $e) {
            $result = array('error' => $result["filename"]);
        }
        return $result;
    }


    public function imageUpload($module_name, $width, $height, $resize, $compare_width, $compare_height, $with_album = false, $album_id = null){

        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $result = false;


        try {

            $uploader = new qqFileUploader(array("jpg", "jpeg", "gif", "png", "bmp"), 8 * 1024 * 1024);
            $upload_folder = $this->getUploadFolder($module_name);

            $result = $uploader->handleUpload($upload_folder);

            if(isset($result["error"]) && strlen($result["error"]) > 0){
                throw new Exception("Не удаётся загрузить файл.");
            } else {

                $image_path = $upload_folder.$result["filename"];
                $thumb = Yii::app()->thumb->create($image_path);

                if($resize){
                    $thumb->resize($width, $height);
                    $thumb->save($image_path);
                } else {

                    list($current_width, $current_height) = getimagesize($image_path);

                    if($this->resolutionCompare($current_width, $width, $compare_width) || $this->resolutionCompare($current_height, $height, $compare_height)){
                        $result = array('error' => 'Upload image resolution is incorrect !');
                    }

                }

                if(!isset($result["error"])){

                    $model = new Files();
                    $model->file_name = $result["filename"];
                    $model->temp = 1;
                    $model->module = $module_name;
                    $model->save();

                    if($with_album){

                        if(is_null($album_id)){
                            $album_id = ModuleGalleryAlbums::model()->createAlbum($module_name);
                            Yii::app()->session->add('album_id', $album_id);
                        }

                        $photo_id = ModuleGalleryPhotos::model()->createPhoto($album_id, $model->id);

                    }

                    $result["image_id"] = $model->id;
                    $result["album_id"] = $album_id;

                    if(isset($photo_id))
                        $result["photo_id"] = $photo_id;

                }


            }

        }   catch (Exception $e) {
                $result = array('error' => $result["filename"]);
        }

        return $result;

    }


    public function resolutionCompare($current, $new, $compare){
        $error = false;
        if(!is_null($new) && !is_null($compare)){
            switch($compare){
                case 1:
                    if(!($current > $new))
                        $error = true;
                    break;
                case 2:
                    if(!($current < $new))
                        $error = true;
                    break;
                case 3:
                    if(!($current == $new))
                        $error = true;
                    break;
                case 4:
                    if(!($current >= $new))
                        $error = true;
                    break;
                case 5:
                    if(!($current <= $new))
                        $error = true;
                    break;
            }
        }
        return $error;
    }


    /* Создание директории модуля для хранения файлов, первый параметр имя модуля, второй - требуется ли создать директорую ( поумолчанию true), третий параметр: полный путь - false, путь для отображения - true */
    public function getUploadFolder($module_name, $create = true, $view = false){
        if($view)
            $root_dir = 'upload';
        else
            $root_dir =  Yii::getPathOfAlias('webroot').'/'.'upload';

        $upload_dir = $root_dir.'/'.md5($module_name);
        $result = false;
        if(!is_dir($upload_dir) && $create){
            try {
                if(mkdir($upload_dir, 0777)){
                    $result = $upload_dir.'/';
                } else
                    throw new Exception("Не удаётся создать директорию.");
            } catch (Exception $e) {
                $result =  false;
            }
        } else {
            $result = $upload_dir.'/';
        }
        return $result;
    }

    public function deleteFileById($id, $module){
        /*$result = false;
        if(!is_null($id)){
            try {
                $file = $this->getUploadFolder($module, false).$this->findByPk($id)->file_name;
                if(file_exists($file)){
                    if(unlink($file) && $this->findByPk($id)->delete()){
                            $result = true;
                    }
                } else {
                    $criteria = new CDbCriteria();
                    $criteria->condition = 'id = :id';
                    $criteria->params = array('id' => $id);
                    if($this->exists($criteria)){
                        if($this->findByPk($id)->delete()){
                            $result = true;
                        }
                    } else {
                        throw new Exception("Не удаётся удалить файл.");
                    }
                }
            } catch (Exception $e) {
                $result = false;
            }
        } else
            $result = true;
        return $result;*/
		return $this->deleteFile($id, $module);
    }
    
    public function getVirtualPath($module_name, $file_id){

    	
    	if($this->existsFile($file_id))
    		return $this->getUploadFolder($module_name, false, true).$this->findByPk($file_id)->file_name;
    	else 
    		return null;
    	
    }
    
    public function existsFile($id){
    	
    	$criteria = new CDbCriteria();
		$criteria->condition = 'id = :id';
		$criteria->params = array('id' => $id);
		
		return $this->exists($criteria);
    	
    }
    
    public function saveTempFile($id){
    	return $this->updateByPk($id,array('temp'=>0));
    }
    
    public function deleteFile($id,$module = '',$dir = ''){
		// например $dir = 'dir_name/'
		$result = false;
		if($this->existsFile($id)){
			$file = $this->findByPk($id);
			if(!empty($module)){
				if(!empty($id)) $file_path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->getUploadFolder($module,false,true).$dir.$file->file_name;
					else $file_path = null;
				if(!is_null($file_path)){
					$cache_folder = $_SERVER['DOCUMENT_ROOT'].'/'.$this->getUploadFolder($module,false,true).$dir.'cache';
					if(is_dir($cache_folder)){
						if($handle = opendir($cache_folder)){
							while(false !== ($cache_file = readdir($handle))){
								if($cache_file != "." && $cache_file != ".."){
									$delete_cache_file = explode($file->file_name,$cache_file);
									if(count($delete_cache_file)==2 && $delete_cache_file[1]==''){
										$delete_cache_file = explode('_',$delete_cache_file[0]);
										if(count($delete_cache_file)==2 && $delete_cache_file[1]==''){
											unlink($cache_folder.'/'.$cache_file); // system("del $cache_folder/$cache_file");
										};
									};
								};
							};
						};
					};
					if(file_exists($file_path)) unlink($file_path); // system("del $file_path");
				};
			};
			$result = $file->delete();
		};
		return $result;
    }
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Files the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rktv_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_name', 'required'),
			array('temp', 'numerical', 'integerOnly'=>true),
			array('file_name, short, module', 'length', 'max'=>255),
			array('text, download_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, file_name, short, text, temp, download_date, module', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ModuleActionsDatas' => array(self::HAS_MANY, 'ModuleActionsData', 'large_img_id'),
			'ModuleActionsDatas1' => array(self::HAS_MANY, 'ModuleActionsData', 'small_img_id'),
			'ModuleCatalogAccessories' => array(self::HAS_MANY, 'ModuleCatalogAccessories', 'img_id'),
			'ModuleCatalogItems' => array(self::HAS_MANY, 'ModuleCatalogItem', 'img_id'),
			'ModuleCatalogSuites' => array(self::HAS_MANY, 'ModuleCatalogSuite', 'img_id'),
			'ModuleNews' => array(self::HAS_MANY, 'ModuleNews', 'photo_id'),
			'Pages' => array(self::HAS_MANY, 'Pages', 'image_id'),
			'Settings' => array(self::HAS_MANY, 'Settings', 'ogimage'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'file_name' => 'File Name',
			'short' => 'Short',
			'text' => 'Text',
			'temp' => 'Temp',
			'download_date' => 'Download Date',
			'module' => 'Module',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('temp',$this->temp);
		$criteria->compare('download_date',$this->download_date,true);
		$criteria->compare('module',$this->module,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}