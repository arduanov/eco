<?php

/**
 * This is the model class for table "rktv_module_list2".
 *
 * The followings are the available columns in table 'rktv_module_list2':
 * @property integer $id
 * @property string $title
 * @property string $short
 * @property string $text
 * @property integer $active
 * @property integer $img_id
 * @property string $order_id
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property RktvFiles $img
 * @property RktvModulesInPages $mpage
 */
class ModuleList2 extends CActiveRecord
{
	public $img = array();
	public $img_default = array();
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList2 the static model class
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
		return 'rktv_module_list2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('active, img_id, mpage_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('order_id', 'length', 'max'=>11),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, short, text, active, img_id, order_id, mpage_id', 'safe', 'on'=>'search'),
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
			'img' => array(self::BELONGS_TO, 'Files', 'img_id'),
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
			'title' => 'Наименование',
			'short' => 'Краткое описание',
			'text' => 'Описание',
			'active' => 'Опубликовать',
			'img_id' => 'Изображение',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('img_id',$this->img_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('mpage_id',$this->mpage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getCount($mpage_id, $active = NULL){
        $criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'mpage_id = :mpage_id';
			$criteria->params = array('mpage_id' => $mpage_id);
		};
        return $this->count($criteria);
    }

	public function existsItem($mpage_id, $id, $active = NULL){
		$criteria = new CDbCriteria();
		if(!is_null($active)){
			$criteria->condition = 'id = :id AND mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'id = :id AND mpage_id = :mpage_id';
			$criteria->params = array('id' => $id, 'mpage_id' => $mpage_id);
		};
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
		};
		$criteria->offset = floor($offset);
		$criteria->order = 'order_id DESC, id ASC';
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->img_id!=NULL) $data[$value->id]->img = $this->getImageById($value->img_id);
				else $data[$value->id]->img = $this->img_default;
        };
        return $data;
	}
	
	public function getOtherList($mpage_id = NULL, $id = NULL, $limit = 0, $active = 1){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id AND id <> :id AND active = :active';
		$criteria->params = array('mpage_id' => $mpage_id, 'id' => $id, 'active' => $active);
		$criteria->order = 'order_id DESC, id ASC';
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->img_id!=NULL) $data[$value->id]->img = $this->getImageById($value->img_id);
				else $data[$value->id]->img = $this->img_default;
        };
        return $data;
	}

	public function deleteItem($link_id, $id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
			$img_id = $this->findByPk($id)->img_id;
			if($this->findByPk($id)->delete()){
				Files::model()->deleteFileById($img_id, $module);
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
        $criteria->condition = 'mpage_id = :id';
        $criteria->params = array('id' => $link_id);
        foreach($this->findAll($criteria) as $value){
            $this->deleteItem($link_id, $value->id, $module);
        }
        if($this->count($criteria) == 0){
            if(ModulesInPages::model()->deleteLink($link_id))
                $result = true;
        }
        return $result;
    }

	public function getItem($id = NULL, $mpage_id = NULL){
		$criteria = new CDbCriteria;
		$criteria->condition = 'mpage_id = :mpage_id AND id = :id';
		$criteria->params = array('mpage_id' => $mpage_id, 'id' => $id);
        if($value = $this->find($criteria)){
            if($value->img_id!=NULL) $value->img = $this->getImageById($value->img_id);
				else $value->img = $this->img_default;
        }
        return $value;
	}

    public function getImageById($id){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('list2', false, true).Files::model()->findByPk($id)->file_name;
        else
            $result = null;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$result))
            $result = null;
		if($result!=null){
			$images = array();
			$i = 0;
			$result = $_SERVER['DOCUMENT_ROOT'].$result;
			foreach(array(array(93,60),array(205,0),array(96,96),array(220,220)) as $size){
				// [0] - админка список, [1] - админка редактир, [2] - сайт (мини в списке), [3] — сайт (страница конкретной акции)
				$i++;
				$cache_folder = explode('/',$result);
				$cache_folder[count($cache_folder)-1] = 'cache';
				$cache_folder = implode('/',$cache_folder);
				$img = explode('/',$result);
				$img[count($img)-1] = 'cache/size'.$i.'_'.$img[count($img)-1];
				$img = implode('/',$img);
				if(!is_dir($cache_folder)) mkdir($cache_folder,777);
				if(!file_exists($img)){
					$thumb = Yii::app()->thumb->create($result);
					$thumb->resize($size[0], $size[1]);
					$thumb->save($img);
				};
				$img = explode($_SERVER['DOCUMENT_ROOT'],$img);
				$images[] = $img[1];
			};
		}else{
			$images = $this->img_default;
		};
        return $images;
    }
}