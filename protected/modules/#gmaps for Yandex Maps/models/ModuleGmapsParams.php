<?php

/**
 * This is the model class for table "rktv_module_gmaps_params".
 *
 * The followings are the available columns in table 'rktv_module_gmaps_params':
 * @property string $id
 * @property string $code
 * @property string $title
 * @property string $values
 * @property string $default_value
 * @property integer $data_type_id
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property DataType $dataType
 * @property ModuleGmapsValues[] $moduleGmapsValues
 */
class ModuleGmapsParams extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleGmapsParams the static model class
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
		return 'rktv_module_gmaps_params';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title, data_type_id', 'required'),
			array('data_type_id', 'numerical', 'integerOnly'=>true),
			array('code, title, default_value', 'length', 'max'=>255),
			array('values', 'length', 'max'=>500),
			array('order_id', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, values, default_value, data_type_id, order_id', 'safe', 'on'=>'search'),
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
			'dataType' => array(self::BELONGS_TO, 'DataType', 'data_type_id'),
			'moduleGmapsValues' => array(self::HAS_MANY, 'ModuleGmapsValues', 'param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'title' => 'Title',
			'values' => 'Values',
			'default_value' => 'Default Value',
			'data_type_id' => 'Data Type',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('values',$this->values,true);
		$criteria->compare('default_value',$this->default_value,true);
		$criteria->compare('data_type_id',$this->data_type_id);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 *
	 * @param type $data_type_id
	 * @return type 
	 */
	public function getList($data_type_id = NULL){
		$data = array();
		$criteria = new CDbCriteria();
		if(!is_null($data_type_id)){
			$criteria->condition = 'data_type_id = :data_type_id';
			$criteria->params = array('data_type_id' => $data_type_id);
		}
		$criteria->offset = floor($offset);
		$criteria->order = 'order_id DESC';
		if($limit != 0)
			$criteria->limit = floor($limit);
		foreach($this->findAll($criteria) as $value){
			$data[$value->id] = $value;
		}
		return $data;
	}
}