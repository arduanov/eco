<?php
/*
 исправлена модель PAGES :: внесён в массив $tree поле parent_id
*/

class Menu extends CWidget {
	public function getmenu($tpl,$url,$tree,$parent,$depth = 0,$start = 0,$limit = 0,$level = 0,$code = '',$menu = '',$depth_old = 0,$added_docs = array()){
		$tpl_ul = explode('|',$tpl);
		if(count($tpl_ul)<2) $tpl_ul[1] = '';
		if($depth_old==0) $depth_old = $depth;
		$url = explode('/',$url);
		$is_set_ul = false;
		$i = 0;
		$code_old = $code;
		foreach($tree as $k=>$t){
            if ($k==77)
                continue;
			$code = $code_old;
			if($parent==0 && $depth_old==1 && $limit>0 && $i<$start){
				$i++;
				continue;
			}
			if($parent==0 && $depth_old==1 && $limit>0 && $i-$start>=$limit) break;
			if(!$is_set_ul && $parent==0){
				include 'views/'.$tpl_ul[0].'/'.'wrapper.php';
				$is_set_ul = true;
			}
			$code .= $t['code'].'/';
			$code0 = $code;
			if($code0 == 'index/') $code0 = '';
				$url0 = array();
				for($u_i = 0; $u_i<$level+1; $u_i++){
					$url0[] = $url[$u_i];
				}
			//--------- ИСПРАВЛЕНА ЛОГИКА (поменял вложенности условий :: обобщил)
			if($parent==0){
				//---------- 0. костыль
				$wsub = '';
				if(count($t['child'])>0) $wsub = 'wSub';
				if($k==2) $wsub = 'wSub3';
				// if($tpl=='popupSubmenu' && count($t['child'])>0) $wsub = 'wSub2';
				//---------- конец 0.
				$last_class = '';
				if($limit>0 && $i==($limit+count($added_docs)) || $i==(count($tree)+count($added_docs)-1)) $last_class = 'last';
				$first_class = '';
				if($i==0) $first_class = 'first first-item';
				$span = '';
				//-------- 1. ИСПРАВЛЕН БАГ «НЕУНИКАЛЬНЫЕ КОДЫ СТРАНИЦ НА ОДНОМ УРОВНЕ»
				if($level<count($url) && $code==implode('/',$url0).'/'){
				//-------- КОНЕЦ 1.
					if($level+1<count($url)){
						switch($tpl_ul[1]){
							case 'span':
								$menu.='<li class="active activeLink '.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" class="onPage" href="/'.$code.'"><span>'.$t['name'].'</span></a>';
								break;
							default:
								$active_class = '';
								/*if(1==$depth_old) $active_class = 'active';*/
								if($level+1==$depth || ($depth==0 && count($t['child'])==0)) $active_class = 'active';
								$menu.='<li class="'.$active_class.' activeLink '.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" href="/'.$code.'">'.$span.$t['name'].'</a>';
								break;
						}
					}else{
						switch($tpl_ul[1]){
							case 'span':
								$menu.='<li class="active '.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" class="onPage" href="/'.$code.'"><span>'.$t['name'].'</span></a>';
								break;
							default:
								$menu.='<li class="active '.$last_class.' '.$first_class.' p'.($i+1).'"><span data-rel="'.$k.'">'.$span.$t['name'].'<i></i></span>';
								break;
						}
					}
				}else{
					if($code0 == '' && $url[$level]==''){
						switch($tpl_ul[1]){
							case 'span':
								$menu.='<li class="active '.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" class="onPage" href="/'.$code.'"><span>'.$t['name'].'</span></a>';
								break;
							default:
								$menu.='<li class="active '.$last_class.' '.$first_class.' p'.($i+1).'"><span data-rel="'.$k.'">'.$span.$t['name'].'<i></i></span>';
								break;
						}
					}else{
						switch($tpl_ul[1]){
							case 'span':
								$menu.='<li class="'.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" class="onPage" href="/'.$code0.'" data-rel="'.$k.'"><span>'.$t['name'].'</span></a>';
								break;
							default:
								$menu.='<li class="'.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" href="/'.$code0.'" class="'.$wsub.'" data-rel="'.$k.'">'.$span.$t['name'].'</a>';
								break;
						}
					}
				}
			}
			if(count($t['child'])>0){
				if($parent>0 /* && $parent==$k */ && $depth>0 && $parent==$k) $depth++; /*$depth += $level+1;*/
				if($depth==0 || $depth-1>$level){
					$level++;
					if($parent==0 || $parent==$k){
						if($level<2 || $level<count($url) && $code==implode('/',$url0).'/' || in_array($level, array(2,3)) && $level==count($url) && $code==implode('/',$url0).'/')
								$menu = $this->getmenu($tpl,implode('/',$url),$t['child'],0,$depth,$start,$limit,$level,$code,$menu,$depth_old,$added_docs);
					}else{
						$menu = $this->getmenu($tpl,implode('/',$url),$t['child'],$parent,$depth,$start,$limit,$level,$code,$menu,$depth_old,$added_docs);
					}
					$level--;
				}
			}
			$i++;
		}
		if($is_set_ul){
			$j = 0;
			foreach($added_docs as $k=>$v){
				$last_class = '';
				if($j==count($added_docs)-1) $last_class = 'last';
				$first_class = '';
				if($i==0) $first_class = 'first-item';
				if('/'.implode('/',$url).'/'!=$k){
					switch($tpl_ul[1]){
						case 'span':
							$menu.='<li class="'.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" class="onPage" href="'.$k.'"><span>'.$v.'</span></a></li>';
							break;
						default:
							$menu.='<li class="'.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" href="'.$k.'">'.$v.'</a></li>';
							break;
					}
				}else{
					switch($tpl_ul[1]){
						case 'span':
							$menu.='<li class="active '.$last_class.' '.$first_class.' p'.($i+1).'"><a data-rel="'.$k.'" class="onPage" href="/'.$code.'"><span>'.$v.'</span></a></li>';
							break;
						default:
							$menu.='<li class="active '.$last_class.' '.$first_class.' p'.($i+1).'"><span data-rel="'.$k.'">'.$v.'<i></i></span></li>';
							break;
					}
				}
				$j++;
				$i++;
			}
			$menu.='</ul>';
		}
		return $menu;
	}
}
 
