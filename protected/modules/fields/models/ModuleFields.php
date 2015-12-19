<?php

/**
 * This is the model class for table "rktv_module_fields".
 *
 * The followings are the available columns in table 'rktv_module_fields':
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $value
 * @property integer $data_type_id
 * @property string $order_id
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property DataType $dataType
 * @property ModulesInPages $mpage
 */
class ModuleFields extends CActiveRecord
{
	public $module_id = 'fields';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleFields the static model class
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
		return 'rktv_module_fields';
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
			array('data_type_id, mpage_id', 'numerical', 'integerOnly'=>true),
			array('code, title', 'length', 'max'=>255),
			array('order_id', 'length', 'max'=>11),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, value, data_type_id, order_id, mpage_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Код',
			'title' => 'Название',
			'value' => 'Значение',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('data_type_id',$this->data_type_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('mpage_id',$this->mpage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getCount($mpage_id){
        $criteria = new CDbCriteria();
        $criteria->condition = 'mpage_id = :mpage_id';
        $criteria->params = array('mpage_id' => $mpage_id);
        return $this->count($criteria);
    }

	public function existsItem($link_id,$id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'id = :id AND mpage_id = :mpage_id';
		$criteria->params = array('id' => $id,'mpage_id' => $link_id);
		return $this->exists($criteria);

	}

	public function getList($mpage_id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id';
		$criteria->params = array('mpage_id' => $mpage_id);
        $criteria->order = 'order_id DESC, id ASC';
		return $this->findAll($criteria);

	}

	public function getValueListByPageId($page_id){
		$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module_id);
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id';
		$criteria->params = array('mpage_id' => $mpage_id);
        $criteria->order = 'order_id DESC, id ASC';
		$data = array();
        foreach($this->findAll($criteria) as $value){
            $data[$value->code] = $value->value;
        }
        return $data;

	}

	public function getListByCode($mpage_id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id';
		$criteria->params = array('mpage_id' => $mpage_id);
        $criteria->order = 'order_id DESC, id ASC';
		$criteria->offset = floor($offset);
		if($limit!=0) $criteria->limit = floor($limit);
		$data = array();
        foreach($this->findAll($criteria) as $value){
            $data[$value->code] = $value;
        }
        return $data;
	}

	public function deleteItem($link_id, $id){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
			if($this->findByPk($id)->delete()) $result = true;
		}
		return $result;

	}

    /* Деактивация модуля, теперь в самом модуле ! */
    public function deactivation($link_id, $module){
        $result = false;
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->condition = 'mpage_id = :mpage_id';
        $criteria->params = array('mpage_id' => $link_id);
        foreach($this->findAll($criteria) as $value){
            $this->deleteItem($link_id,$value->id);
        }
        if($this->count($criteria) == 0){
            if(ModulesInPages::model()->deleteLink($link_id))
                $result = true;
        }
        return $result;
    }

	public function getItem($id = NULL, $mpage_id=NULL){
		$criteria = new CDbCriteria;
		$criteria->condition = 'mpage_id = :mpage_id AND id = :id';
		$criteria->params = array('mpage_id' => $mpage_id, 'id' => $id);
        return $this->find($criteria);
	}
}