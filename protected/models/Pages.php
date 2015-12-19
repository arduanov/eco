<?php

/**
 * This is the model class for table "rktv_pages".
 *
 * The followings are the available columns in table 'rktv_pages':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $short
 * @property integer $parent_id
 * @property string $text
 * @property integer $active
 * @property integer $sort
 * @property string $title
 * @property integer $image_id
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * The followings are the available model relations:
 * @property ModulesInPages[] $modulesInPages
 * @property Files $image
 * @property Pages $parent
 * @property Pages[] $pages
 */
class Pages extends CActiveRecord
{
	public $img = array();
	public $img_default = array();


    public function afterSave() {
		if($this->isNewRecord){
			/* $id = $this->id;
			$parent_id = $this->parent_id;
			$params = array();
			$mpage_id = 0;
			switch($parent_id){
				case 97: // Банкоматы
					$module_id = 'list4';
					$module = Yii::app()->getModule($module_id);
					$module->activation($id, array('maps_fields' => 1, 'ymaps' => 1, 'list_view' => 3, 'btn_params' => 0, 'edit_short' => 0, 'edit_text' => 0, 'edit_img' => 0));
					$mpage_id = ModulesInPages::model()->getLink($id, $module_id);
					$params = array(
						array('title' => 'Категория', 'code' => 'category', 'data_type_id' => 9, 'settings' => 'a:3:{s:10:"text1label";s:5:"Text1";s:5:"text1";b:0;s:4:"type";b:1;}'),
						array('title' => 'Адрес', 'code' => 'address', 'data_type_id' => 1),
						array('title' => 'Время работы', 'code' => 'time', 'data_type_id' => 1),
						array('title' => 'Фото', 'code' => 'img_p', 'data_type_id' => 7),
						array('title' => 'Схема', 'code' => 'img_s', 'data_type_id' => 7)
					);
					break;
				// case 9: // Люди
					// $module_id = 'list4';
					// $module = Yii::app()->getModule($module_id);
					// $module->activation($id, array('btn_params' => 0));
					// $mpage_id = ModulesInPages::model()->getLink($id, $module_id);
					// $params = array(
						// array('title' => 'Фотографии', 'code' => 'photo', 'data_type_id' => 8),
						// array('title' => 'Страница в интернете', 'code' => 'webpage', 'data_type_id' => 1),
						// array('title' => 'ВКонтакте', 'code' => 'vk', 'data_type_id' => 1),
						// array('title' => 'Facebook', 'code' => 'fb', 'data_type_id' => 1),
						// array('title' => 'Twitter', 'code' => 'tw', 'data_type_id' => 1),
						// array('title' => 'E-mail', 'code' => 'email', 'data_type_id' => 1),
					// );
					// break;
				// case 13: case 17: // Труппы / Цеха
					// $module_id = 'list4';
					// $module = Yii::app()->getModule($module_id);
					// $module->activation($id);
					// $mpage_id = ModulesInPages::model()->getLink($id, $module_id);
					// $params = array(
						// array('title' => 'Класс', 'code' => 'class', 'data_type_id' => 5),
						// array('title' => 'Фотографии', 'code' => 'photo', 'data_type_id' => 8),
						// array('title' => 'Страница в интернете', 'code' => 'webpage', 'data_type_id' => 1),
						// array('title' => 'ВКонтакте', 'code' => 'vk', 'data_type_id' => 1),
						// array('title' => 'Facebook', 'code' => 'fb', 'data_type_id' => 1),
						// array('title' => 'Twitter', 'code' => 'tw', 'data_type_id' => 1),
						// array('title' => 'E-mail', 'code' => 'email', 'data_type_id' => 1),
					// );
					// break;
			}
			if($mpage_id>0 && count($params)){
				foreach($params as $param){
					$model = new ModuleList4Params();
					$param['mpage_id'] = $mpage_id;
					$model->attributes = $param;
					$model->save();
				}
			} */
		}else{
			// при обновлении заголовка меняем название модуля
			$id = $this->id;
			$parent_id = $this->parent_id;
			$params = array();
			$mpage_id = 0;
			$module_id = 'list4';
			$module = Yii::app()->getModule($module_id);
			$mpage_id = ModulesInPages::model()->getLink($id, $module_id);
			if($mpage_id){
				$settings = ModuleList4Settings::model()->findByAttributes(array('mpage_id' => $mpage_id));
				if(!is_null($settings) && $settings->title!='Группы файлов'){
					$settings->attributes = array('title' => $this->name);
					$mpage_id = ModulesInPages::model()->getLink($id, $module_id);
					$settings->save();
				}
			}
		}
        Yii::app()->cache->flush();
    }

