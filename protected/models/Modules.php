<?php

/**
 * This is the model class for table "rktv_modules".
 *
 * The followings are the available columns in table 'rktv_modules':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class Modules extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Modules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getAllModulesInPage($id = 0){
        $id = ($id == null)?0:$id;
        $data = array();

        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';
		
		foreach($this->findAll($criteria) as  $value){
			$data[$value->id]['name'] = $value->name;
			$data[$value->id]['code'] = $value->code;
			$data[$value->id]['active'] = (ModulesInPages::model()->find('page_id = '.$id.' and module_id = '.$value->id))?1:0;
			if($data[$value->id]['active'] == 1){
				$data[$value->id]['link_id'] = ModulesInPages::model()->find('page_id = '.$id.' and module_id = '.$value->id)->id;
			}
			$data[$value->id]['description'] = $value->description;
		}

        return $data;

    }

    public function getActiveModule($id = 0){

        $id = ($id == null)?0:$id;
        $data = array();

            foreach($this->findAll() as  $value){
                if(ModulesInPages::model()->find('page_id = '.$id.' and module_id = '.$value->id)){
                    $data[$value->id]['id'] = $value->id;
                    $data[$value->id]['name'] = $value->name;
                    $data[$value->id]['code'] = $value->code;
                    $data[$value->id]['active'] = 1;
                    $data[$value->id]['description'] = $value->description;
                    $data[$value->id]['link_id'] = ModulesInPages::model()->find('page_id = '.$id.' and module_id = '.$value->id)->id;
                }
            }

        return $data;

    }

    /* Return Module id by Code */
    public function getModuleIdByCode($code){

        $criteria = new CDbCriteria();
        $criteria->condition = 'code = :code';
        $criteria->params = array('code' => $code);

        return $this->find($criteria)->id;
    }

    /* Return Module id by Code */
    public function getModuleNameByCode($code){

        $criteria = new CDbCriteria();
        $criteria->condition = 'code = :code';
        $criteria->params = array('code' => $code);

        return $this->find($criteria)->name;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rktv_modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('name, code', 'length', 'max'=>128),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, description', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'code' => 'Code',
			'description' => 'Description',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}