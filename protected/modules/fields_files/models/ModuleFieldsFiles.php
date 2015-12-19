<?php

/**
 * This is the model class for table "rktv_module_fields_files".
 *
 * The followings are the available columns in table 'rktv_module_fields_files':
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $date_time
 * @property string $size
 * @property string $order_id
 * @property integer $mpage_id
 * @property string $extension
 * @property string $link
 * @property integer $file_id
 *
 * The followings are the available model relations:
 * @property Files $file
 */
class ModuleFieldsFiles extends CActiveRecord
{
	public $download_link = '';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleFieldsFiles the static model class
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
		return 'rktv_module_fields_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title', 'required'),
			array('mpage_id, file_id', 'numerical', 'integerOnly'=>true),
			array('code, title', 'length', 'max'=>255),
			array('size', 'length', 'max'=>13),
			array('order_id', 'length', 'max'=>11),
			array('extension', 'length', 'max'=>10),
			array('link', 'length', 'max'=>500),
			array('date_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, date_time, size, order_id, mpage_id, extension, link, file_id', 'safe', 'on'=>'search'),
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
			'file' => array(self::BELONGS_TO, 'Files', 'file_id'),
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
			'date_time' => 'Date Time',
			'size' => 'Size',
			'order_id' => 'Order',
			'mpage_id' => 'Mpage',
			'extension' => 'Extension',
			'link' => 'Link',
			'file_id' => 'Файл',
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
		$criteria->compare('date_time',$this->date_time,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('mpage_id',$this->mpage_id);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('file_id',$this->file_id);

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
        $criteria->order = 'order_id DESC, date_time DESC, id ASC';
		$criteria->offset = floor($offset);
		if($limit!=0) $criteria->limit = floor($limit);
		$data = array();
        foreach($this->findAll($criteria) as $value){
			$value->download_link = explode('/',$value->link);
			$value->download_link = $value->download_link[count($value->download_link)-1];
			$value->download_link = '/upload/fields_files.php?filename='.$value->download_link;
            $data[$value->id] = $value;
        };
        return $data;
	}

	public function getListByCode($mpage_id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id';
		$criteria->params = array('mpage_id' => $mpage_id);
        $criteria->order = 'order_id DESC, date_time DESC, id ASC';
		$criteria->offset = floor($offset);
		if($limit!=0) $criteria->limit = floor($limit);
		$data = array();
        foreach($this->findAll($criteria) as $value){
			$value->download_link = explode('/',$value->link);
			$value->download_link = $value->download_link[count($value->download_link)-1];
			$value->download_link = '/upload/fields_files.php?filename='.$value->download_link;
            $data[$value->code] = $value;
        };
        return $data;
	}

	public function deleteItem($link_id, $id){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
			$file_id = $this->findByPk($id)->file_id;
			if(Files::model()->deleteFileById($file_id, 'fields_files') && $this->findByPk($id)->delete()){
				$result = true;
			}
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
        if($value = $this->find($criteria)){
			$value->download_link = explode('/',$value->link);
			$value->download_link = $value->download_link[count($value->download_link)-1];
			$value->download_link = '/upload/fields_files.php?filename='.$value->download_link;
        }
        return $value;
	}
}