<?php

/**
 * This is the model class for table "rktv_module_banner".
 *
 * The followings are the available columns in table 'rktv_module_banner':
 * @property string $id
 * @property string $title
 * @property string $link
 * @property string $text
 * @property integer $img_id
 * @property integer $active
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property RktvFiles $img
 */
class ModuleBanner extends CActiveRecord
{
	public $img = array();
	public $img_default = array();
	/**
	 * Returns the static model of the specified AR class.
	 * @return ModuleBanner the static model class
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
		return 'rktv_module_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('title, link', 'length', 'max'=>255),
			array('order_id', 'length', 'max'=>11),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, link, text, img_id, active, order_id', 'safe', 'on'=>'search'),
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
			'img' => array(self::BELONGS_TO, 'Files', 'img_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'link' => 'Ссылка',
			'text' => 'Текст',
			'img_id' => 'Изображение',
			'active' => 'Опубликовать',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('img_id',$this->img_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
    public function getList(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = 'order_id DESC, id ASC';
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->img_id!=NULL) $data[$value->id]->img = $this->getImageById($value->img_id);
				else $data[$value->id]->img = $this->img_default;
        };
        return $data;
    }
	
    public function getActiveList(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'active = :active AND img_id is NOT NULL';
        $criteria->params = array('active' => 1);
        $criteria->order = 'order_id DESC, id ASC';
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->img_id!=NULL) $data[$value->id]->img = $this->getImageById($value->img_id);
				else $data[$value->id]->img = $this->img_default;
        };
        return $data;
    }
	
    public function getItem($item_id){
        if($value = $this->findByPk($item_id)){
			if($value->img_id!=NULL) $value->img = $this->getImageById($value->img_id);
				else $value->img = $this->img_default;
        };
        return $value;
    }

    public function existsItem($item_id){
        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :id';
        $criteria->params = array('id' => $item_id);
        return $this->exists($criteria);
    }
    
    public function deleteItem($item_id,$module_id = 'banner'){
		$result = false;
		if($this->existsItem($item_id)){
			$item = $this->findByPk($item_id);
			if((int)$item->img_id>0) Files::model()->deleteFile($item->img_id,$module_id);
			$result = $item->delete();
		};
		return $result;
    }
	
    public function getImageById($id){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('banner', false, true).Files::model()->findByPk($id)->file_name;
        else
            $result = null;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$result))
            $result = null;
		if($result!=null){
			$images = array();
			$i = 0;
			$result = $_SERVER['DOCUMENT_ROOT'].$result;
			foreach(array() as $size){
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
			$img = explode($_SERVER['DOCUMENT_ROOT'],$result);
			$images[] = $img[1];
		}else{
			$images = $this->img_default;
		};
        return $images;
    }
}