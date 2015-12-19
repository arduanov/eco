<?php

/**
 * This is the model class for table "rktv_module_list4_settings".
 *
 * The followings are the available columns in table 'rktv_module_list4_settings':
 * @property integer $mpage_id
 * @property string $title
 * @property integer $order_by_title
 * @property integer $news_type
 * @property integer $maps_fields
 * @property integer $ymaps
 * @property integer $edit_type
 * @property integer $pagination
 * @property integer $list_view
 * @property integer $import_csv
 * @property integer $export_csv
 * @property integer $btn_add
 * @property integer $btn_delete
 * @property integer $btn_params
 * @property integer $btn_active
 * @property integer $btn_order
 * @property integer $edit_short
 * @property integer $edit_text
 * @property integer $edit_img
 *
 * The followings are the available model relations:
 * @property ModulesInPages $mpage
 */
class ModuleList4Settings extends CActiveRecord
{

    public function afterSave() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
    public function afterDelete() {
        Yii::app()->cache->delete(md5('data#atms_list'));
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList4Settings the static model class
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
		return 'rktv_module_list4_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mpage_id', 'required'),
			array('mpage_id, order_by_title, news_type, maps_fields, ymaps, edit_type, pagination, list_view, import_csv, export_csv, btn_add, btn_delete, btn_params, btn_active, btn_order, edit_short, edit_text, edit_img', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mpage_id, title, order_by_title, news_type, maps_fields, ymaps, edit_type, pagination, list_view, import_csv, export_csv, btn_add, btn_delete, btn_params, btn_active, btn_order, edit_short, edit_text, edit_img', 'safe', 'on'=>'search'),
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
			'mpage_id' => 'Mpage',
            'title' => 'Название',
			'order_by_title' => 'Сортировать по названию (если не «Новости»)',
            'news_type' => 'Сортировать по дате (а-ля «Новости»)',
			'maps_fields' => 'Показать широту / долготу',
			'ymaps' => 'Использовать Yandex карты',
            'edit_type' => 'Режим редактирования',
            'pagination' => 'Кол-во страниц',
            'list_view' => 'Вид списка',
            'import_csv' => 'Импорт из .CSV',
            'export_csv' => 'Экспорт в .CSV',
            'btn_add' => 'Показать кнопку «Добавить»',
			'btn_delete' => 'Показать кнопку «Удалить»',
            'btn_params' => 'Показать кнопку «Параметры»',
            'btn_active' => 'Включить поле «Опубликовать / Не публиковать»',
			'btn_order' => 'Показать кнопку «Сохранить порядок сортировки» (если нет сортировки по названию)',
			'edit_short' => 'Включить поле «Краткое описание»',
			'edit_text' => 'Включить поле «Описание»',
			'edit_img' => 'Включить поле «Изображение»',
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

		$criteria->compare('mpage_id',$this->mpage_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('order_by_title',$this->order_by_title);
		$criteria->compare('news_type',$this->news_type);
		$criteria->compare('maps_fields',$this->maps_fields);
		$criteria->compare('ymaps',$this->ymaps);
		$criteria->compare('edit_type',$this->edit_type);
		$criteria->compare('pagination',$this->pagination);
		$criteria->compare('list_view',$this->list_view);
		$criteria->compare('import_csv',$this->import_csv);
		$criteria->compare('export_csv',$this->export_csv);
		$criteria->compare('btn_add',$this->btn_add);
		$criteria->compare('btn_delete',$this->btn_delete);
		$criteria->compare('btn_params',$this->btn_params);
		$criteria->compare('btn_active',$this->btn_active);
		$criteria->compare('btn_order',$this->btn_order);
		$criteria->compare('edit_short',$this->edit_short);
		$criteria->compare('edit_text',$this->edit_text);
		$criteria->compare('edit_img',$this->edit_img);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getList($mpage_id){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'mpage_id <> :mpage_id';
        $criteria->params = array('mpage_id' => $mpage_id);
        foreach($this->findAll($criteria) as $value){
            $data[$value->mpage_id] = $value;
        }
        return $data;
    }

    public function getItem($mpage_id){
        $criteria = new CDbCriteria();
        $criteria->condition = 'mpage_id = :mpage_id';
        $criteria->params = array('mpage_id' => $mpage_id);
        return $this->find($criteria);
    }
}