<?php

/**
 * This is the model class for table "rktv_settings".
 *
 * The followings are the available columns in table 'rktv_settings':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $vk_key
 * @property string $fb_key
 * @property string $mail
 * @property integer $active
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $ogtitle
 * @property string $ogdescription
 * @property integer $ogimage
 *
 * The followings are the available model relations:
 * @property RktvFiles $ogimage0
 */
class Settings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Settings the static model class
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
		return 'rktv_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

    public function getMail(){
        
        $criteria = new CDbCriteria();
		$criteria->condition='active>0';



        return $this->find($criteria)->mail;
    }

    public function getMail2(){

        $criteria = new CDbCriteria();
        $criteria->condition='active>0';



        return $this->find($criteria)->mail2;
    }
    public function getMail3(){

        $criteria = new CDbCriteria();
        $criteria->condition='active>0';



        return $this->find($criteria)->mail3;
    }

    public function getActiveSettings(){

        $criteria = new CDbCriteria();
		$criteria->condition='active>0';

        return $this->find($criteria)->id;
    }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('active, ogimage', 'numerical', 'integerOnly'=>true),
			array('name, code, vk_key, fb_key, g_key, ya_key, title, description, keywords, ogtitle, ogdescription', 'length', 'max'=>255),
			array('mail,mail2,mail3', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, vk_key, fb_key, mail, mail2, mail3, active, title, description, keywords, ogtitle, ogdescription, ogimage', 'safe', 'on'=>'search'),
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
			'ogimage0' => array(self::BELONGS_TO, 'RktvFiles', 'ogimage'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'code' => 'Code',
			'vk_key' => 'VK key',
			'fb_key' => 'FB key',
            'ya_key' => 'YA key',
			'g_key' => 'GOOGLE key',
			'mail' => 'Электронная почта',
            'mail2' => 'Электронная почта для вакансий',
            'mail3' => 'Электронная почта для заявок на вклад',
			'active' => 'Active',
			'title' => 'Мета тег — title',
			'description' => 'Мета тег — description',
			'keywords' => 'Мета тег — keywords',
			'ogtitle' => 'Мета тег — og:title',
			'ogdescription' => 'Мета тег — og:description',
			'ogimage' => 'Мета тег — og:image',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('vk_key',$this->vk_key,true);
		$criteria->compare('fb_key',$this->fb_key,true);
		$criteria->compare('mail',$this->mail,true);
        $criteria->compare('mail2',$this->mail2,true);
        $criteria->compare('mail3',$this->mail3,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('ogtitle',$this->ogtitle,true);
		$criteria->compare('ogdescription',$this->ogdescription,true);
		$criteria->compare('ogimage',$this->ogimage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}