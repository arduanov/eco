<?php

class MainController extends BackEndController
{

    public $layout = 'inner';


	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionUpload(){

        $folder = $_SERVER['DOCUMENT_ROOT'].'/upload/xml/';

        if(file_exists($folder.'import.zip')){

            /*
            $zip = Yii::app()->zip;

            if(!is_dir($folder.'extract/')){
                Yii::app()->file->CreateDir(0777, $folder.'extract/');
            } else {
               $this->actionDelete($folder.'extract');
               Yii::app()->file->CreateDir(0777, $folder.'extract/');
            } */

            //if($zip->extractZip($folder.'import.zip', $folder.'extract/')){


                if(ModuleCatalogCategory::model()->deleteCategoriesFromCatalog(4)){
                        $this->parseXML($folder.'extract/e/import.xml');
               }

            //}


            $this->redirect(Yii::app()->baseUrl.'?r=xml/main/success');

        }

        $this->render('index');

    }

    public function actionSuccess(){

        $this->render('success');

    }

    public function actionDelete($path = null){


        if(file_exists($path) && is_dir($path))
        {
            $dirHandle = opendir($path);
            while (false !== ($file = readdir($dirHandle)))
            {
                if ($file!='.' && $file!='..')// исключаем папки с назварием '.' и '..'
                {
                    $tmpPath=$path.'/'.$file;
                    chmod($tmpPath, 0777);

                    if (is_dir($tmpPath))
                    {  // если папка
                        $this->actionDelete($tmpPath);
                    }
                    else
                    {
                        if(file_exists($tmpPath))
                        {
                            // удаляем файл
                            unlink($tmpPath);
                        }
                    }
                }
            }
            closedir($dirHandle);

            // удаляем текущую папку
            if(file_exists($path))
            {
                rmdir($path);
            }
        }

    }

    public function groupAdd($groups, $id = null){

        $model = new ModuleCatalogCategory();

        if(!empty($id)){
            $model->parent_id = $id;
        }

        $model->catalog_id = 4;
        $success = 0;

        foreach($groups as $key => $value){


            if( $key === 'Ид' ) {

                $success++;
                $model->xml_id = $value;


           } else if( $key === 'Наименование' ) {

                $success++;
                $model->name = $value;

           } else  if(is_array($value)){


                if($success >= 2 && $model->save()){

                    $success = 0;
                    $this->groupAdd($value, $model->id);

                } else {
                    $this->groupAdd($value, $id);
                }
           } else if($success >= 2) {
                if($model->save()){
                    $success = 0;

                }
            }

        }

    }


    public function parseXML($path){

        $file = file_get_contents($path);
        //$xml = simplexml_load_string($file);
        //$xml = new SimpleXMLElement($file);
        //$doc = new DOMDocument();
        //$doc->load($path);

        $xml = simplexml_load_string($file);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        $catalog = array_shift($array);

        //$this->getRecursiveXML($catalog);

        foreach($catalog as $key => $value){
            if($key == 'Группы'){
                foreach($value as $key_groups => $value_groups){
                    if($key_groups == 'Группа'){
                            foreach($value_groups as  $key_group_lv3 => $value_group_lv3){
                                if($key_group_lv3 == 'Группы'){
                                    foreach($value_group_lv3 as  $key_group_lv4 => $value_group_lv4){
                                        foreach($value_group_lv4 as $k => $v){
                                            $this->groupAdd($v);
                                        }
                                    }
                                }
                            }
                    }
                }
            }
        }

        foreach($array as $key => $value){
            foreach($value as $key_cat => $value_cat){
                if($key_cat == 'Товары'){

                    foreach($value_cat as $key_product => $value_product){

                        if($key_product == 'Товар'){
                            foreach($value_product as $key_pr => $value_pr){
                                $this->productXmlAdd($value_pr);

                            }
                        }
                    }

                }
            }
        }
        $this->redirect(Yii::app()->baseUrl.'?r=xml/main/success');

    }


