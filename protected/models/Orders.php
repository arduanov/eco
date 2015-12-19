<?php

/**
 * This is the model class for table "rktv_orders".
 *
 * The followings are the available columns in table 'rktv_orders':
 * @property integer $id
 * @property string $session
 * @property string $ip
 * @property string $data
 * @property string $date
 * @property string $hash
 */
class Orders extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orders the static model class
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
		return 'rktv_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session, hash', 'required'),
			array('session, ip, hash', 'length', 'max'=>255),
			array('data, date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, session, ip, data, date, hash', 'safe', 'on'=>'search'),
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
			'session' => 'Session',
			'ip' => 'Ip',
			'data' => 'Data',
			'date' => 'Date',
			'hash' => 'Hash',
		);
	}

    public function existsHash($hash){

        $criteria = new CDbCriteria();
        $criteria->compare('hash', $hash);

        return $this->exists($criteria);

    }

    public function getDataByHash($hash){


        $criteria = new CDbCriteria();
        $criteria->condition = 'hash = :hash';
        $criteria->params = array('hash' => $hash);

        $data = $this->find($criteria);

        $result = unserialize($data->data);
        $result['date'] = $data->date;
        $result['account'] = $data->id;

        return $result;

    }



    public function getIdBySession($session){

        $criteria = new CDbCriteria();
        $criteria->compare('session', $session);

        return $this->find($criteria)->id;

    }

    public function existsOrder($id){

        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :id';
        $criteria->params = array('id' => $id);

        return $this->exists($criteria);

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
		$criteria->compare('session',$this->session,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hash',$this->hash,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}