    public function afterDelete() {
        Yii::app()->cache->flush();
    }
	
    public function beforeDelete() {
		$out = true;
		$active = Modules::model()->getActiveModule($this->id);
		foreach($active as $value){
			$module = Yii::app()->getModule($value['code']);
			if(!$module->deactivation($this->id)) $out = false;
		}
        return $out;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pages the static model class
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
		return 'rktv_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('parent_id, active, sort, image_id', 'numerical', 'integerOnly'=>true),
			array('name, code', 'length', 'max'=>128),
			array('title', 'length', 'max'=>255),
			array('short, text, meta_keywords, meta_description, template,redirect,hidden', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, short, parent_id, text, active, sort, title, image_id, meta_keywords, meta_description,template,redirect,hidden', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// новые связи
		/* return array(
			'modulesInPages' => array(self::HAS_MANY, 'ModulesInPages', 'page_id'),
			'image' => array(self::BELONGS_TO, 'Files', 'image_id'),
			'parent' => array(self::BELONGS_TO, 'Pages', 'parent_id'),
			'pages' => array(self::HAS_MANY, 'Pages', 'parent_id'),
		); */
		// старые связи
		return array(
			'rktvCatalogs' => array(self::HAS_MANY, 'RktvCatalog', 'page_id'),
			'rktvGalleries' => array(self::HAS_MANY, 'RktvGallery', 'page_id'),
			'parent' => array(self::BELONGS_TO, 'Pages', 'parent_id'),
			'rktvPages' => array(self::HAS_MANY, 'Pages', 'parent_id'),
            'mPage' => array(self::HAS_MANY, 'ModulesInPages', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			// 'name' => 'Наименование',
			'name' => 'Название',
			'code' => 'Код страницы',
			'short' => 'Краткое описание',
			'parent_id' => 'Родитель',
			'text' => 'Произвольный Текст',
			'active' => 'Активный',
			'sort' => 'Сортировка',
            'title' => 'Заголовок',
            'image_id' => 'image id',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
            'template' => 'Шаблон',
            'redirect' => 'Редирект на подраздел',
            'hidden' => 'Скрыть из меню',
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
		$criteria->compare('short',$this->short,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
        $criteria->compare('redirect',$this->redirect,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    /* Рекурсивное удаление страниц */
    public function deletePageById($id = null){

        if(!empty($id) && $this->existsPage($id)){

            $sql = "
                SELECT
                    id
                FROM
                  rktv_pages
                WHERE
                  parent_id = ".(int)$id."
            ";

            $data = Yii::app()->db->createCommand($sql)->queryAll();


            if(count($data) > 0){
                foreach($data as $value){
                    $this->deletePageById($value['id']);
                }
            }
            Pages::model()->findByPk($id)->delete();


        }

    }

    /* return false or true */
    public function checkLinkToModule($id = null){

        if(!is_null($id)){

            $modInPages = new ModulesInPages();

            $modLinkPage = $modInPages->getAllLinkPages();
            $data = array($id => $this->findByPk($id)->name);
            $result = array();

            $data = $this->getIdArray($id, $data);


            foreach($data as $key => $value){
                foreach($modLinkPage as $key_m => $value_m){
                    if($key == $key_m){
                        $result[$key] = $value_m;
                    }
                }
            }

            if(count($result) > 0)
                return $result;
            else return false;

        }

    }

    public function getPageNameById($id = false){
        if($id){
            return $this->findByPk($id)->name;
        } else
            return false;
    }

    public function getPageText($id = false){
        if($id){
            return $this->findByPk($id)->text;
        } else
            return false;
    }

    public function getIdArray($parent = null, $data, $step = '', $page_id = null){

        $criteria = new CDbCriteria();
        $criteria->order='sort asc';
        if ($parent == null)
            $criteria->condition = 'parent_id is null';
        else {
            $criteria->condition = 'parent_id = :parent_id';
            $criteria->params = array('parent_id' => $parent);
        }

        if(!is_null($page_id)){
            $criteria->addCondition('id != '.$page_id);
        }

        if($this->count($criteria) > 0){

            foreach($this->findAll($criteria) as $value){

                // if($value->parent_id > 0){
                $data[$value->id] = $step.' '.$value->name;

                if($this->count('parent_id = '.$value->id) > 0)
                    $data = $this->getIdArray($value->id, $data, $step.'——', $page_id);
                /*}  else {
                    $data[$value->id] = array('name' => $value->name);
                }*/
            }
        }
        return $data;
        
    }

    public function getPageParentId($id = false){
        if($id){
            if($this->findByPk($id)->parent_id == null)
                    return false;
            else
                    return $this->findByPk($id)->parent_id;
        } else
                return false;
    }

    public function getTreePages2($active = false, $order = 'asc') {
        $cacheId = 'getTreePages2'.intval($active).$order;
        $returnValue = Yii::app()->cache->get($cacheId);
        if($returnValue !== false)
        {
            return $returnValue;
        }
        function getBranch($pages,$parent = null,$level = 1,$level_limit = 4) {
            $branch = NULL;
            if ($level > $level_limit) return $branch;
            foreach ($pages as $page) {
                if ($page['parent_id'] == $parent) {
                    if (is_null($branch)) {
                        $branch = array();
                    }
                    $branch[$page['id']] = array(
                        'name' => $page['name'],
                        'parent' => array(),
                        'code' => $page['code'],
                        'title' => $page['title'],
                        'image' => $page['image_id'],
                        'short' => $page['short'],
                        'parent_id' => $page['parent_id'],
                        'active' => $page['active'],
                        'meta_keywords' => $page['meta_keywords'],
                        'meta_description' => $page['meta_description'],
                        'redirect' => $page['redirect'],
                        'hidden' => $page['hidden'],
                        'child' => getBranch($pages,$page['id'],$level + 1, $level_limit),
                    );

                }
            }
            return $branch;
        }
        $criteria = new CDbCriteria();
        if ($order == 'desc')
            $criteria->order='id desc';
        else
            $criteria->order='sort asc';
        if($active){
            $criteria->addCondition('active > 0');
        }

        $pages = array();
        $tree = array();
        $list = Pages::model()->findAll($criteria);
        foreach ($list as $page) {
            $pages[$page->id] = $page->getAttributes();
        }
        $tree = getBranch($pages,NULL);
        Yii::app()->cache->set($cacheId,$tree);
        return $tree;
    }

    public function getTreePages($parent = null, $data, $active = false, $level = 1, $chose_lv = null, $order = 'asc'){

        $criteria = new CDbCriteria();
        if ($order == 'desc')
            $criteria->order='id desc';
        else
            $criteria->order='sort asc';

        if ($parent == null)
                $criteria->condition = 'parent_id is null';
        else {
            $criteria->condition = 'parent_id = :parent_id';
            $criteria->params = array('parent_id' => $parent);
        }

        if($active){
            $criteria->addCondition('active > 0');
        }
		
        if($this->count($criteria) > 0){
			
            foreach($this->findAll($criteria) as $value){

                   // if($value->parent_id > 0){
                    if(empty($chose_lv)){
                        $data[$value->id] = array(
                            'name' => $value->name,
                            'parent' => array(),
                            'code' => $value->code,
                            'title' => $value->title,
                            'image' => $value->image_id,
                            'short' => $value->short,
                            'parent_id' => $value->parent_id,
                            'active' => $value->active,
                            'meta_keywords' => $value->meta_keywords,
                            'meta_description' => $value->meta_description,
                        );
                    } else if($level == $chose_lv){
                        $data[$value->id] = array(
                            'name' => $value->name,
                            'choose_id' => (int)$value->id,
                            'parent' => array(),
                            'code' => $value->code,
                            'title' => $value->title,
                            'image' => $value->image_id,
                            'short' => $value->short,
                            'parent_id' => $value->parent_id,
                            'active' => $value->active,
                            'meta_keywords' => $value->meta_keywords,
                            'meta_description' => $value->meta_description,
                        );
                    }


                    if(empty($chose_lv)){
                        $data[$value->id]['child'] = $this->getTreePages($value->id, $data[$value->id]['child'], $active, ($level + 1), $chose_lv, $order);
                    } else {
                        $data = $this->getTreePages($value->id, $data, $active, ($level + 1), $chose_lv, $order);
                    }
                 /*}  else {
                        $data[$value->id] = array('name' => $value->name);
                    }*/
            }
        }
	
        return $data;

    }

    public function getLastPagesFromLevel($level = 3, $limit = 10){

        $data = array();

        $data = $this->getTreePages(null, $data, true, 1, $level);

        if(count($data) > $limit)
          $data = array_slice($data, 0, $limit);


        return $data;

    }

    public function getPage($code = 'index'){
        
        $criteria = new CDbCriteria();
        $criteria->condition='code=:code';
        $criteria->params=array(':code'=>strtolower(trim($code)));

        if ($this->count($criteria) > 0){
            
        } else
                return array();
        
    }

    public function existsPage($page_id){

        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :id';
        $criteria->params = array('id' => $page_id);

        return $this->exists($criteria);
    }

    public function existsPageByCode($code){

        $criteria = new CDbCriteria();
        $criteria->condition = 'code = :code';
        $criteria->params = array('code' => $code);

        return $this->exists($criteria);
    }

    public function getPageDataByCode($code){

        $data = array();

        $criteria = new CDbCriteria();
        $criteria->condition = 'code = :code';
        $criteria->params = array('code' => $code);

        foreach($this->findAll($criteria) as $value){
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $data['title'] = $value->title;
            $data['code'] = $value->code;
            $data['short'] = $value->short;
            $data['text'] = $value->text;
        }

        return $data;

    }

    public function getPageDataById($id){

        $data = array();

        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :id';
        $criteria->params = array('id' => $id);

        foreach($this->findAll($criteria) as $value){
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $data['title'] = $value->title;
            $data['code'] = $value->code;
            $data['short'] = $value->short;
            $data['text'] = $value->text;
        }

        return $data;

    }

    public function getImage($id, $module){

        $data = '';

        if($img = $this->findByPk($id)->image_id)
            $data = Files::model()->getUploadFolder($module, false, true).Files::model()->findByPk($img)->file_name;

        return $data;

    }

    public function get_images($id){
        return $this->getImageById($this->findByPk($id)->image_id);
    }
	
    /* Проверка на уникальный код страницы */
    public function checkPageCode(){

        $criteria = new CDbCriteria();
        $criteria->condition = 'code = :code';
        $criteria->params = array('code' => $this->code);

        if($this->exists($criteria) && $this->id != $this->find($criteria)->id){
            $this->addError('code','Данный <strong>«Уникальный идентификатор»</strong> уже существует.');
        }

    }
	
	/*формирование ссылки на ресурс по его id*/
	function make_url($id){
		$url = '';
		do{
			$code = $this->findByPk($id)->code;
			$url = $code.'/'.$url;
			$id = $this->getPageParentId($id);
		}while($id);
		if($url=='/'){
			return '';
		}else{
			return '/'.$url;
		}
	}
	function set_url($text){
		$out = '';
		for($i=0; $i<strlen($text); $i++){
			if($i<strlen($text)-11 && substr($text,$i,11)=='[[make_url_' && substr($text,$i+11,1)!=']'){
				for($j=$i+11; $j<strlen($text); $j++){
					if(substr($text,$j,2)==']]'){
						break 1;
					}
				}
				$id = floor(substr($text,$i+11,$j-$i));
				$out .= substr($this->make_url($id),1); //хак для TinyMCE
				$i = $j+1;
			}else{
				$out .= substr($text,$i,1);
			}
		}
		return $out;
	}

    public function getImageById($id,$sizes = array(array(471,471),array(212,213))){
        $result = null;
        if(!empty($id))
            $result = '/'.Files::model()->getUploadFolder('page', false, true).Files::model()->findByPk($id)->file_name;
        else
            $result = null;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$result))
            $result = null;
		if($result!=null){
			$images = array();
			$i = 0;
			$result = $_SERVER['DOCUMENT_ROOT'].$result;
			foreach($sizes as $size){
				// [0] - сайт
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