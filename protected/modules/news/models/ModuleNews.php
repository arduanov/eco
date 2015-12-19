<?php

/**
 * This is the model class for table "rktv_module_news".
 *
 * The followings are the available columns in table 'rktv_module_news':
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $short
 * @property string $text
 * @property integer $active
 * @property integer $primary
 * @property integer $photo_id
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property RktvModulesInPages $mpage
 * @property RktvFiles $photo
 */
class ModuleNews extends CActiveRecord
{
	public $year = '';
	public $count = 0;
	public $img = array();
	public $img_default = array();
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleNews the static model class
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
		return 'rktv_module_news';
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
			array('active, primary, photo_id, mpage_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, date, short, text, active, primary, photo_id, mpage_id', 'safe', 'on'=>'search'),
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
			'photo' => array(self::BELONGS_TO, 'Files', 'photo_id'),
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
			'date' => 'Дата',
			'short' => 'Анонс',
			'text' => 'Полный текст',
			'active' => 'Опубликовать',
			'primary' => 'Primary',
			'photo_id' => 'Изображение',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('primary',$this->primary);
		$criteria->compare('photo_id',$this->photo_id);
		$criteria->compare('mpage_id',$this->mpage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getCount($mpage_id, $active = NULL, $year = 0){
        $criteria = new CDbCriteria();
		$condition = 'mpage_id = :mpage_id';
		$params = array('mpage_id' => $mpage_id);
		if(!is_null($active)){
			$condition .= ' AND active = :active';
			$params['active'] = $active;
		}
		if(!empty($year)){
			$condition .= ' AND date >= :year0 AND date <= :year1';
			$params['year0'] = $year.'-01-01';
			$params['year1'] = $year.'-12-31';
		}
		$criteria->condition = $condition;
		$criteria->params = $params;
        return $this->count($criteria);
    }

    public function get_years($mpage_id, $active = NULL){
		$data = array();
        $criteria = new CDbCriteria();
		$criteria->select = 'id, YEAR(date) AS year';
		if(!is_null($active)){
			$criteria->condition = 'mpage_id = :mpage_id AND active = :active';
			$criteria->params = array('mpage_id' => $mpage_id, 'active' => $active);
		}else{
			$criteria->condition = 'mpage_id = :mpage_id';
			$criteria->params = array('mpage_id' => $mpage_id);
		}
		$criteria->group = 'YEAR(date)';
		$criteria->order = 'YEAR(date) DESC';
		$i = 0;
		foreach($this->findAll($criteria) as $value){
            $data[$i] = $value;
			$criteria2 = new CDbCriteria();
			if(!is_null($active)){
				$criteria2->condition = 'mpage_id = :mpage_id AND YEAR(date) = :year AND active = :active';
				$criteria2->params = array('mpage_id' => $mpage_id, 'year' => $value->year, 'active' => $active);
			}else{
				$criteria2->condition = 'mpage_id = :mpage_id AND YEAR(date) = :year';
				$criteria2->params = array('mpage_id' => $mpage_id, 'year' => $value->year);
			}
			$data[$i]->count = $this->count($criteria2);
			$i++;
        }
        return $data;
		/*
		$criteria = new CDbCriteria();
		$criteria->select = '*, MAX(added_on) max_added_on';
		$criteria->condition = 'receiver_id = :receiverId';
		$criteria->group = 'sender_id';
		$criteria->order = 'priority_id DESC, max_added_on DESC';
		$criteria->params = array('receiverId' => $userId);
		
		$data = array();
		foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
        }
		 */
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
	
	public function getList($mpage_id, $offset = 0, $limit = 0, $active = NULL, $year = 0){
		$data = array();
		$criteria = new CDbCriteria();
		$condition = 'mpage_id = :mpage_id';
		$params = array('mpage_id' => $mpage_id);
		if(!is_null($active)){
			$condition .= ' AND active = :active';
			$params['active'] = $active;
		}
		if(!empty($year)){
			$condition .= ' AND date >= :year0 AND date <= :year1';
			$params['year0'] = $year.'-01-01';
			$params['year1'] = $year.'-12-31';
		}
		$criteria->condition = $condition;
		$criteria->params = $params;
		$criteria->offset = floor($offset);
		$criteria->order = "date DESC, id DESC";
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->photo_id!=NULL) $data[$value->id]->img = $this->getImageById($value->photo_id);
				else $data[$value->id]->img = $this->img_default;
        }
        return $data;
	}
	
	public function getLastNewsList($mpage_id = NULL, $news_id = NULL, $limit = 4, $active = 1){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id AND id <> :news_id AND active = :active';
		$criteria->params = array('mpage_id' => $mpage_id, 'news_id' => $news_id, 'active' => $active);
		$criteria->order = "date DESC";
		$criteria->limit = $limit;
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->photo_id!=NULL) $data[$value->id]->img = $this->getImageById($value->photo_id);
				else $data[$value->id]->img = $this->img_default;
        }
        return $data;
	}

	public function deleteItem($link_id, $id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
			$photo_id = $this->findByPk($id)->photo_id;
			if($this->findByPk($id)->delete() && Files::model()->deleteFileById($photo_id, $module)){
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
            if($value->photo_id!=NULL) $value->img = $this->getImageById($value->photo_id);
				else $value->img = $this->img_default;
        }
        return $value;
	}

    public function getImageById($id){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('news', false, true).Files::model()->findByPk($id)->file_name;
        else
            $result = null;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$result))
            $result = null;
		if($result!=null){
			$images = array();
			$i = 0;
			$result = $_SERVER['DOCUMENT_ROOT'].$result;
			foreach(array(array(93,60),array(205,0),array(640,0)) as $size){
				// [0] - админка список, [1] - админка редактир, [2] - сайт
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
				}
				$img = explode($_SERVER['DOCUMENT_ROOT'],$img);
				$images[] = $img[1];
			}
		}else{
			$images = $this->img_default;
		}
        return $images;
    }
}