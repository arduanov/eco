<?php

/**
 * This is the model class for table "rktv_module_quotes".
 *
 * The followings are the available columns in table 'rktv_module_quotes':
 * @property string $id
 * @property string $date
 * @property string $usd_purchase
 * @property string $usd_selling
 * @property string $eur_purchase
 * @property string $eur_selling
 * @property integer $active
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property ModulesInPages $mpage
 */
class ModuleQuotes extends CActiveRecord
{
	public $year = '';
	public $count = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleQuotes the static model class
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
		return 'rktv_module_quotes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, usd_purchase, usd_selling, eur_purchase, eur_selling', 'required'),
			array('active, mpage_id', 'numerical', 'integerOnly'=>true),
			array('usd_purchase, usd_selling, eur_purchase, eur_selling', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, usd_purchase, usd_selling, eur_purchase, eur_selling, active, mpage_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Дата',
			'usd_purchase' => 'Покупка USD',
			'usd_selling' => 'Продажа USD',
			'eur_purchase' => 'Покупка EUR',
			'eur_selling' => 'Продажа EUR',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('usd_purchase',$this->usd_purchase,true);
		$criteria->compare('usd_selling',$this->usd_selling,true);
		$criteria->compare('eur_purchase',$this->eur_purchase,true);
		$criteria->compare('eur_selling',$this->eur_selling,true);
		$criteria->compare('active',$this->active);
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
		}
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
		$criteria->order = "date DESC, id DESC";
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
        }
        return $data;
	}
	
	public function getLastQuotesList($mpage_id = NULL, $quotes_id = NULL, $limit = 4, $active = 1){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id AND id <> :quotes_id AND active = :active';
		$criteria->params = array('mpage_id' => $mpage_id, 'quotes_id' => $quotes_id, 'active' => $active);
		$criteria->order = "date DESC";
		$criteria->limit = $limit;
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
        }
        return $data;
	}

	public function deleteItem($link_id, $id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
            $criteria = new CDbCriteria();
            $criteria->condition = 'id = :id AND mpage_id = :mpage_id';
            $criteria->params = array('id' => $id, 'mpage_id' => $link_id);
            $val=$this->find($criteria);
            if ($val->delete())
			    $result = true;
            else
                $result=false;
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
        $value = $this->find($criteria);
        return $value;
	}
}