<?php

class Module_ymaps extends CWidget {
    
    public $page_id = null;
    public $page = 1;
    public $module_id = 'ymaps';
    
    /**
     *  Вызывается при редактировании страницы, на которой активирован этот модуль
     */
    public function run() {
        $page_id = $this->page_id;
        $controller = Yii::app()->getController();
        $model = new ModuleYmapsCategories();
        if (!is_null($page_id) && Pages::model()->existsPage($page_id)) {
            $this->create_item($page_id, $model);
            $this->render('module_ymaps', array('model' => $model, 'page_id' => $page_id));
        } else {
            $controller->redirect(Yii::app()->request->scriptUrl);
        };
    }
    /**
     * Создание категории точек на Google Maps
     * @param type $page_id ID страницы
     * @param type $model Ссылка на обрабатываемую модель
     */
    public function create_item($page_id = null, $model) {
        $controller = Yii::app()->getController();
        if (isset($_POST['ModuleYmapsCategories'])) {
            $_POST['ModuleYmapsCategories']['mpage_id'] = ModulesInPages::model()->getLink($page_id, $this->module_id);
            $model->attributes = $_POST['ModuleYmapsCategories'];
            if ($model->save()) {
                Yii::app()->user->setFlash($this->module_id . '_add_message', '<p style="color:green;">Добавлено</p>');
                $controller->redirect(Yii::app()->baseUrl . '?r=pages/update&id=' . $page_id . '&/#!/tab_' . $this->module_id);
            } else {
                Yii::app()->user->setFlash($this->module_id . '_add_message', '<p style="color:red;">Ошибка</p>');
            }
        }
    }

}