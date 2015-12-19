<?php

/**
 * This is the model class for table "rktv_module_actions".
 *
 * The followings are the available columns in table 'rktv_module_actions':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $mpage_id
 * @property string $short
 * @property string $text
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property RktvModulesInPages $mpage
 * @property RktvModuleActionsData[] $rktvModuleActionsDatas
 */
class ModuleActions extends CActiveRecord
{

    public function getCategoryList($page_id = null){

        $data = array();

        if(!is_null($page_id)){

            $criteria = new CDbCriteria();
            $criteria->condition = 'mpage_id = :mpage_id';
            $criteria->params = array('mpage_id' => ModulesInPages::model()->getLink($page_id, Yii::app()->controller->module->id));

            foreach($this->findAll($criteria) as $value){
                $data[$value->id] = $value->name;
            }

            return $data;

        } else {
            return $data;
        }

    }

    public function categoryExist($id){

        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :id';
        $criteria->params = array('id' => $id);

        return $this->exists($criteria);

    }


    public function deleteCategory($id){

        $result = false;

        $actions = new ModuleActionsData();

        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->condition = 'action_category_id = :id';
        $criteria->params = array('id' => $id);

        foreach($actions->findAll($criteria) as $value){
            $actions->findByPk($value->id)->delete();
        }

        if($actions->count($criteria) == 0){
            if($this->findByPk($id)->delete())
                $result = true;
        }

        return $result;

    }

    /* Деактивация модуля, теперь в самом модуле ! */
    public function deactivation($link_id){

        $result = false;

        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->condition = 'mpage_id = :id';
        $criteria->params = array('id' => $link_id);

        foreach($this->findAll($criteria) as $value){
            $this->deleteCategory($value->id);
        }

        if($this->count($criteria) == 0){
            if(ModulesInPages::model()->deleteLink($link_id))
                $result = true;
        }

        return $result;

    }

    public function getCategoryNameById($id){
        return $this->findByPk($id)->name;
    }

    public function getAllCategory($link_id){

    }

    public function getAllFilesFromCategory($category_id = null){

    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return ModuleActions the static model class
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
		return 'rktv_module_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, mpage_id', 'required'),
			array('mpage_id, active', 'numerical', 'integerOnly'=>true),
			array('name, code', 'length', 'max'=>255),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, mpage_id, short, text, active', 'safe', 'on'=>'search'),
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
			'mpage' => array(self::BELONGS_TO, 'ModulesInPages', 'mpage_id'),
			'ActionsData' => array(self::HAS_MANY, 'ModuleActionsData', 'action_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Наименование',
			'code' => 'Идентификатор',
			'mpage_id' => 'Mpage',
			'short' => 'Краткое описание',
			'text' => 'Подробное описание',
			'active' => 'Активная категория',
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
		$criteria->compare('mpage_id',$this->mpage_id);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}