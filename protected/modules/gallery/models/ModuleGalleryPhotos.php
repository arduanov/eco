<?php

/**
 * This is the model class for table "rktv_module_gallery_photos".
 *
 * The followings are the available columns in table 'rktv_module_gallery_photos':
 * @property integer $id
 * @property string $title
 * @property string $short
 * @property string $text
 * @property string $gallery_id
 * @property integer $file_id
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property ModuleGallery $gallery
 * @property Files $file
 */
class ModuleGalleryPhotos extends CActiveRecord
{
	public $img = array();
	public $img_default = array();
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleGalleryPhotos the static model class
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
		return 'rktv_module_gallery_photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, gallery_id, file_id', 'required'),
			array('file_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('gallery_id, order_id', 'length', 'max'=>11),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, short, text, gallery_id, file_id, order_id', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'ModuleGallery', 'gallery_id'),
			'file' => array(self::BELONGS_TO, 'Files', 'file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'short' => 'Short',
			'text' => 'Text',
			'gallery_id' => 'Gallery',
			'file_id' => 'File',
			'order_id' => 'Order',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('gallery_id',$this->gallery_id,true);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($gallery_id, $offset = 0, $limit = 0, $active = NULL){
		$data = array();
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'gallery_id = :gallery_id AND active = :active';
			$criteria->params = array('gallery_id' => $gallery_id, 'active' => $active);
		}else{
			$criteria->condition = 'gallery_id = :gallery_id';
			$criteria->params = array('gallery_id' => $gallery_id);
		}
		$criteria->offset = floor($offset);
		$criteria->order = 'order_id DESC, id ASC';
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->file_id!=NULL) $data[$value->id]->img = $this->getImageById($value->file_id);
				else $data[$value->id]->img = $this->img_default;
        }
        return $data;
	}

    public function getImageById($id){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('gallery', false, true).Files::model()->findByPk($id)->file_name;
        else
            $result = null;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$result))
            $result = null;
		if($result!=null){
			$images = array();
			$i = 0;
			$result = $_SERVER['DOCUMENT_ROOT'].$result;
			foreach(array(array(0,100),array(640,0),array(225,150),array(850,0)) as $size){
				// [0] - админка список, [1] - админка редактир, [2] - сайт (маленькая), [3] - сайт (большая)
				$i++;
				$cache_folder = explode('/',$result);
				$cache_folder[count($cache_folder)-1] = 'cache';
				$cache_folder = implode('/',$cache_folder);
				$img = explode('/',$result);
				$img[count($img)-1] = 'cache/size'.$i.'_'.$img[count($img)-1];
				$img = implode('/',$img);
				if(!is_dir($cache_folder)) mkdir($cache_folder,777);
				if(!file_exists($img)){
					$thumb = Yii::app()->thumb->create($result);
					$thumb->resize($size[0], $size[1]);
					$thumb->save($img);
				};
				$img = explode($_SERVER['DOCUMENT_ROOT'],$img);
				$images[] = $img[1];
			};
		}else{
			$images = $this->img_default;
		};
        return $images;
    }

	public function existsItem($id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'id = :id';
		$criteria->params = array('id' => $id);
		return $this->exists($criteria);
	}
	
	public function deleteItem($id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($id)){
			$file_id = $this->findByPk($id)->file_id;
			if(Files::model()->deleteFile($file_id, $module) && $this->findByPk($id)->delete()) $result = true;
		}
		return $result;
	}
	
	public function deleteList($gallery_id, $module){
		$result = false;
		if(!is_null($gallery_id)){
			$criteria = new CDbCriteria();
			$criteria->condition = 'gallery_id = :gallery_id';
			$criteria->params = array('gallery_id' => $gallery_id);
			foreach($this->findAll($criteria) as $value){
				$id = $value->id;
				if(!is_null($id) && $this->existsItem($id)){
					$file_id = $this->findByPk($id)->file_id;
					if(Files::model()->deleteFile($file_id, $module)/*  && $this->findByPk($id)->delete() */) $result = true;
				}
			}
		}
		return $result;
	}
}