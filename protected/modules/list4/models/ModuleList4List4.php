<?php

/**
 * This is the model class for table "rktv_module_list4_list4".
 *
 * The followings are the available columns in table 'rktv_module_list4_list4':
 * @property string $id_1
 * @property string $id_2
 *
 * The followings are the available model relations:
 * @property ModuleList4 $id2
 * @property ModuleList4 $id1
 */
class ModuleList4List4 extends CActiveRecord
{

    public function afterSave() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
    public function afterDelete() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList4List4 the static model class
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
		return 'rktv_module_list4_list4';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_1, id_2', 'required'),
			array('id_1, id_2', 'length', 'max'=>11),
            array('text1', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_1, id_2, text1', 'safe', 'on'=>'search'),
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
			'id2' => array(self::BELONGS_TO, 'ModuleList4', 'id_2'),
			'id1' => array(self::BELONGS_TO, 'ModuleList4', 'id_1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_1' => 'Id 1',
			'id_2' => 'Id 2',
            'text1' => 'Описание',
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

		$criteria->compare('id_1',$this->id_1,true);
		$criteria->compare('id_2',$this->id_2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'id_1 = :id';
		$criteria->params = array('id' => $id);
		foreach($this->findAll($criteria) as $value){
			$data[] = $value->id_2;
		}
		$criteria = new CDbCriteria();
		$criteria->condition = 'id_2 = :id';
		$criteria->params = array('id' => $id);
		foreach($this->findAll($criteria) as $value){
			$data[] = $value->id_1;
		}
		return $data;
	}

	public function getListOneSide($id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'id_1 = :id';
		$criteria->params = array('id' => $id);
		foreach($this->findAll($criteria) as $value){
			$data[] = $value->id_2;
		}
		return $data;
	}

    public function getText($id1,$id2){
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->condition = 'id_1 = :id1 AND id_2 = :id2';
        $criteria->params = array('id1' => $id1, 'id2' => $id2);
        $model = $this->find($criteria);
        if (!is_null($model)) {
            $data = $model->text1;
        } else {
            $criteria->params = array('id1' => $id2, 'id2' => $id1);
            $model = $this->find($criteria);
            if (!is_null($model)) {
                $data = $model->text1;
            }
        }
        return $data;
    }

	public function add($id1, $id2, $text1){
		$out = false;
		$model = $this->findByAttributes(array('id_1'=>$id1, 'id_2'=>$id2));
		if (is_null($model)) {
            $model = $this->findByAttributes(array('id_2'=>$id1, 'id_1'=>$id2));
        }
		if(is_null($model)){
			$model = new ModuleList4List4();
			$model->attributes = array('id_1'=>$id1, 'id_2'=>$id2,'text1'=> $text1);
			if($model->save()) $out = true;
		} else {
            $model->text1 = $text1;
            if($model->save()) $out = true;
        }
		return $out;
	}
}