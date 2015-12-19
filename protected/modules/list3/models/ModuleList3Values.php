<?php

/**
 * This is the model class for table "rktv_module_list3_values".
 *
 * The followings are the available columns in table 'rktv_module_list3_values':
 * @property string $id
 * @property string $param_id
 * @property string $item_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property ModuleList3 $item
 * @property ModuleList3Params $param
 */
class ModuleList3Values extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList3Values the static model class
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
		return 'rktv_module_list3_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('param_id, item_id', 'required'),
			array('param_id', 'length', 'max'=>5),
			array('item_id', 'length', 'max'=>11),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, param_id, item_id, value', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'ModuleList3', 'item_id'),
			'param' => array(self::BELONGS_TO, 'ModuleList3Params', 'param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'param_id' => 'Param',
			'item_id' => 'Item',
			'value' => 'Value',
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
		$criteria->compare('param_id',$this->param_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($item_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'item_id = :item_id';
		$criteria->params = array('item_id' => $item_id);
		foreach($this->findAll($criteria) as $value){
			$data[$value->param_id] = $value;
		}
		return $data;
	}
	
	public function getListWithParams($item_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 't.item_id = :item_id';
		$criteria->params = array('item_id' => $item_id);
		$criteria->order = 'param.order_id DESC, t.param_id ASC, t.id ASC';
		foreach($this->with('param')->findAll($criteria) as $value){
			$param = ModuleList3Params::model()->getItem($value->param_id);
			if(!isset($data[$param->code]) || !is_array($data[$param->code])){
				$data[$param->code] = array();
				$data[$param->code]['id'] = $param->id;
				$data[$param->code]['title'] = $param->title;
				$data[$param->code]['data_type_id'] = $param->data_type_id;
			}
			// SELECT'ы
			if(in_array($param->data_type_id, array(5,6))){
				if(!isset($data[$param->code]['value']) || !is_array($data[$param->code]['value'])){
					$data[$param->code]['value'] = array();
				}
				$i = count($data[$param->code]['value']);
				$item_id = (int)$value->value;
				if(ModuleList3ParamsValues::model()->existsItem($param->id, $item_id)){
					$param_value = ModuleList3ParamsValues::model()->getItem($item_id);
					$data[$param->code]['value'][$i] = array();
					$data[$param->code]['value'][$i]['id'] = $param_value->id;
					$data[$param->code]['value'][$i]['title'] = $param_value->title;
				}
			}else{
				$data[$param->code]['value'] = $value->value;
			}
		}
		return $data;
	}
	
	public function exist_value($item_id, $param_id, $value){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'item_id = :item_id AND param_id = :param_id AND value = :value';
		$criteria->params = array('item_id' => $item_id, 'param_id' => $param_id, 'value' => $value);
		return $this->exists($criteria);
	}
	
	public function existsItem($item_id, $param_id, $value = NULL){
		$criteria = new CDbCriteria();
		if(!is_null($value)){
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id AND value = :value';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id, 'value' => $value);
		}else{
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id);
		}
		return $this->exists($criteria);
	}
	
	public function getItem($item_id, $param_id, $value = NULL){
		$criteria = new CDbCriteria;
		if(!is_null($value)){
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id AND value = :value';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id, 'value' => $value);
		}else{
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id);
		}
        return $this->find($criteria);
	}
	
	public function new_value($item_id, $param_id, $value = ''){
		$criteria = new CDbCriteria();
		$criteria->condition = 'param_id = :param_id AND item_id = :item_id';
		$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id);
		$this->updateAll(array('value'=>$value),$criteria);
		return $this->exists($criteria);
	}
}