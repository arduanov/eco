<?php

/**
 * This is the model class for table "rktv_module_gallery".
 *
 * The followings are the available columns in table 'rktv_module_gallery':
 * @property string $id
 * @property string $title
 * @property string $date
 * @property string $short
 * @property string $text
 * @property integer $active
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property ModulesInPages $mpage
 * @property ModuleGalleryPhotos[] $moduleGalleryPhotoses
 */
class ModuleGallery extends CActiveRecord
{
	public $photos = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleGallery the static model class
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
		return 'rktv_module_gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, date', 'required'),
			array('active, mpage_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, date, short, text, active, mpage_id', 'safe', 'on'=>'search'),
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
			'moduleGalleryPhotoses' => array(self::HAS_MANY, 'ModuleGalleryPhotos', 'gallery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'date' => 'Дата',
			'short' => 'Краткое описание',
			'text' => 'Полное описание',
			'active' => 'Опубликовать',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('mpage_id',$this->mpage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function existsItem($mpage_id, $id, $active = NULL){
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'id = :id AND mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'id = :id AND mpage_id = :mpage_id';
			$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id);
		}
		return $this->exists($criteria);
	}
	
	public function getList($mpage_id, $offset = 0, $limit = 0, $active = NULL){
		$data = array();
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'mpage_id = :mpage_id';
			$criteria->params = array('mpage_id' => $mpage_id);
		}
		$criteria->offset = floor($offset);
		$criteria->order = 'date DESC, id DESC';
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
        }
        return $data;
	}
	
	public function getListPhotos($mpage_id, $active = NULL){
		$data = array();
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'mpage_id = :mpage_id';
			$criteria->params = array('mpage_id' => $mpage_id);
		}
		$criteria->order = 'date DESC, id DESC';
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
			$data[$value->id]->photos = ModuleGalleryPhotos::model()->getList($value->id);
        }
        return $data;
	}

	public function deleteItem($mpage_id, $id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($mpage_id,$id)){
			$result = true;
			if(ModuleGalleryPhotos::model()->deleteList($id, $module) && $this->findByPk($id)->delete()) $result = true;
		}
		return $result;
	}

    /* Деактивация модуля, теперь в самом модуле ! */
    public function deactivation($mpage_id, $module){
        $result = true;
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->condition = 'mpage_id = :mpage_id';
        $criteria->params = array('mpage_id' => $mpage_id);
        foreach($this->findAll($criteria) as $value){
            if(!$this->deleteItem($mpage_id, $value->id, $module)) $result = false;
        }
        if($this->count($criteria) == 0){
            if(ModulesInPages::model()->deleteLink($mpage_id))
                $result = true;
        }
        return $result;
    }

	public function getItem($id = NULL, $mpage_id = NULL){
		$criteria = new CDbCriteria;
		$criteria->condition = 'mpage_id = :mpage_id AND id = :id';
		$criteria->params = array('mpage_id' => $mpage_id, 'id' => $id);
        $value = $this->find($criteria);
        return $value;
	}
}