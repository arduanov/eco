<?php

/**
 * This is the model class for table "rktv_module_list4_params".
 *
 * The followings are the available columns in table 'rktv_module_list4_params':
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
 * @property ModuleList4ParamsValues[] $moduleList4ParamsValues
 * @property ModuleList4Values[] $moduleList4Values
 */
class ModuleList4Params extends CActiveRecord
{
	public $type_title;
    public $defaultSettings = array(
        'list4' => array(
            'text1label' => array(
                'title' => 'Название поля «text1»',
                'type' => 'string',
                'value' => 'Text1',
            ),
            'text1' => array(
                'title' => 'Выводить поле «text1» в списке связанных элементов',
                'type' => 'checkbox',
                'value' => true,
            ),
            'type' => array(
                'title' => 'Одиночный выбор',
                'type' => 'checkbox',
                'value' => false,
            ),
        ),
    );


    public function afterSave() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
    public function afterDelete() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList4Params the static model class
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
		return 'rktv_module_list4_params';
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
            array('settings','safe'),
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
			'moduleList4ParamsValues' => array(self::HAS_MANY, 'ModuleList4ParamsValues', 'param_id'),
			'moduleList4Values' => array(self::HAS_MANY, 'ModuleList4Values', 'param_id'),
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
            // удаление всех альбомов
            if($this->findByPk($id)->data_type_id==8){
                $data = ModuleList4::model()->getList($mpage_id);
                foreach($data as $value){
                    $list_item_id = $value->id;
                    $param_value = ModuleList4Values::model()->getItem($list_item_id, $id);
                    if(
                        isset($param_value) &&
                        !empty($param_value['value']) &&
                        !is_null(ModuleGallery::model()->findByPk($param_value['value']))
                    ){
                        $gallery_id = $param_value['value'];
                        ModuleGallery::model()->deleteItemById($gallery_id);
                    }
                }
            }
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