    public function productXmlAdd($product){

        $model = new ModuleCatalogProduct();
        $album_id = false;


        foreach($product as $key => $value){



            if($key == 'Ид'){
                $model->xml_id = $value;
            } else if($key == 'Наименование'){
                $model->name = $value;
            }  else if($key == 'БазоваяЕдиница'){
                $model->unit = $value;
            } else if($key == 'Картинка') {


                if(!is_array($value))
                    $value = array($value);


                    foreach($value as $value_img){



                        $name = explode('\\', $value_img);

                        $src = $_SERVER['DOCUMENT_ROOT'].'/upload/xml/extract/e'.str_replace('\\', '//', $value_img);
                        $folder = $_SERVER['DOCUMENT_ROOT'].'/'.Files::model()->getUploadFolder('catalog', true, true);



                        if((count($name) - 1) > 0 && file_exists($src) && $name[count($name) - 1] != 'www.eldorado.ru'){

                            $thumb = Yii::app()->thumb->create($src);

                            $iname = explode('.', $name[count($name) - 1]);

                            //&& copy($src, $folder.'/'.$name[count($name) - 1])

                            if(empty($album_id)){
                                $album_id = ModuleGalleryAlbums::model()->createAlbum('catalog');
                            }



                            $thumb->resize(320, 340);
                            $thumb->save($folder.'/'.$iname[count($iname) - 2].'_large.'.$iname[count($iname) - 1]);


                            $files = new Files();
                            $files->file_name = $iname[count($iname) - 2].'_large.'.$iname[count($iname) - 1];
                            $files->temp = 1;
                            $files->save();

                            ModuleGalleryPhotos::model()->createPhoto($album_id, $files->id);


                            $thumb->resize(190, 190);
                            $thumb->save($folder.'/'.$iname[count($iname) - 2].'_catalog.'.$iname[count($iname) - 1]);

                            $files = new Files();
                            $files->file_name = $iname[count($iname) - 2].'_catalog.'.$iname[count($iname) - 1];
                            $files->temp = 1;
                            $files->save();

                            ModuleGalleryPhotos::model()->createPhoto($album_id, $files->id);


                            $thumb->resize(100, 100);
                            $thumb->save($folder.'/'.$iname[count($iname) - 2].'_small.'.$iname[count($iname) - 1]);

                            $files = new Files();
                            $files->file_name = $iname[count($iname) - 2].'_small.'.$iname[count($iname) - 1];
                            $files->temp = 1;
                            $files->save();

                            ModuleGalleryPhotos::model()->createPhoto($album_id, $files->id);


                        }

                    }

            } else if ($key == 'Группы' && is_array($value)) {

                $value_group = $this->getProductGroupXmlId($value);
                $category_id = ModuleCatalogCategory::model()->getCategoryIdByXmlCode($value_group);
                if(!empty($category_id))
                    $model->category_id = $category_id;

            }
        }

        if(!empty($album_id)){
            $model->album_id = $album_id;
        }

        if($model->save() && isset($product["ХарактеристикиТовара"]["ХарактеристикаТовара"])){
            $this->addProperties($product["ХарактеристикиТовара"]["ХарактеристикаТовара"], $model->id, $product);
        }

    }


    public function getProductGroupXmlId($value){
        foreach($value as $key_group => $value_group){
            if($key_group == 'Ид'){
                return $value_group;
            }
        }
    }


    public function addProperties($value_pr, $product_id, $product){


        foreach($value_pr as $key_pr_lv1 => $value_pr_lv1){

            if(count($value_pr_lv1) > 0 && is_array($value_pr_lv1)){

                foreach($value_pr_lv1 as $key_pr_lv2 => $value_pr_lv2){



                            if(isset($product['Группы']['Ид'])){


                                $value_group = $product['Группы']['Ид'];
                                $category_id = ModuleCatalogCategory::model()->getCategoryIdByXmlCode($value_group);

                                if($key_pr_lv2 == 'Наименование' && !empty($category_id)){


                                    $param = explode(';', $value_pr_lv2);


                                    if(count($param) > 2 && strlen($param[0]) > 2 ){

                                        $group = new ModuleCatalogPropertyGroup();
                                        $group_id = false;

                                        if(!($group_id = $group->existByName($param[0]))){
                                            $group->name = $param[0];
                                            $group->save();
                                        }


                                        $property = new ModuleCatalogProperties();
                                        $property_id = false;


                                        if(!($property_id = $property->existByName($param[1], $category_id))){
                                            if(!empty($param[1])){
                                                $property = new ModuleCatalogProperties();
                                                $property->category_id = $category_id;
                                                $property->name = $param[1];
                                                $property->type_id = 1;
                                                $property->group_id = ($group_id)?$group_id:$group->id;
                                                $property->save();

                                                $property_id = $property->id;
                                            }
                                        }



                                        if(!empty($property_id)){

                                            $property_values = new ModuleCatalogPropertyValues();
                                            $property_values->product_id = $product_id;
                                            $property_values->property_id = $property_id;
                                            $property_values->value = (is_array($value_pr_lv1['Значение']))?'':$value_pr_lv1['Значение'];
                                            $property_values->save();
                                        }


                                    } else if(count($param) > 2 && empty($param[0]) ){

                                        $property = new ModuleCatalogProperties();
                                        $property_id = false;


                                        if(!($property_id = $property->existByName($param[1], $category_id))){
                                            if(!empty($param[1])){
                                                $property = new ModuleCatalogProperties();
                                                $property->category_id = $category_id;
                                                $property->name = $param[1];
                                                $property->type_id = 1;
                                                $property->save();

                                                $property_id = $property->id;
                                            }
                                        }

                                        if(!empty($property_id)){

                                            $property_values = new ModuleCatalogPropertyValues();
                                            $property_values->product_id = $product_id;
                                            $property_values->property_id = $property_id;
                                            $property_values->value = (is_array($value_pr_lv1['Значение']))?'':$value_pr_lv1['Значение'];
                                            $property_values->save();
                                        }

                                    }
                                }

                            }

                }

            }
        }
    }


}