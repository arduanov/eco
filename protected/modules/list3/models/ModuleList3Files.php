<?php

/**
 * This is the model class for table "rktv_module_list3_files".
 *
 * The followings are the available columns in table 'rktv_module_list3_files':
 * @property string $id
 * @property string $item_id
 * @property string $file_id
 * @property string $short
 */
class ModuleList3Files extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleList3Files the static model class
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
		return 'rktv_module_list3_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, file_id, short', 'required'),
			array('item_id, file_id', 'length', 'max'=>10),
			array('short', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, file_id, short', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'file_id' => 'File',
			'short' => 'Описание',
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
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('short',$this->short,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getList($id = null) {
        if ($id === null) return false;
        $files = $this->findAllByAttributes(array('item_id' => $id));
        if (count($files) == 0) return false;
        $list = array();
        foreach ($files as $file) {
            $list[$file->id]['file_id'] = $file->file_id;
            $list[$file->id]['short'] = $file->short;
            $list[$file->id]['ref'] = Files::model()->getVirtualPath('list3',$file->file_id);
            $list[$file->id]['file_name'] = Files::model()->findByPk($file->file_id)->file_name;
        }
        return $list;
    }
}