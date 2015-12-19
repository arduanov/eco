<?php

/**
 * This is the model class for table "rktv_module_list4_values".
 *
 * The followings are the available columns in table 'rktv_module_list4_values':
 * @property string $id
 * @property string $param_id
 * @property string $item_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property ModuleList4 $item
 * @property ModuleList4Params $param
 */
class ModuleList4Values extends CActiveRecord
{
	public $img = array();
	public $img_default = array();
	public $data_type_id = 0;
	public $title = '';

    public function afterSave() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
    public function afterDelete() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList4Values the static model class
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
		return 'rktv_module_list4_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('param_id, item_id', 'required'),
			array('param_id', 'length', 'max'=>5),
			array('item_id', 'length', 'max'=>11),
			array('value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, param_id, item_id, value', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'ModuleList4', 'item_id'),
			'param' => array(self::BELONGS_TO, 'ModuleList4Params', 'param_id'),
            'list3paramsvalues' => array(self::BELONGS_TO, 'ModuleList3ParamsValues', 'value'),
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
			'item_id' => 'Item',
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
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($item_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'item_id = :item_id';
		$criteria->params = array('item_id' => $item_id);
		foreach($this->findAll($criteria) as $value){
			$data[$value->param_id] = $value;
			$data_type_id = ModuleList4Params::model()->findByPk($value->param_id)->data_type_id;
			$data[$value->param_id]->data_type_id = $data_type_id;
			$title = ModuleList4Params::model()->findByPk($value->param_id)->title;
			$data[$value->param_id]->title = $title;
			if($data_type_id==7){
				$img_id = (int)$value->value;
				if($img_id>0 && Files::model()->existsFile($img_id)) $data[$value->param_id]->img = $this->getImageById($img_id);
					else $data[$value->param_id]->img = $this->img_default;
			}
		}
		return $data;
	}
	
	public function getListWithParams($item_id){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 't.item_id = :item_id';
		$criteria->params = array('item_id' => $item_id);
		$criteria->order = 'param.order_id DESC, t.param_id ASC, t.id ASC';
		foreach($this->with('param')->findAll($criteria) as $value){
			$param = ModuleList4Params::model()->getItem($value->param_id);
			if(!isset($data[$param->code]) || !is_array($data[$param->code])){
				$data[$param->code] = array();
				$data[$param->code]['id'] = $param->id;
				$data[$param->code]['title'] = $param->title;
				$data[$param->code]['data_type_id'] = $param->data_type_id;
			}
			// SELECT'ы
			if(in_array($param->data_type_id, array(5,6))){
				if(!isset($data[$param->code]['value']) || !is_array($data[$param->code]['value'])){
					$data[$param->code]['value'] = array();
				}
				$i = count($data[$param->code]['value']);
				$item_id = (int)$value->value;
				if(ModuleList4ParamsValues::model()->existsItem($param->id, $item_id)){
					$param_value = ModuleList4ParamsValues::model()->getItem($item_id);
					$data[$param->code]['value'][$i] = array();
					$data[$param->code]['value'][$i]['id'] = $param_value->id;
					$data[$param->code]['value'][$i]['title'] = $param_value->title;
				}
			}elseif(in_array($param->data_type_id, array(7))){
				$data[$param->code]['value'] = $value->value;
				$img_id = (int)$value->value;
				if($img_id>0 && Files::model()->existsFile($img_id)) $data[$param->code]['img'] = $this->getImageById($img_id);
					else $data[$param->code]['img'] = $this->img_default;
			}else{
				$data[$param->code]['value'] = $value->value;
			}
		}
		return $data;
	}
	
	public function exist_value($item_id, $param_id, $value){
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'item_id = :item_id AND param_id = :param_id AND value = :value';
		$criteria->params = array('item_id' => $item_id, 'param_id' => $param_id, 'value' => $value);
		return $this->exists($criteria);
	}
	
	public function existsItem($item_id, $param_id, $value = NULL){
		$criteria = new CDbCriteria();
		if(!is_null($value)){
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id AND value = :value';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id, 'value' => $value);
		}else{
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id);
		}
		return $this->exists($criteria);
	}
	
	public function getItem($item_id, $param_id, $value = NULL){
		$criteria = new CDbCriteria;
		if(!is_null($value)){
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id AND value = :value';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id, 'value' => $value);
		}else{
			$criteria->condition = 'param_id = :param_id AND item_id = :item_id';
			$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id);
		}
        return $this->find($criteria);
	}
	
	public function new_value($item_id, $param_id, $value = ''){
		$criteria = new CDbCriteria();
		$criteria->condition = 'param_id = :param_id AND item_id = :item_id';
		$criteria->params = array('param_id' => $param_id, 'item_id' => $item_id);
		$this->updateAll(array('value'=>$value),$criteria);
		return $this->exists($criteria);
	}

    public function getImageById($id){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('list4', false, true).Files::model()->findByPk($id)->file_name;
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