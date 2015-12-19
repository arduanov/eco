<?php

/**
 * This is the model class for table "rktv_module_list3_params_values".
 *
 * The followings are the available columns in table 'rktv_module_list3_params_values':
 * @property string $id
 * @property string $title
 * @property string $param_id
 * @property string $order_id
 * @property integer $check_1
 * @property integer $check_2
 *
 * The followings are the available model relations:
 * @property ModuleList3Params $param
 */
class ModuleList3ParamsValues extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList3ParamsValues the static model class
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
		return 'rktv_module_list3_params_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, param_id', 'required'),
			array('check_1, check_2, check_3, check_4, check_5', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('param_id, order_id', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, param_id, order_id, check_1, check_2, check_3, check_4, check_5', 'safe', 'on'=>'search'),
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
			'title' => 'Заголовок',
			'param_id' => 'Param',
			'order_id' => 'Order',
			'check_1' => 'Check 1',
			'check_2' => 'Check 2',
            'check_3' => 'Check 3',
            'check_4' => 'Check 4',
            'check_5' => 'Check 5',
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
		$criteria->compare('param_id',$this->param_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('check_1',$this->check_1);
		$criteria->compare('check_2',$this->check_2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($param_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'param_id = :param_id';
		$criteria->params = array('param_id' => $param_id);
		$criteria->order = 'order_id DESC, id ASC';
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
        }
        return $data;
	}

	public function existsItem($param_id, $id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'id = :id AND param_id = :param_id';
		$criteria->params = array('id' => $id, 'param_id' => $param_id);
		return $this->exists($criteria);
	}

	public function getItem($id){
		$criteria = new CDbCriteria;
		$criteria->condition = 'id = :id';
		$criteria->params = array('id' => $id);
        $value = $this->find($criteria);
        return $value;
	}

	public function deleteItem($param_id, $id){
		$result = false;
		if(!is_null($id) && $this->existsItem($param_id, $id)){
			if($this->findByPk($id)->delete()){
				$result = true;
			}
		}
		return $result;
	}
}