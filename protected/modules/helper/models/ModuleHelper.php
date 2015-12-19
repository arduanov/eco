<?php

/**
 * This is the model class for table "rktv_module_helper".
 *
 * The followings are the available columns in table 'rktv_module_helper':
 * @property string $id
 * @property string $parent_id
 * @property string $title
 * @property string $link
 * @property integer $mpage_id
 *
 * The followings are the available model relations:
 * @property ModulesInPages $mpage
 * @property ModuleHelper $parent
 * @property ModuleHelper[] $moduleHelpers
 */
class ModuleHelper extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleHelper the static model class
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
		return 'rktv_module_helper';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('mpage_id', 'numerical', 'integerOnly'=>true),
			array('parent_id', 'length', 'max'=>11),
			array('title, link', 'length', 'max'=>255),
            array('sort','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, title, link, mpage_id', 'safe', 'on'=>'search'),
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
			'parent' => array(self::BELONGS_TO, 'ModuleHelper', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Предыдущий шаг',
			'title' => 'Заголовок',
			'link' => 'Ссылка',
			'sort' => 'Порядок сортировки (чем значение больше, тем положение выше)',
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
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('mpage_id',$this->mpage_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function deactivation($link_id, $module){
        $result = false;
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->condition = 'mpage_id = :id AND parent_id IS NULL';
        $criteria->params = array('id' => $link_id);
        $this->deleteAllByAttributes($criteria);
        if($this->count($criteria) == 0){
            if(ModulesInPages::model()->deleteLink($link_id))
                $result = true;
        }
        return $result;
    }

    public function getTree($items = null,$parent_id = null,$level = 1, $maxlevel = 5) {
        if ($level > $maxlevel) return NULL;
        $level++;
        $tree = array();
        if (is_null($items)) {
            $criteria = new CDbCriteria();
            $criteria->order = 'sort DESC';
            foreach ($this->findAll($criteria) as $item) {
                $items[$item->id] = $item->getAttributes();
            }
        }

        foreach ($items as $item) {
            if ($item['parent_id'] == $parent_id) {
                $tree[$item['id']] =
                    array(
                        'title' => $item['title'],
                        'childs' => $this->getTree($items,$item['id'],$level),
                    );
            }
        }
        return $tree;
    }

    public function getDropDown($tree, $prefix = '') {
        $list = array();
        $list[0] = 'Без родителя';
        foreach ($tree as $id => $branch) {
            $list[$id] = $prefix.' '.$branch['title'];
            if (count($branch['childs']) > 0) {
                foreach ($this->getDropDown($branch['childs'],$prefix.'——') as $key => $child) {
                    $list[$key] = $child;
                }
            }
        }
        return $list;
    }

    public function getList() {
        $list = array();
        $criteria = new CDbCriteria();
        $criteria->order = 'sort DESC';
        foreach ($this->findAll($criteria) as $item) {
            $list[$item->id] = $item->getAttributes();
        }
        return $list;
    }

}