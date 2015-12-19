<?php

/**
 * This is the model class for table "rktv_module_list3_params".
 *
 * The followings are the available columns in table 'rktv_module_list3_params':
 * @property string $id
 * @property string $code
 * @property string $title
 * @property string $default_value
 * @property integer $data_type_id
 * @property string $order_id
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property DataType $dataType
 * @property ModulesInPages $mpage
 * @property ModuleList3ParamsValues[] $moduleList3ParamsValues
 * @property ModuleList3Values[] $moduleList3Values
 */
class ModuleList3Params extends CActiveRecord
{
	public $type_title;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList3Params the static model class
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
		return 'rktv_module_list3_params';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title, data_type_id, mpage_id', 'required'),
			array('data_type_id, mpage_id', 'numerical', 'integerOnly'=>true),
			array('code, title, default_value', 'length', 'max'=>255),
			array('order_id', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, default_value, data_type_id, order_id, mpage_id', 'safe', 'on'=>'search'),
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
			'mpage' => array(self::BELONGS_TO, 'ModulesInPages', 'mpage_id'),
			'moduleList3ParamsValues' => array(self::HAS_MANY, 'ModuleList3ParamsValues', 'param_id'),
			'moduleList3Values' => array(self::HAS_MANY, 'ModuleList3Values', 'param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Код параметра',
			'title' => 'Название',
			'default_value' => 'Значение по умолчанию',
			'data_type_id' => 'Тип данных',
			'order_id' => 'Order',
			'mpage_id' => 'Mpage',
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
		$criteria->compare('default_value',$this->default_value,true);
		$criteria->compare('data_type_id',$this->data_type_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('mpage_id',$this->mpage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($mpage_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->select = 't.*, rktv_data_type.title as type_title';
		$criteria->condition = 'mpage_id = :mpage_id';
		$criteria->params = array('mpage_id' => $mpage_id);
		$criteria->join='INNER JOIN rktv_data_type ON t.data_type_id = rktv_data_type.id';
		$criteria->order = 't.order_id DESC, t.id ASC';
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
        }
        return $data;
	}

	public function existsItem($mpage_id, $id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'id = :id AND mpage_id = :mpage_id';
		$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id);
		return $this->exists($criteria);
	}

	public function deleteItem($mpage_id, $id){
		$result = false;
		if(!is_null($id) && $this->existsItem($mpage_id, $id)){
			if($this->findByPk($id)->delete()){
				$result = true;
			}
		}
		return $result;
	}

	public function getItem($id){
		$criteria = new CDbCriteria;
		$criteria->condition = 'id = :id';
		$criteria->params = array('id' => $id);
        $value = $this->find($criteria);
        return $value;
	}
}