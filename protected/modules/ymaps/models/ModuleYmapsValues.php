<?php

/**
 * This is the model class for table "rktv_module_ymaps_values".
 *
 * The followings are the available columns in table 'rktv_module_ymaps_values':
 * @property string $id
 * @property string $param_id
 * @property string $point_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property ModuleYmaps $point
 * @property ModuleYmapsParams $param
 */
class ModuleYmapsValues extends CActiveRecord
{
	public $img = array();
	public $img_default = array();
	public $data_type_id = 0;
	public $title = '';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleYmapsValues the static model class
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
		return 'rktv_module_ymaps_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('param_id, point_id', 'required'),
			array('param_id', 'length', 'max'=>5),
			array('point_id', 'length', 'max'=>11),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, param_id, point_id, value', 'safe', 'on'=>'search'),
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
			'point' => array(self::BELONGS_TO, 'ModuleYmaps', 'point_id'),
			'param' => array(self::BELONGS_TO, 'ModuleYmapsParams', 'param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'param_id' => 'Param',
			'point_id' => 'Point',
			'value' => 'Value',
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
		$criteria->compare('param_id',$this->param_id,true);
		$criteria->compare('point_id',$this->point_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Проверяет существование элемента
	 * @param type $mpage_id
	 * @param type $id
	 * @param type $active
	 * @return type 
	 */
	public function existsItem($param_id, $point_id){
		$criteria = new CDbCriteria();
		$criteria->condition = 'param_id = :param_id AND point_id = :point_id';
		$criteria->params = array('param_id' => $param_id, 'point_id' => $point_id);
		return $this->exists($criteria);
	}
	public function getItem($param_id, $point_id){
		$criteria = new CDbCriteria;
		$criteria->condition = 'param_id = :param_id AND point_id = :point_id';
		$criteria->params = array('param_id' => $param_id, 'point_id' => $point_id);
        return $this->find($criteria);
	}

	/**
	 *
	 * @param type $mpage_id
	 * @param type $offset
	 * @param type $limit
	 * @param type $active
	 * @return type 
	 */
	public function getInputList($point_id){
		return $this->getList($point_id);
	}
	
	public function getList($point_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'point_id = :point_id';
		$criteria->params = array('point_id' => $point_id);
		foreach($this->findAll($criteria) as $value){
			$data[$value->param_id] = $value;
			$data_type_id = ModuleYmapsParams::model()->findByPk($value->param_id)->data_type_id;
			$data[$value->param_id]->data_type_id = $data_type_id;
			$title = ModuleYmapsParams::model()->findByPk($value->param_id)->title;
			$data[$value->param_id]->title = $title;
			if($data_type_id==7){
				$img_id = (int)$value['value'];
				if($img_id>0 && Files::model()->existsFile($img_id)) $data[$value->param_id]->img = $this->getImageById($img_id);
					else $data[$value->param_id]->img = $this->img_default;
			}
		}
		return $data;
	}

    public function getImageById($id){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('ymaps', false, true).Files::model()->findByPk($id)->file_name;
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