<?php

/**
 * This is the model class for table "rktv_modules_in_pages".
 *
 * The followings are the available columns in table 'rktv_modules_in_pages':
 * @property integer $id
 * @property integer $page_id
 * @property integer $module_id
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property RktvModules $module
 * @property RktvPages $page
 */
class ModulesInPages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ModulesInPages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getModulesInPage($id = false){

        $data = array();

        if($id){

            $criteria = new CDbCriteria();
            $criteria->condition = 'page_id = :page_id';
            $criteria->params = array('page_id' => $id);

            foreach($this->with('module')->findAll($criteria) as $value){
                $data[$value->id]['code'] = $value->module->code;
                $data[$value->id]['name'] = $value->module->name;
                $data[$value->id]['description'] = $value->module->description;
            }

        }

        return $data;
    }

    public function getModuleId($link_id){
        return Modules::model()->findByPk(ModulesInPages::model()->find('id = '.$link_id)->module_id)->code;
    }

    public function deleteLink($id){
        return $this->findByPk($id)->delete();
    }

    public function addLink($module_id, $page_id){
        $mIPage = new ModulesInPages();
        $mIPage->page_id = $page_id;
        $mIPage->module_id = $module_id;
        if($mIPage->save())
            return true;
        else
            return false;
    }
    public function getLink($page_id, $module_code){

        $modules = new Modules();

        $criteria = new CDbCriteria();
        $criteria->condition = 'code = :code';
        $criteria->params = array('code' => $module_code);

        $module_id = $modules->find($criteria)->id;


        $criteria = new CDbCriteria();
        $criteria->condition = 'page_id = :page_id and module_id = :module_id';
        $criteria->params = array('page_id' => $page_id, 'module_id' => $module_id);

        if(!is_null($this->find($criteria))){
            return $this->find($criteria)->id;
        } else
            return false;

    }

    public function getAllLinkPages(){

        $data = array();

        $modules = new Modules();

        $criteria=new CDbCriteria;
        $criteria->select='page_id, module_id';

        foreach($this->findAll($criteria) as $value){
            $data[$value->page_id] = $modules->findByPk($value->module_id)->name;
        }

        return $data;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rktv_modules_in_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, module_id', 'required'),
			array('page_id, module_id', 'numerical', 'integerOnly'=>true),
			array('comments', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, page_id, module_id, comments', 'safe', 'on'=>'search'),
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
			'module' => array(self::BELONGS_TO, 'Modules', 'module_id'),
			'page' => array(self::BELONGS_TO, 'Pages', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'page_id' => 'Page',
			'module_id' => 'Module',
			'comments' => 'Comments',
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
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('comments',$this->comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}