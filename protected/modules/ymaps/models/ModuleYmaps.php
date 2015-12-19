<?php

/**
 * This is the model class for table "rktv_module_ymaps".
 *
 * The followings are the available columns in table 'rktv_module_ymaps':
 * @property string $id
 * @property string $title
 * @property string $longitude
 * @property string $latitude
 * @property string $text
 * @property integer $active
 * @property integer $category_id
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property ModuleYmapsCategories $category
 * @property ModuleYmapsValues[] $moduleYmapsValues
 */
class ModuleYmaps extends CActiveRecord
{
	public $params = array();
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleYmaps the static model class
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
		return 'rktv_module_ymaps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category_id', 'required'),
			array('active, category_id', 'numerical', 'integerOnly'=>true),
			array('title, longitude, latitude', 'length', 'max'=>255),
			array('order_id', 'length', 'max'=>11),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, longitude, latitude, text, active, category_id, order_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'ModuleYmapsCategories', 'category_id'),
			'moduleYmapsValues' => array(self::HAS_MANY, 'ModuleYmapsValues', 'point_id'),
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
			'longitude' => 'Долгота',
			'latitude' => 'Широта',
			'text' => 'Text',
			'active' => 'Опубликовать',
			'category_id' => 'Category',
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
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 *
	 * @param type $mpage_id
	 * @param type $offset
	 * @param type $limit
	 * @param type $active
	 * @return type 
	 */
	public function getList($category_id, $active = NULL){
		$data = array();
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'category_id = :category_id AND active = :active';
			$criteria->params = array('category_id' => $category_id, 'active' => $active);
		}else{
			$criteria->condition = 'category_id = :category_id';
			$criteria->params = array('category_id' => $category_id);
		}
		$criteria->offset = floor($offset);
		//$criteria->order = 'title ASC';
		$criteria->order = 'order_id DESC, id ASC';
		if($limit != 0)
			$criteria->limit = floor($limit);
		foreach($this->findAll($criteria) as $value){
			$data[$value->id] = $value;
			$data[$value->id]->params = ModuleYmapsValues::model()->getList($value->id);
		}
		$data0 = array();
		if(isset($data[10])) $data0[10] = $data[10];
		foreach($data as $key => $value){
			if($key != 10) $data0[$key] = $value;
		}
		return $data0;
	}

	/**
	 * Проверяет существование элемента
	 * @param type $mpage_id
	 * @param type $id
	 * @param type $active
	 * @return type 
	 */
	public function existsItem($category_id, $id, $active = NULL){
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'id = :id AND category_id = :category_id AND active = :active';
			$criteria->params = array('id' => $id, 'category_id' => $category_id, 'active' => $active);
		}else{
			$criteria->condition = 'id = :id AND category_id = :category_id';
			$criteria->params = array('id' => $id, 'category_id' => $category_id);
		}
		return $this->exists($criteria);
	}

	/*
	 * 
	 */
	public function deleteItem($link_id, $category_id, $id){
		$result = false;
		if(!is_null($id) && ModuleYmapsCategories::model()->existsItem($link_id,$category_id) && $this->existsItem($category_id,$id)){
			if($this->findByPk($id)->delete()){
				$result = true;
			}
		}
		return $result;
	}
}