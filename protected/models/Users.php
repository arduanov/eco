<?php

/**
 * This is the model class for table "rktv_users".
 *
 * The followings are the available columns in table 'rktv_users':
 * @property integer $id
 * @property integer $role_id
 * @property string $login
 * @property string $password
 * @property string $username
 * @property string $hash
 * @property string $email
 * @property integer $state
 *
 * The followings are the available model relations:
 * @property RktvRole $role
 */
class Users extends CActiveRecord
{

    public $old_password = '';
    public $password_replace = '';
	/**
	 * Returns the static model of the specified AR class.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getUsers($role_id = 0, $offset = 0, $limit = 0){
		$criteria = new CDbCriteria();
		$criteria->condition = 'role_id>=:role_id';
		$criteria->params = array('role_id' => $role_id);
		$criteria->order = 'role_id ASC, login ASC ';
		if(!empty($offset)) $criteria->offset = $offset;
		if(!empty($limit)) $criteria->limit = $limit;
		
        $roles = new Roles();
        $data = array();
        foreach($this->findAll($criteria) as $value){
			$data[$value->id]['name'] = $value->username;
			$data[$value->id]['role'] = $roles->findByPk($value->role_id)->name;
			$data[$value->id]['login'] = $value->login;
        }
        return $data;
    }

    public function getCountUsers($role_id = 0, $condition = ''){
		$criteria = new CDbCriteria();
		$criteria->condition = 'role_id>=:role_id';
		$criteria->params = array('role_id' => $role_id);
		if(!empty($condition)) $criteria->addCondition($condition);
		
        return $this->count($criteria);
    }

    public function getRoles(){

        $data = array();
        $roles = new Roles();

        foreach($roles->findAll(array('select'=>'code, id')) as $value_r ){
            foreach(Yii::app()->authManager->roles as $value){
                if(strtolower(trim($value->name)) == strtolower(trim($value_r->code)))
                    $data[$value_r->id] = $value_r->code;
            }
        }

        return $data;

    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rktv_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, login', 'required'),
			array('role_id, state', 'numerical', 'integerOnly'=>true),
			array('login, password, hash', 'length', 'max'=>255),
			array('username, email', 'length', 'max'=>128),
            array('email', 'email'),
            // array('password', 'compare', 'compareAttribute'=>'password_replace'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role_id, login, password, username, hash, email, state', 'safe', 'on'=>'search'),
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
			'role' => array(self::BELONGS_TO, 'RktvRole', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_id' => 'Группа пользователей',
			'login' => 'Логин',
			'password' => 'Пароль',
			'username' => 'Имя пользователя',
			'hash' => 'Hash',
			'email' => 'Электронная почта',
			'state' => 'Активен',
            'password_replace' => 'Повторно введите пароль' ,
            'old_password' => 'Старый пароль',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}