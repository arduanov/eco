<?php

/**
 * This is the model class for table "rktv_module_gmaps_categories".
 *
 * The followings are the available columns in table 'rktv_module_gmaps_categories':
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $active
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property ModuleGmaps[] $moduleGmaps
 * @property ModulesInPages $mpage
 */
class ModuleGmapsCategories extends CActiveRecord{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleGmapsCategories the static model class
	 */
	public static function model($className = __CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'rktv_module_gmaps_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, mpage_id', 'required'),
			array('active, mpage_id', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 255),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, text, active, mpage_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'moduleGmaps' => array(self::HAS_MANY, 'ModuleGmaps', 'category_id'),
			'mpage' => array(self::BELONGS_TO, 'ModulesInPages', 'mpage_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'text' => 'Text',
			'active' => 'Опубликовать',
			'mpage_id' => 'Mpage',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('mpage_id', $this->mpage_id);

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
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
	public function getList($mpage_id, $offset = 0, $limit = 0, $active = NULL){
		$data = array();
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'mpage_id = :mpage_id';
			$criteria->params = array('mpage_id' => $mpage_id);
		}
		$criteria->offset = floor($offset);
		$criteria->order = 'title ASC';
		if($limit != 0)
			$criteria->limit = floor($limit);
		foreach($this->findAll($criteria) as $value){
			$data[$value->id] = $value;
		}
		return $data;
	}

	/**
	 * Проверяет существование элемента
	 * @param type $mpage_id
	 * @param type $id
	 * @param type $active
	 * @return type 
	 */
	public function existsItem($mpage_id, $id, $active = NULL){
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'id = :id AND mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'id = :id AND mpage_id = :mpage_id';
			$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id);
		}
		return $this->exists($criteria);
	}

	/*
	 * 
	 */
	public function deleteItem($link_id, $id){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
			if($this->findByPk($id)->delete()){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param type $id
	 * @param type $mpage_id
	 * @return type 
	 */
	public function getItem($id = NULL, $mpage_id = NULL){
		$criteria = new CDbCriteria;
		$criteria->condition = 'mpage_id = :mpage_id AND id = :id';
		$criteria->params = array('mpage_id' => $mpage_id, 'id' => $id);
        return $this->find($criteria);
	}

}