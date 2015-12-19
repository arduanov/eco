<?php

class MainController extends BackEndController
{
    public function actionUpdate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$mpage_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList4::model()->existsItem($mpage_id,$id)){
				
				// обработка параметров с одним значением
				if(isset($_POST['ModuleList4Values']) && is_array($_POST['ModuleList4Values']) && count($_POST['ModuleList4Values'])){
					foreach($_POST['ModuleList4Values'] as $key => $value){
						$key = (int)$key;
						$data_type_id = ModuleList4Params::model()->findByPk($key)->data_type_id;
						if(ModuleList4Values::model()->existsItem($id, $key)){
							$params_value = ModuleList4Values::model()->getItem($id, $key);
							if($data_type_id==7){
								$old_file_id = (int)$params_value->value;
							}
							ModuleList4Values::model()->new_value($id,  $key, '0');
							$params_value->attributes = array('value' => $value);
							if($params_value->save() && $data_type_id==7){
								$file_id = (int)$value;
								if($file_id>0) Files::model()->saveTempFile($file_id);
								if($old_file_id!=$file_id) Files::model()->deleteFile($old_file_id,$this->module->id);
							}
							$criteria = new CDbCriteria();
							$criteria->condition = 'param_id = :param_id AND item_id = :item_id AND id <> :id';
							$criteria->params = array('param_id' => $key, 'item_id' => $id, 'id' => $params_value->id);
							ModuleList4Values::model()->deleteAll($criteria);
						}else{
							$params_value = new ModuleList4Values();
							$params_value->attributes = array(
								'param_id' => $key,
								'item_id' => $id,
								'value' => $value
							);
							if($params_value->save() && $data_type_id==7){
								$file_id = (int)$value;
								if($file_id>0) Files::model()->saveTempFile($file_id);
							}
						}
					}
				}
				// обработка файлов
                if(isset($_POST['ModuleList4Files'])) {
                    $list4file = new ModuleList4Files();
                    $list4file->short = $_POST['ModuleList4Files']['short'];
                    $list4file->file_id = $_POST['ModuleList4Files']['file_id'];
                    $list4file->item_id = $id;
                    if ($list4file->save()) {
                        Files::model()->saveTempFile((int)$list4file->file_id);
                    }
                    else {
                        Files::model()->deleteFile($list4file->file_id,$this->module->id);
                        Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
                    }
                }
				// обработка параметров с несколькими значениями
				if(isset($_POST['ModuleList4ValuesMultiply']) && is_array($_POST['ModuleList4ValuesMultiply']) && count($_POST['ModuleList4ValuesMultiply'])){
					foreach($_POST['ModuleList4ValuesMultiply'] as $key => $value){
						ModuleList4Values::model()->new_value($id, (int)$key, '0');
						foreach($value as $key2 => $value2){
							if(ModuleList4Values::model()->existsItem($id, (int)$key, '0')){
								$params_value = ModuleList4Values::model()->getItem($id, (int)$key, '0');
								$params_value->attributes = array('value' => $value2);
								$params_value->save();
							}else{
								$params_value = new ModuleList4Values();
								$params_value->attributes = array(
									'param_id' => (int)$key,
									'item_id' => $id,
									'value' => $value2
								);
								$params_value->save();
							}
						}
					}
				}
				// обработка параметров типа «List4»
                if($page_id==99){
                    $list4ids = ModuleList4::model()->getListIds($mpage_id);
                }
				if(isset($_POST['ModuleList4List4']) && is_array($_POST['ModuleList4List4']) && count($_POST['ModuleList4List4'])){
					foreach($_POST['ModuleList4List4'] as $k => $v){
						if(is_array($v) && count($v)){
							foreach($v as $key => $value){
								$key = (int)$key;
								$value = (int)$value;
								$text = isset($_POST['ModuleList4List4Text'][$k][$key]) ? trim($_POST['ModuleList4List4Text'][$k][$key]) : '';
								if($key>0){
									if(empty($value)){
										ModuleList4List4::model()->deleteAllByAttributes(array('id_1'=>$id, 'id_2'=>$key));
										ModuleList4List4::model()->deleteAllByAttributes(array('id_2'=>$id, 'id_1'=>$key));
									}else{
                                        if($page_id==99){
                                            ModuleList4List4::model()->deleteAllByAttributes(array('id_1'=>$list4ids, 'id_2'=>$key));
                                            ModuleList4List4::model()->deleteAllByAttributes(array('id_2'=>$list4ids, 'id_1'=>$key));
                                            ModuleList4List4::model()->add($key, $id, $text);
                                        }else{
                                            ModuleList4List4::model()->add($id, $key, $text);
                                        }
									}
								}
							}
						}else{
							ModuleList4List4::model()->deleteAllByAttributes(array('id_1'=>$id));
							ModuleList4List4::model()->deleteAllByAttributes(array('id_2'=>$id));
							$key = (int)$k;
							$value = (int)$v;
							$text = isset($_POST['ModuleList4List4Text'][$k]) ? trim($_POST['ModuleList4List4Text'][$k]) : '';
							if($key>0 && $value>0){
								ModuleList4List4::model()->add($id, $value, $text);
							}
						}
					}
				}
				// сохранение порядка в парамтерах типа «фотогалереях»
				if(isset($_POST['gallery_ids']) && is_array($_POST['gallery_ids']) && count($_POST['gallery_ids'])){
					foreach($_POST['gallery_ids'] as $k=>$v){
						$gallery_id = (int)$k;
						$v = explode(',',$v);
						if(count($v)>1){
							$out = "UPDATE rktv_module_gallery_photos SET order_id= CASE";
							for($i=count($v); $i>0; $i--){
								$out .= " WHEN id='".intval($v[count($v)-$i])."' THEN '$i'";
							}
							$out .= " ELSE order_id END WHERE gallery_id = $gallery_id";
							$connection = Yii::app()->db;
							$command = $connection->createCommand($out);
							$out = $command->execute();
						}
					}
				}
				// обработка основных полей
				$model = ModuleList4::model()->findByPk($id);
				if(isset($_POST['ModuleList4'])){
					$old_file_id = $model->img_id;
					if($_POST['ModuleList4']['img_id']=='NULL') $_POST['ModuleList4']['img_id'] = '';
					$model->attributes = $_POST['ModuleList4'];
					if((int)$_POST['ModuleList4']['img_id']) Files::model()->saveTempFile((int)$_POST['ModuleList4']['img_id']);
						elseif($_POST['ModuleList4']['img_id']=='') Files::model()->deleteFile($old_file_id,$this->module->id);
                    if($model->save()){
						if($old_file_id!=$model->img_id) Files::model()->deleteFile($old_file_id,$this->module->id);
						Yii::app()->user->setFlash('message','<p style="color:green;">Сохранено</p>');
						$this->redirect(Yii::app()->baseUrl.'?r='.$this->module->id.'/main/update&page_id='.$page_id.'&id='.$id);
					}else{
						Yii::app()->user->setFlash('message','<p style="color:red;">Ошибка</p>');
					}
				}
				$model = ModuleList4::model()->getItem($id,$mpage_id);
				$params_list = ModuleList4Params::model()->getList($mpage_id);
				$params_values_list = ModuleList4Values::model()->getList($id);
                $files = ModuleList4Files::model()->getList($id);
				$module_settings = ModuleList4Settings::model()->getItem($mpage_id);
                $this->pageTitle = $module_settings->title;
				$this->render('update', array(
					'page_id' => $page_id,
					'params_list' => $params_list,
					'params_values_list' => $params_values_list,
					'model' => $model,
					'module_settings' => $module_settings,
                    'files' => $files,
				));
			}else{
				$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
			}
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

    public function actionDelete($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(ModuleList4::model()->deleteItem($link_id,$id,$this->module->id)) Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:green;">Удалено</p>');
				else Yii::app()->user->setFlash($this->module->id.'_delete_message','<p style="color:red;">Ошибка удаления</p>');
            $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }

	/* Публикация элемента списка */
    public function actionActivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList4::model()->existsItem($link_id,$id)) ModuleList4::model()->updateByPk($id,array('active'=>1));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }

	/* Снятие с публикации элемента списка */
    public function actionDeactivate($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			if(!is_null($id) && ModuleList4::model()->existsItem($link_id,$id)) ModuleList4::model()->updateByPk($id,array('active'=>0));
			$this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_'.$this->module->id);
        }else{
            $this->redirect(Yii::app()->request->scriptUrl);
        }
    }
	
	/* Активация модуля */
    public function actionActivation($page_id = null){
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id)){
			ModulesInPages::model()->addLink($this->module_id, $page_id);
			$link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
			$model = new ModuleList4Settings();
			$model->attributes = array(
				'mpage_id' => $link_id,
				'title' => Pages::model()->findByPk($page_id)->name
			);
			$model->save();
		}
        $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
    }	
    
    /* Деактивация модуля */
    public function actionDeactivation($page_id = null){
        $result = false;
		// доступно для пользователей первой роли (например, «Реактиву»)
		$role_id = Users::model()->findByPk(Yii::app()->user->id)->role_id;
        if($role_id<2 && !is_null($page_id) && Pages::model()->existsPage($page_id)){
            $link_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
            if($link_id) $result = ModuleList4::model()->deactivation($link_id, $this->module->id);
        }
        if($result) $this->redirect(Yii::app()->baseUrl.'?r=pages/update&id='.$page_id.'&/#!/tab_fourth');
			else $this->redirect(Yii::app()->request->baseUrl.'/admin.php');
    }

    public function actionExport_csv($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			$link_id = ModulesInPages::model()->getLink((int)$page_id, $this->module->id);
			$data = ModuleList4::model()->getList($link_id, 0, 0, 1);
			$out = '';
			foreach($data as $value){
				$out .= '"'.str_replace('"','\"',$value['title']).'","'.str_replace('"','\"',$value['short'])."\"\r\n";
			}
			
			$ctype="application/force-download";
			header("Pragma: public"); // required 
			header("Expires: 0"); 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
			header("Cache-Control: private",false); // required for certain browsers  
			header("Content-Type: $ctype"); 
			// change, added quotes to allow spaces in filenames, by Rajkumar Singh 
			header("Content-Disposition: attachment; filename=\"".basename('export.csv')."\";" ); 
			header("Content-Transfer-Encoding: binary"); 
			// header("Content-Length: ".filesize($filename)); 
			echo $out;
		}else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }

    public function actionImport_csv($page_id = null, $id = null){
        if(!is_null($page_id) && Pages::model()->existsPage($page_id)){
			die;
			$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
			$params = ModuleYmaps::model()->getList(3);
			foreach($params as $k => $v){
				$model = new ModuleList4();
				$model->attributes = array(
					'date' => date('Y-m-d'),
					'title' => $v->title,
					'latitude' => $v->latitude,
					'longitude' => $v->longitude,
					'active' => $v->active,
					'order_id' => $v->order_id,
					'mpage_id' => $mpage_id
				);
				$model->save();
				$new_id = $model->id;
				// адрес
				if(ModuleYmapsValues::model()->existsItem(24, $v->id)){
					$old_value = ModuleYmapsValues::model()->getItem(24, $v->id);
					$value = new ModuleList4Values();
					$value->attributes = array(
						'param_id' => 287,
						'item_id' => $new_id,
						'value' => $old_value->value
					);
					$value->save();
				}
				// время раюоты
				if(ModuleYmapsValues::model()->existsItem(1, $v->id)){
					$old_value = ModuleYmapsValues::model()->getItem(1, $v->id);
					$value = new ModuleList4Values();
					$value->attributes = array(
						'param_id' => 288,
						'item_id' => $new_id,
						'value' => $old_value->value
					);
					$value->save();
				}
				// фото
				if(ModuleYmapsValues::model()->existsItem(25, $v->id)){
					$old_value = ModuleYmapsValues::model()->getItem(25, $v->id);
					$value = new ModuleList4Values();
					$value->attributes = array(
						'param_id' => 289,
						'item_id' => $new_id,
						'value' => $old_value->value
					);
					$value->save();
					$img_id = (int)$old_value->value;
					if($img_id>0 && Files::model()->existsFile($img_id)){
						$file = Files::model()->findByPk($img_id);
						$file->attributes = array(
							'module' => 'list4'
						);
						$file->save();
					}
				}
				// схема
				if(ModuleYmapsValues::model()->existsItem(26, $v->id)){
					$old_value = ModuleYmapsValues::model()->getItem(26, $v->id);
					$value = new ModuleList4Values();
					$value->attributes = array(
						'param_id' => 290,
						'item_id' => $new_id,
						'value' => $old_value->value
					);
					$value->save();
					$img_id = (int)$old_value->value;
					if($img_id>0 && Files::model()->existsFile($img_id)){
						$file = Files::model()->findByPk($img_id);
						$file->attributes = array(
							'module' => 'list4'
						);
						$file->save();
					}
				}
			}
			echo 'done';
			/*
			// перенос видео
			// $youtube = file_get_contents('http://gdata.youtube.com/feeds/api/videos?max-results=50&alt=json&author=permopera');
			$youtube = file_get_contents('http://gdata.youtube.com/feeds/api/videos?max-results=50&start-index=51&alt=json&author=permopera');
			$youtube = json_decode($youtube);
			echo '<pre>';
			print_r($youtube->feed->entry);
			$i = 0;
			foreach($youtube->feed->entry as $value){
				$url = '';
				foreach($value->id as $key2 => $value2){
					$value2 = explode('/',$value2);
					$value2 = $value2[count($value2)-1];
					$url = 'https://www.youtube.com/watch?v='.$value2;
				}
				// echo ', ';
				$date = date('Y-m-d');
				foreach($value->published as $key2 => $value2){
					$value2 = explode('T',$value2);
					$value2 = $value2[0];
					$date = $value2;
				}
				// echo ', ';
				$title = '';
				foreach($value->title as $key2 => $value2){
					$title = $value2;
					break;
				}
				// echo ', ';
				$content = '';
				foreach($value->content as $key2 => $value2){
					$content = $value2;
					break;
				}
				// echo '<br>';
				$criteria = new CDbCriteria();
				$criteria->condition = 'mpage_id = :mpage_id AND video = :video';
				$criteria->params = array('mpage_id' => 15, 'video' => $url);
				if(ModuleVideo::model()->count($criteria)==0){
					$video = new ModuleVideo();
					$video->attributes = array(
						'date' => $date,
						'title' => $title,
						'video' => $url,
						'preview' => $content,
						'active' => 1,
						'mpage_id' => 15
					);
					print_r(array(
						'date' => $date,
						'title' => $title,
						'video' => $url,
						'preview' => $content,
						'active' => 1,
						'mpage_id' => 15
					));
					$video->save();
					$i++;
				}
			}
			echo '</pre>';
			echo $i;
			*/
			
			die;
			
			$mpage_id = ModulesInPages::model()->getLink($page_id, $this->module->id);
			$host = '192.168.0.2';
			$user = 'root';
			$pwd = ''; 
			$db = mysql_connect($host,$user,$pwd);
			mysql_select_db("operaold",$db);
			
			// $spektakl_id_where_people_with_more_than_1_id = array();
			$sql = "
				SELECT id, type, published, scenario, director, notes FROM ds_performances
			";
			$sqlres = mysql_query($sql) or die("Query failed: ".$sql);
			while ($row = mysql_fetch_array($sqlres)){
				/*
				// обновление данных о репертуаре
				$reper = ModuleList4::model()->findByAttributes(array(
					'old_info_1' => $row['id'],
					'mpage_id' => $mpage_id
				));
				$id = $reper->id;
				if($row['published']=='n'){
					$reper->attributes = array('active' => 0);
					$reper->save();
				}
				
				$model = new ModuleList4Values();
				$model->attributes = array(
					'param_id' => 79,
					'item_id' => $id,
					'value' => iconv('cp1251', 'utf-8', $row['scenario'])
				);
				$model->save();
				
				$director = iconv('cp1251', 'utf-8', $row['director']);
				$director = explode(',', $director);
				foreach($director as $k => $d){
						$director[$k] = trim($d);
				}
				foreach($director as $k => $d){
				
					$people_id = array();
					$criteria = new CDbCriteria();
					$criteria->condition = 'title = :title';
					$criteria->params = array('title' => $d);
					foreach(ModuleList4::model()->findAll($criteria) as $value){
						$people_id[] = $value->id;
					}
					if(count($people_id)){
						if(count($people_id)>1){
							$spektakl_id_where_people_with_more_than_1_id[] = $id;
						}
						foreach($people_id as $value){
							// сохраняем постановщика для существующих людей в БД
							$model = new ModuleList4List4();
							$model->attributes = array(
								'id_1' => $id,
								'id_2' => $value
							);
							$model->save();
						}
						unset($director[$k]);
					}
				}
				if(count($director)){
					$model = new ModuleList4Values();
					$model->attributes = array(
						'param_id' => 93,
						'item_id' => $id,
						'value' => implode(', ', $director)
					);
					$model->save();
				}else{
					$model = new ModuleList4Values();
					$model->attributes = array(
						'param_id' => 93,
						'item_id' => $id,
						'value' => ''
					);
					$model->save();
				}
				
				$value_old = $row['type'];
				if($value_old>2){
					$sql2 = "SELECT * FROM ds_perfom_types WHERE id = $value_old";
					$sqlres2 = mysql_query($sql2) or die("Query failed: ".$sql2);
					while ($row2 = mysql_fetch_array($sqlres2)){
						$model = new ModuleList4Values();
						$model->attributes = array(
							'param_id' => 101,
							'item_id' => $id,
							'value' => iconv('cp1251', 'utf-8', $row2['type_name'])
						);
						$model->save();
					}
				}
				*/
				
			/*
			// перенос афиши
			$mpage_id_spek = ModulesInPages::model()->getLink(50, $this->module->id);
			$mpage_id_afi = ModulesInPages::model()->getLink(8, $this->module->id);
			$mpage_id_rep = 17;
			$sql = "
				SELECT * FROM ds_playbill ORDER BY date ASC, timeb ASC
			";
			$sqlres = mysql_query($sql) or die("Query failed: ".$sql);
			$spektakl_id_where_people_with_more_than_1_id = array();
			while ($playbill = mysql_fetch_array($sqlres)){
				$repertuar = ModuleList4::model()->findByAttributes(array(
					'old_info_1' => iconv('cp1251', 'utf-8', $playbill['category_id']),
					'mpage_id' => $mpage_id_rep,
				));
				$repertuar_id = $repertuar->id;
				
				$date = new DateTime($playbill['date']);
				// echo $repertuar->title,' (',$date->format('d.m.Y'),' в ',$playbill['timeb'],')<br><ul>';
				
				// сохраняем спектакль
				$spektakl = new ModuleList4();
				$spektakl->attributes = array(
					'date' => $playbill['date'],
					'title' => $repertuar->title.' ('.$date->format('d.m.Y').' в '.$playbill['timeb'].')',
					'old_info_1' => iconv('cp1251', 'utf-8', $playbill['id']),
					'old_info_2' => iconv('cp1251', 'utf-8', $playbill['category_id']),
					'old_info_3' => iconv('cp1251', 'utf-8', $playbill['page_id']),
					'active' => 1,
					'mpage_id' => $mpage_id_spek
				);
				$spektakl->save();
				$spektakl_id = $spektakl->id;
				// связь с репертуаром
				$model = new ModuleList4List4();
				$model->attributes = array(
					'id_1' => $spektakl_id,
					'id_2' => $repertuar_id
				);
				$model->save();
				
				$sql2 = "
					SELECT * FROM ds_roles_playbill WHERE category_id = ".$playbill['id']."
				";
				$sqlres2 = mysql_query($sql2) or die("Query failed: ".$sql2);
				$role_arr = array();
				while ($role_playbill = mysql_fetch_array($sqlres2)){
					$sql3 = "
						SELECT * FROM ds_truppa WHERE id = ".$role_playbill['actor_id']."
					";
					$sqlres3 = mysql_query($sql3) or die("Query failed: ".$sql3);
					while ($actor = mysql_fetch_array($sqlres3)){
						$actor_fio = trim(iconv('cp1251', 'utf-8', $actor['fio']));
						if(!isset($role_arr[$actor_fio])){
							$role_arr[$actor_fio] = array(
								'text' => array(),
								'people_id' => array()
							);
							$criteria = new CDbCriteria();
							$criteria->condition = 'title = :title';
							$criteria->params = array('title' => $actor_fio);
							foreach(ModuleList4::model()->findAll($criteria) as $value){
								$role_arr[$actor_fio]['people_id'][] = $value->id;
							}
						}
					}
					
					$sql3 = "
						SELECT * FROM ds_roles WHERE id = ".$role_playbill['rep_id']."
					";
					$sqlres3 = mysql_query($sql3) or die("Query failed: ".$sql3);
					while ($role = mysql_fetch_array($sqlres3)){
						$role_arr[$actor_fio]['text'][] = iconv('cp1251', 'utf-8', $role['name']);
					}
				}
				$others = array();
				foreach($role_arr as $actor_fio => $value){
					// echo '<li>',implode(', ',$value['people_id']),' : ',$actor_fio,' - ',implode(', ',$value['text']),'</li>';
					if(count($value['people_id'])){
						if(count($value['people_id'])>1){
							$spektakl_id_where_people_with_more_than_1_id[] = $spektakl_id;
						}
						foreach($value['people_id'] as $people_id){
							// сохраняем роли для существующих людей в БД
							$model = new ModuleList4List4();
							$model->attributes = array(
								'id_1' => $spektakl_id,
								'id_2' => $people_id,
								'text1' => implode(', ',$value['text'])
							);
							$model->save();
						}
					}else{
						$others[] = $actor_fio.' — '.implode(', ',$value['text']);
					}
				}
				
				// сохраняем других людей
				$others = implode("\r\n",$others);
				$model = new ModuleList4Values();
				$model->attributes = array(
					'param_id' => 96,
					'item_id' => $spektakl_id,
					'value' => $others
				);
				$model->save();
				
				// echo '<li>',$others,'</li>';
				// echo '</ul>';
				
				// сохраняем афишу
				$afisha = new ModuleList4();
				$afisha->attributes = array(
					'date' => $playbill['date'],
					'title' => $repertuar->title,
					'old_info_1' => iconv('cp1251', 'utf-8', $playbill['id']),
					'old_info_2' => iconv('cp1251', 'utf-8', $playbill['category_id']),
					'old_info_3' => iconv('cp1251', 'utf-8', $playbill['page_id']),
					'active' => 1,
					'mpage_id' => $mpage_id_afi
				);
				$afisha->save();
				$afisha_id = $afisha->id;
				// время начала
				$model = new ModuleList4Values();
				$model->attributes = array(
					'param_id' => 86,
					'item_id' => $afisha_id,
					'value' => $playbill['timeb']
				);
				$model->save();
				// время окончания
				$model = new ModuleList4Values();
				$model->attributes = array(
					'param_id' => 87,
					'item_id' => $afisha_id,
					'value' => $playbill['timee']
				);
				$model->save();
				// связь со спектаклем
				$model = new ModuleList4List4();
				$model->attributes = array(
					'id_1' => $afisha_id,
					'id_2' => $spektakl_id
				);
				$model->save();
				*/
				
				
				/*
				// перенос репертуара
				$model = new ModuleList4();
				$model->attributes = array(
					'date' => date('Y-m-d'),
					'title' => iconv('cp1251', 'utf-8', $row['name']),
					'short' => iconv('cp1251', 'utf-8', $row['desc']),
					'text' => iconv('cp1251', 'utf-8', $row['notes']),
					'old_info_1' => iconv('cp1251', 'utf-8', $row['id']),
					'old_info_2' => iconv('cp1251', 'utf-8', $row['type']),
					'old_info_3' => iconv('cp1251', 'utf-8', $row['page_id']),
					'active' => 1,
					'mpage_id' => $mpage_id
				);
				$model->save();
				$id = $model->id;
				
				$model = new ModuleList4Values();
				$model->attributes = array(
					'param_id' => 93,
					'item_id' => $id,
					'value' => iconv('cp1251', 'utf-8', $row['scenario'])."\r\n".iconv('cp1251', 'utf-8', $row['director'])
				);
				$model->save();
				
				$value_old = iconv('cp1251', 'utf-8', $row['type']);
				if(in_array($value_old, array(1,4,6,10,13,15))) $value = 57;
				elseif(in_array($value_old, array(2,7,8,9))) $value = 58;
				else $value = 0;
				if($value>0){
					//тип постановки 57 опера /58 балет
					$model = new ModuleList4Values();
					$model->attributes = array(
						'param_id' => 80,
						'item_id' => $id,
						'value' => $value
					);
					$model->save();
				}
				if($value_old>2){
					$sql2 = "SELECT * FROM ds_perfom_types WHERE id = $value_old";
					$sqlres2 = mysql_query($sql2) or die("Query failed: ".$sql2);
					while ($row2 = mysql_fetch_array($sqlres2)){
						$model = new ModuleList4Values();
						$model->attributes = array(
							'param_id' => 101,
							'item_id' => $id,
							'value' => $row2['type_name']
						);
						$model->save();
					}
				} */
				
				/*
				// перенос подписчиков
				$model = new ModuleList4();
				$model->attributes = array(
					'date' => iconv('cp1251', 'utf-8', $row['date']),
					'title' => iconv('cp1251', 'utf-8', $row['tel']),
					'short' => iconv('cp1251', 'utf-8', $row['fio']),
					'active' => 1,
					'mpage_id' => $mpage_id_sms
				);
				$model->save();
				$id_1 = $model->id;
				
				$model = new ModuleList4();
				$model->attributes = array(
					'date' => iconv('cp1251', 'utf-8', $row['date']),
					'title' => iconv('cp1251', 'utf-8', $row['mail']),
					'short' => iconv('cp1251', 'utf-8', $row['fio']),
					'active' => 1,
					'mpage_id' => $mpage_id_mail
				);
				$model->save();
				$id_2 = $model->id;
				
				$model = new ModuleList4List4();
				$model->attributes = array(
					'id_1' => $id_1,
					'id_2' => $id_2
				);
				$model->save(); */
				
				// $sugar_name = iconv('cp1251', 'utf-8', $row['name']);
				/* echo iconv('cp1251', 'utf-8', $row['fio']);
				echo iconv('cp1251', 'utf-8', $row['tel']);
				echo iconv('cp1251', 'utf-8', $row['mail']);
				echo iconv('cp1251', 'utf-8', $row['date']); */
			}
			/*
			// перенос афиши
			$spektakl_id_where_people_with_more_than_1_id = array_unique($spektakl_id_where_people_with_more_than_1_id);
			foreach($spektakl_id_where_people_with_more_than_1_id as $id){
				echo '<a href="/admin.php?r=/list4/main/update&page_id=9&id='.$id.'#!/tab_second">Репертуар ID: '.$id.'</a><br>';
			}
			*/
			mysql_close();
		}else{
            $this->redirect(Yii::app()->request->scriptUrl);
		}
    }
}