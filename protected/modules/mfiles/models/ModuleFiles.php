<?php

/**
 * This is the model class for table "rktv_module_files".
 *
 * The followings are the available columns in table 'rktv_module_files':
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $size
 * @property string $extension
 * @property string $link
 * @property integer $active
 * @property integer $file_id
 * @property integer $mpage_id
 * @property string $text
 * @property string $group_id
 *
 * The followings are the available model relations:
 * @property ModuleList4 $group
 * @property Files $file
 * @property ModulesInPages $mpage
 */
class ModuleFiles extends CActiveRecord
{
	public $year = '';
	public $count = 0;
	public $download_link = '';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleFiles the static model class
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
		return 'rktv_module_files';
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
			array('active, file_id, mpage_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('size', 'length', 'max'=>13),
			array('extension', 'length', 'max'=>10),
			array('link', 'length', 'max'=>500),
			array('group_id', 'length', 'max'=>11),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, date, size, extension, link, active, file_id, mpage_id, text, group_id', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'ModuleList4', 'group_id'),
			'file' => array(self::BELONGS_TO, 'Files', 'file_id'),
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
			'title' => 'Название',
			'date' => 'Дата',
			'size' => 'Размер',
			'extension' => 'Расширение',
			'link' => 'Ссылка',
			'active' => 'Опубликовать',
			'file_id' => 'File',
			'mpage_id' => 'Mpage',
			'text' => 'Описание',
			'group_id' => 'Группа',
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
		$criteria->compare('size',$this->size,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('mpage_id',$this->mpage_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('group_id',$this->group_id,true);

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
	
	public function getList($mpage_id, $offset = 0, $limit = 0, $active = NULL, $year = 0, $group_of_files = 0){
		$data = array();
		$criteria = new CDbCriteria();
		$condition = 't.mpage_id = :mpage_id';
		$params = array('mpage_id' => $mpage_id);
		if(!is_null($active)){
			$condition .= ' AND t.active = :active';
			$params['active'] = $active;
		}
		if(!empty($year)){
			$condition .= ' AND t.date >= :year0 AND t.date <= :year1';
			$params['year0'] = $year.'-01-01';
			$params['year1'] = $year.'-12-31';
		}
		$criteria->condition = $condition;
		$criteria->params = $params;
		$criteria->offset = floor($offset);
		$criteria->order = "t.date DESC, t.title ASC, t.id DESC";
		if($group_of_files) $criteria->order = "group.order_id DESC, group.id ASC, t.date DESC, t.title ASC, t.id DESC";
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->with('group')->findAll($criteria) as $value){
			$value->download_link = explode('/',$value->link);
			$value->download_link = $value->download_link[count($value->download_link)-1];
			$value->download_link = '/upload/files.php?filename='.$value->download_link;
            $data[$value->id] = $value;
        };
        return $data;
	}

	public function deleteItem($link_id, $id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
			$file_id = $this->findByPk($id)->file_id;
			if($this->findByPk($id)->delete() && Files::model()->deleteFileById($file_id, $module)){
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
			$value->download_link = explode('/',$value->link);
			$value->download_link = $value->download_link[count($value->download_link)-1];
			$value->download_link = '/upload/files.php?filename='.$value->download_link;
        }
        return $value;
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
}