<?php

/**
 * This is the model class for table "rktv_module_list4".
 *
 * The followings are the available columns in table 'rktv_module_list4':
 * @property string $id
 * @property string $date
 * @property string $title
 * @property string $short
 * @property string $text
 * @property string $longitude
 * @property string $latitude
 * @property integer $active
 * @property integer $img_id
 * @property string $order_id
 * @property integer $mpage_id
 * @property string $old_info_1
 * @property string $old_info_2
 * @property string $old_info_3
 *
 * The followings are the available model relations:
 * @property Files $img
 * @property ModulesInPages $mpage
 * @property ModuleList4List4[] $moduleList4List4s
 * @property ModuleList4List4[] $moduleList4List4s1
 * @property ModuleList4Values[] $moduleList4Values
 */
class ModuleList4 extends CActiveRecord
{
	public $img = array();
	public $img_default = array();
	public $params = array();

    public function afterSave() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
    public function afterDelete() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList4 the static model class
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
		return 'rktv_module_list4';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, title', 'required'),
			array('active, img_id, mpage_id', 'numerical', 'integerOnly'=>true),
			array('title, longitude, latitude, old_info_1, old_info_2, old_info_3', 'length', 'max'=>255),
			array('order_id', 'length', 'max'=>11),
			array('short, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, title, short, text, longitude, latitude, active, img_id, order_id, mpage_id, old_info_1, old_info_2, old_info_3', 'safe', 'on'=>'search'),
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
			'moduleList4List4s' => array(self::HAS_MANY, 'ModuleList4List4', 'id_1'),
			'moduleList4List4s1' => array(self::HAS_MANY, 'ModuleList4List4', 'id_2'),
			'moduleList4Values' => array(self::HAS_MANY, 'ModuleList4Values', 'item_id'),
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
			'title' => 'Наименование',
			'short' => 'Краткое описание',
			'text' => 'Описание',
			'longitude' => 'Долгота',
			'latitude' => 'Широта',
			'active' => 'Опубликовать',
			'img_id' => 'Изображение',
			'order_id' => 'Order',
			'mpage_id' => 'Mpage',
			'old_info_1' => 'Old Info 1',
			'old_info_2' => 'Old Info 2',
			'old_info_3' => 'Old Info 3',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('img_id',$this->img_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('mpage_id',$this->mpage_id);
		$criteria->compare('old_info_1',$this->old_info_1,true);
		$criteria->compare('old_info_2',$this->old_info_2,true);
		$criteria->compare('old_info_3',$this->old_info_3,true);

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
        $module_settings = ModuleList4Settings::model()->getItem($mpage_id);
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

        if($module_settings->news_type>0) $criteria->order = 'date DESC, id DESC';
        elseif($module_settings->order_by_title>0) $criteria->order = 'title ASC, id ASC';
        else $criteria->order = 'order_id DESC, id ASC';

        if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->img_id!=NULL) $data[$value->id]->img = $this->getImageById($value->img_id);
            else $data[$value->id]->img = $this->img_default;
            $data[$value->id]->params = ModuleList4Values::model()->getListWithParams($value->id);
        }
        return $data;
    }

    public function getListIds($mpage_id, $active = NULL){
        $data = array();
        $criteria = new CDbCriteria();
        if(!is_null($active)){
            $criteria->condition = 'mpage_id = :mpage_id AND active = :active';
            $criteria->params = array('mpage_id' => $mpage_id, 'active' => $active);
        }else{
            $criteria->condition = 'mpage_id = :mpage_id';
            $criteria->params = array('mpage_id' => $mpage_id);
        }
        foreach($this->findAll($criteria) as $value){
            $data[] = $value->id;
        }
        return $data;
    }
	
	public function getOtherList($mpage_id = NULL, $id = NULL, $limit = 0, $active = 1){
		$module_settings = ModuleList4Settings::model()->getItem($mpage_id);
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'mpage_id = :mpage_id AND id <> :id AND active = :active';
		$criteria->params = array('mpage_id' => $mpage_id, 'id' => $id, 'active' => $active);
		
		if($module_settings->news_type>0) $criteria->order = 'date DESC, id DESC';
			elseif($module_settings->order_by_title>0) $criteria->order = 'title ASC, id ASC';
				else $criteria->order = 'order_id DESC, id ASC';
		
		if($limit!=0) $criteria->limit = floor($limit);
        foreach($this->findAll($criteria) as $value){
            $data[$value->id] = $value;
            if($value->img_id!=NULL) $data[$value->id]->img = $this->getImageById($value->img_id);
				else $data[$value->id]->img = $this->img_default;
            $data[$value->id]->params = ModuleList4Values::model()->getListWithParams($value->id);
        }
        return $data;
	}

	public function deleteItem($link_id, $id, $module){
		$result = false;
		if(!is_null($id) && $this->existsItem($link_id,$id)){
            // удаление альбомов-параметров из модуля Gallery
            $params_list = ModuleList4Params::model()->getList($link_id);
            $params_values_list = ModuleList4Values::model()->getList($id);
            foreach($params_list as $value){
				if($value['data_type_id']==7){
					if(
                        isset($params_values_list[$value['id']]) &&
                        !empty($params_values_list[$value['id']]['value'])
                    ){
                        $file_id = (int)$params_values_list[$value['id']]['value'];
						Files::model()->deleteFile($file_id, $module);
                    }
				}
                if($value['data_type_id']==8){
                    if(
                        isset($params_values_list[$value['id']]) &&
                        !empty($params_values_list[$value['id']]['value']) &&
                        !is_null(ModuleGallery::model()->findByPk((int)$params_values_list[$value['id']]['value']))
                    ){
                        $gallery_id = (int)$params_values_list[$value['id']]['value'];
                        ModuleGallery::model()->deleteItemById($gallery_id);
                    }
                }
            }

            // удаление изображения
			$img_id = $this->findByPk($id)->img_id;
			if($this->findByPk($id)->delete()){
				Files::model()->deleteFile($img_id, $module);
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
            $value->params = ModuleList4Values::model()->getListWithParams($value->id);
        }
        return $value;
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
			foreach(array(array(93,60),array(205,0),array(186,136),array(272,181),array(110,70)) as $size){
				// [0] - админка список, [1] - админка редактир, [2] - сайт (мини в списке), [3] — сайт (страница конкретной акции), [4] — сайт (страница калькулятора)
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

    public function getList4($id, $mpage_id, $maxlevel = 1, $level = 1,$param_list = false)
    {
        if ($level > $maxlevel) return NULL;

        /*//$modulelist4 = new ModuleList4();
        //$val = $modulelist4->findByAttributes(array('id' => $id, 'mpage_id' => $mpage_id));
        //if (is_null($val)) return NULL;
        $val = (object) array('id'=>$id);
        //$list4 = $val->getAttributes();
        $list4 = array('id'=>$id);*/

        $modulelist4 = new ModuleList4();
        $val = $modulelist4->findByAttributes(array('id' => $id, 'mpage_id' => $mpage_id));
        if (is_null($val)) return NULL;
        $list4 = $val->getAttributes();
        if ($param_list !== false) {
            $params = ModuleList4Params::model()->findAllByAttributes(array('mpage_id' => $mpage_id,'code'=>$param_list));
        } else {
            $params = ModuleList4Params::model()->findAllByAttributes(array('mpage_id' => $mpage_id));
        }
        foreach ($params as $param) {
            $list4['params'][$param->id] = $param->getAttributes();
            $list4['params'][$param->id]['settings'] = unserialize($list4['params'][$param->id]['settings']);
            switch ($param->data_type_id) {
                case '1': case '2': case '3': case '4':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = $value->value;
                        $j++;
                    }
                    break;
                /* case '3':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = $value->value;
                        $j++;
                    }
                    break;
                case '4':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = $value->value;
                        $j++;
                    }
                    break; */
                case '5':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
					foreach ($values as $value)
					{
						$list4['params'][$param->id]['values'][$j]             = $value->getAttributes();
						$list4['params'][$param->id]['values'][$j]['value']    = ModuleList4ParamsValues::model()->
							findByPk($value->value)->title;

						$tmp_value = ModuleList4ParamsValues::model()->
							findByPk($value->value);
						if($tmp_value){
							$tmp_value_id= $tmp_value->id;
							$list4['params'][$param->id]['values'][$j]['value_id']=$tmp_value_id;
						}
//						$list4['params'][$param->id]['values'][$j]['value_id'] = ModuleList4ParamsValues::model()->
//							findByPk($value->value)->id;
						$j++;
					}
                    break;
					
                    // $values = ModuleList4Values::model()->with('list4paramsvalues')->findAllByAttributes(
                        // array(
                            // 't.param_id' => $param->id,
                            // 't.item_id' => $val->id,
                        // )
                    // );
                    // $j = 0;
                    // foreach ($values as $value) {
                        // $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        // $list4['params'][$param->id]['values'][$j]['value'] = $value->list4paramsvalues->title;
                        // $j++;
                    // }
                    break;
                case '8':
                    $value = ModuleList4Values::model()->findByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $photos = array();
                    // $gId = $list4['params'][$param->id]['value'] = '1234123412';//$value->value;
                    $gId = $value->value;
                    foreach (ModuleGalleryPhotos::model()->with('file')->findAllByAttributes(
                                 array('gallery_id' => $gId)) as $item) {
                        $photos[] = $item->file->file_name;
                    }
                    $list4['params'][$param->id]['value'] = $photos;
                    break;

                case '9':
                    $linked_mpages = array();
                    foreach (ModuleList4ParamsList4::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                        )
                    ) as $link) {
                        $linked_mpages[] = $link->mpage_id;
                    }
                    $j = 0;
                    foreach ($linked_mpages as $linked_mpage) {
                        $allowed = array();
                        foreach ($modulelist4->findAllByAttributes(array('mpage_id' => $linked_mpage)) as $v) {
                            $allowed[] = $v->id;
                        }
                        $linkparams = ModuleList4List4::model()->findAllByAttributes(
                            array(
                                'id_1' => $val->id,
                                'id_2' => $allowed,
                            )
                        );
                        foreach ($linkparams as $linkparam) {
                            $list4['params'][$param->id]['values'][$j] = $linkparam->getAttributes();
                            $list4['params'][$param->id]['values'][$j]['value'] = $this->getList4($linkparam->id_2, $linked_mpage, $maxlevel, $level + 1,$param_list);
                            $j++;
                        }
                    }
                    break;
                default:
                    break;
            }

        }
        return $list4;
    }
    /* public function getList4($id, $mpage_id, $maxlevel = 1, $level = 1)
    {
        if ($level > $maxlevel) return NULL;
        $modulelist4 = new ModuleList4();
        $val = $modulelist4->findByAttributes(array('id' => $id, 'mpage_id' => $mpage_id));
        if (is_null($val)) return NULL;
        $list4 = $val->getAttributes();
        $params = ModuleList4Params::model()->findAllByAttributes(array('mpage_id' => $mpage_id));
        foreach ($params as $param) {
            $list4['params'][$param->id] = $param->getAttributes();
            $list4['params'][$param->id]['settings'] = unserialize($list4['params'][$param->id]['settings']);
            switch ($param->data_type_id) {
                case '1':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = ModuleList4Values::model()->
                            findByPk($value->id)->value;
                        $j++;
                    }
                    break;
                case '3':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = ModuleList4Values::model()->
                            findByPk($value->id)->value;
                        $j++;
                    }
                    break;
                case '4':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = ModuleList4Values::model()->
                            findByPk($value->id)->value;
                        $j++;
                    }
                    break;
                case '5':
                    $values = ModuleList4Values::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $j = 0;
                    foreach ($values as $value) {
                        $list4['params'][$param->id]['values'][$j] = $value->getAttributes();
                        $list4['params'][$param->id]['values'][$j]['value'] = ModuleList4ParamsValues::model()->
                            findByPk($value->value)->title;
                        $j++;
                    }
                    break;
                case '8':
                    $value = ModuleList4Values::model()->findByAttributes(
                        array(
                            'param_id' => $param->id,
                            'item_id' => $val->id,
                        )
                    );
                    $photos = array();
                    $gId = $list4['params'][$param->id]['value'] = ModuleList4Values::model()->findByPk($value->id)->value;
                    foreach (ModuleGalleryPhotos::model()->findAllByAttributes(
                                 array('gallery_id' => $gId)) as $item) {
                        $photos[] = $item->file->file_name;
                    }
                    $list4['params'][$param->id]['value'] = $photos;
                    break;

                case '9':
                    $linked_mpages = array();
                    foreach (ModuleList4ParamsList4::model()->findAllByAttributes(
                        array(
                            'param_id' => $param->id,
                        )
                    ) as $link) {
                        $linked_mpages[] = $link->mpage_id;
                    }
                    $j = 0;
                    foreach ($linked_mpages as $linked_mpage) {
                        $allowed = array();
                        foreach ($modulelist4->findAllByAttributes(array('mpage_id' => $linked_mpage)) as $v) {
                            $allowed[] = $v->id;
                        }
                        $linkparams = ModuleList4List4::model()->findAllByAttributes(
                            array(
                                'id_1' => $val->id,
                                'id_2' => $allowed,
                            )
                        );
                        foreach ($linkparams as $linkparam) {
                            $list4['params'][$param->id]['values'][$j] = $linkparam->getAttributes();
                            $list4['params'][$param->id]['values'][$j]['value'] = $this->getList4($linkparam->id_2, $linked_mpage, $maxlevel, $level + 1);
                            $j++;
                        }
                    }
                    break;
                default:
                    break;
            }

        }
        return $list4;
    } */
}