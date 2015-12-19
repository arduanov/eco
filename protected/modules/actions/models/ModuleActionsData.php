<?php

/**
 * This is the model class for table "rktv_module_actions_data".
 *
 * @author Kirilov E.E.
 * @lastModify 01.03.2012
 * @lastModifyAuthor Kirilov E.E.
 *
 * The followings are the available columns in table 'rktv_module_actions_data':
 * @property integer $id
 * @property string $name
 * @property string $short
 * @property string $text
 * @property string $date_begin
 * @property string $date_end
 * @property integer $small_img_id
 * @property integer $large_img_id
 * @property integer $action_category_id
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property RktvModuleActions $actionCategory
 */
class ModuleActionsData extends CActiveRecord
{
    /*This is terms group of model */
    public function scopes()
    {
        return array(
            'recently'=>array(
                'order' => 'date_end DESC',               
                'condition'=>'actionCategory.mpage_id=1',
            ),
        );
    }
   

    public function recently($mpage_id = 0, $active = null)
    {

        if(empty($active)){
            $this->getDbCriteria()->mergeWith(array(
                'order' => 'date_end DESC',
                'condition'=>'actionCategory.mpage_id='.$mpage_id,
            ));
        } else {
            $this->getDbCriteria()->mergeWith(array(
                'order' => 'date_end DESC',
                'condition'=>'t.active > 0 and actionCategory.mpage_id='.$mpage_id,
            ));
        }

        return $this;
    }

    public function getList($link_id){

        $data = array();

        foreach($this->with('actionCategory')->recently($link_id)->findAll() as $value){

            $data[$value->actionCategory->id][$value->id] = array(
                'name' => $value->name,
                'date_end' => Yii::app()->dateFormatter->format('d MMMM yyyy', $value->date_end),
                'date_begin' => Yii::app()->dateFormatter->format('d MMMM yyyy', $value->date_begin),
                'active' => $value->active,
            );
        }

        return $data;

    }

    public function getAllAction($link_id){

        $data = array();

        $criteria = new CDbCriteria();
        $criteria->condition = 't.active = 1 and t.date_end >= CURRENT_DATE()';
        
        foreach($this->with('actionCategory')->recently($link_id, 1)->findAll($criteria) as $value){

            $data[$value->id] = array(
                'name' => $value->name,
                'date_end' => Yii::app()->dateFormatter->format('d MMMM', $value->date_end),
                'date_begin' => Yii::app()->dateFormatter->format('d MMMM', $value->date_begin),
                'short' => $value->short,
                'images' => $this->getImages($value->id, 'actions'),
            );
        }

        return $data;

    }

    public function getLastActions($link_id, $id){

        $data = array();

        $criteria = new CDbCriteria();
        $criteria->condition = 'small_img_id > 0 and t.id <> :id';
        $criteria->params = array('id' => $id);
        $criteria->limit = 3;

        foreach($this->with('actionCategory')->recently($link_id, 1)->findAll($criteria) as $value){

            $data[$value->id] = array(
                'name' => $value->name,
                'date_end' => Yii::app()->dateFormatter->format('d MMMM', $value->date_end),
                'date_begin' => Yii::app()->dateFormatter->format('d MMMM', $value->date_begin),
                'short' => $value->short,
                'images' => $this->getImages($value->id, 'actions'),
            );
        }

        return $data;


    }

    public function getRandomAction(){
            $data = array();

            $criteria = new CDbCriteria();
            $criteria->condition = 'small_img_id > 0 and active > 0 and active = 1 and date_end >= CURRENT_DATE()';
            $criteria->limit = 1;
            $criteria->order = 'RAND()';

            foreach($this->findAll($criteria) as $value){

                $data[$value->id] = array(
                    'name' => $value->name,
                    'date_end' => Yii::app()->dateFormatter->format('d MMMM', $value->date_end),
                    'date_begin' => Yii::app()->dateFormatter->format('d MMMM', $value->date_begin),
                    'short' => $value->short,
                    'images' => $this->getImages($value->id, 'actions'),
                );
            }

            return $data;
    }


    public function getActionData($id){

        $value = $this->findByPk($id);

        $data = array(
            'id' => $value->id,
            'name' => $value->name,
            'date_end' => Yii::app()->dateFormatter->format('d MMMM', $value->date_end),
            'date_begin' => Yii::app()->dateFormatter->format('d MMMM', $value->date_begin),
            'short' => $value->short,
            'text' => $value->text,
            'images' => $this->getImages($value->id, 'actions'),
        );

        return $data;

    }



    public function getImages($id, $module){

        $data = array();

        if($img = $this->findByPk($id)->large_img_id)
            $data['large'] = Files::model()->getUploadFolder($module, false, true).Files::model()->findByPk($img)->file_name;

        if($img = $this->findByPk($id)->small_img_id)
            $data['small'] = Files::model()->getUploadFolder($module, false, true).Files::model()->findByPk($img)->file_name;

        return $data;

    }

    public function existsAction($id){

        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :id';
        $criteria->params = array('id' => $id);

        return $this->exists($criteria);

    }

    /* Удаление, реализовано не полдность на данныймомент отсутствует модуль галеерей */
    public function deleteAction($id){
        return $this->findByPk($id)->delete();
    }

    public function beforeSave() {

        if(!$this->isNewRecord){

            $img = ModuleActionsData::model()->findByPk($this->id)->small_img_id;

            if(!is_null($img) && !is_null($this->small_img_id) && $img != $this->small_img_id){
               Files::model()->deleteFileById($img, Yii::app()->controller->module->id);
            }

            $img = ModuleActionsData::model()->findByPk($this->id)->large_img_id;

            if(!is_null($img) && !is_null($this->large_img_id) && $img != $this->large_img_id){
                Files::model()->deleteFileById($img, Yii::app()->controller->module->id);
            }
        }

        return parent::beforeSave();
    }

    public function afterSave(){
        return parent::afterSave();
    }


	/**
	 * Returns the static model of the specified AR class.
	 * @return ModuleActionsData the static model class
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
		return 'rktv_module_actions_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date_begin, date_end, action_category_id', 'required'),
			array('small_img_id, large_img_id, action_category_id, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, short, text, date_begin, date_end, small_img_id, large_img_id, action_category_id, active', 'safe', 'on'=>'search'),
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
			'actionCategory' => array(self::BELONGS_TO, 'ModuleActions', 'action_category_id'),
            'smallImg' => array(self::BELONGS_TO, 'Files', 'small_img_id'),
            'largeImg' => array(self::BELONGS_TO, 'Files', 'mpage_id'),
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
			'short' => 'Краткое описание',
			'text' => 'Детальное описание',
			'date_begin' => 'Дата начала',
			'date_end' => 'Дата окончания',
			'small_img_id' => 'Картинка для анонса',
			'large_img_id' => 'Детальное изображение',
			'action_category_id' => 'Категория акций',
			'active' => 'Активна',
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
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date_begin',$this->date_begin,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('small_img_id',$this->small_img_id);
		$criteria->compare('large_img_id',$this->large_img_id);
		$criteria->compare('action_category_id',$this->action_category_id);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}