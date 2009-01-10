<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_new_date($mode,$data,$show_time = 0) {
	global $com_lang;
	if($mode=='date' AND preg_match('=-=',$data)) {
		$explode = explode('-', $data);
		$data = mktime(0,0,1,$explode[1],$explode[2],$explode[0]);
	} else {
		global $account;
		$data = $data + $account['users_timezone'];
		$data = empty($account['users_dstime']) ?	$data : $data + 3600;
	}
	$var = date($com_lang['dateset'],$data);
	if(!empty($show_time)) {
		$var .= cs_html_br(1);
		$var .= ' ' . $com_lang['dtcon'] . ' ';
		$var .= date($com_lang['timeset'],$data);
		$var .= ' ' . $com_lang['timename'];
	}
	return $var;
}
/*function cs_categories_create($mod, $categories_name, $users_id) {
	$return = FALSE;
	$get = "categories_mod='" . $mod . '_' . $users_id . "' AND categories_name='" . cs_sql_escape($categories_name) . "'";
	$get_data = cs_sql_select(__FILE__,'categories','categories_id',$get,'categories_name');
	if(empty($get_data['categories_id'])) {
		$columns = array('categories_mod','categories_name');
		$values = array($mod . '_' . $users_id, $categories_name);
  		cs_sql_insert(__FILE__,'categories',$columns,$values);
		$find = "categories_mod='" . $mod . '_' . $users_id . "' AND categories_name = '" . cs_sql_escape($categories_name) . "'";
		$find_data = cs_sql_select(__FILE__,'categories','categories_id',$find,'categories_name');
		$return = $find_data['categories_id'];
	} else {
		$return = $get_data['categories_id'];
	}
	return $return;
}
function cs_categories_dropdown($mod, $categories_id, $users_id, $max_cats) {
	$where = "categories_mod='" . $mod . '_' . $users_id . "'";
	$list_data = cs_sql_select(__FILE__,'categories','*',$where,'categories_name',0,0);
	$return = cs_dropdown('categories_id','categories_name',$list_data,$categories_id);
	if(count($list_data) < $max_cats) {
		$return .= ' - ' . cs_html_input('categories_name','','text',80,20);
	}
	return $return;
}*/
function cs_array_sort($array,$sort,$key) {
	if(!empty($array)) {
		if($sort == SORT_DESC OR $sort == SORT_ASC) {
			foreach($array as $k) $s[] = $k[$key];
			array_multisort($s, $sort, $array);
			return $array;
		} elseif($sort == 3) {
			foreach($array as $k) $s[] = $k[$key];
			array_multisort($s, SORT_DESC, $array);
			return $array;
		} elseif($sort == 4) {
			foreach($array as $k) $s[] = $k[$key];
			array_multisort($s, SORT_ASC, $array);
			return $array;
		}
	} else {
		return $array;
	}
}
function cs_gallery_move($array,$list_sort) {
	$array = cs_array_sort($array,SORT_ASC,'folders_id');
	$loop = count($array);
	for($run=0; $run < $loop; $run++) {
		$before = $run - 1;
		if($run == '0') {
			$move = 0;
			$array[$run]['move'] = $move;
		} elseif($array[$before]['folders_id'] == $array[$run]['folders_id']) {
			$move++;
			$array[$run]['move'] = $move;
		} else {
			$move = 0;
			$array[$run]['move'] = $move;
		}
	}
	if($list_sort == 0) {
		for($run=0; $run < $loop; $run++) {
			$before = $run - 1;
			if($run == '0') {
				$move = 0;
				$temp_array[$move][$run]['usersgallery_id'] = $array[$run]['usersgallery_id'];
				$temp_array[$move][$run]['move'] = $array[$run]['move'];
			} elseif($array[$before]['folders_id'] == $array[$run]['folders_id']) {
				$temp_array[$move][$run]['usersgallery_id'] = $array[$run]['usersgallery_id'];
				$temp_array[$move][$run]['move'] = $array[$run]['move'];
			} else {
				$move++;
				$temp_array[$move][$run]['usersgallery_id'] = $array[$run]['usersgallery_id'];
				$temp_array[$move][$run]['move'] = $array[$run]['move'];
			}
		}
		if(isset($temp_array)) {
			$loop = count($temp_array);
			$run_to = 0;
			for($run=0; $run < $loop; $run++) {
				$loop_2 = count($temp_array[$run]);
				$loop_2--;
				for($loop_2; $loop_2 >= 0; $loop_2--) {
					$temp_array2[$run_to]['move'] = $loop_2;
					$temp_array2[$run_to]['usersgallery_id'] = $temp_array[$run][$run_to]['usersgallery_id'];
					$run_to++;
				}
			}
			$array = cs_array_sort($array,SORT_DESC,'usersgallery_id');
			$temp_array2 = cs_array_sort($temp_array2,SORT_DESC,'usersgallery_id');
			$loop = count($array);
			for($run=0; $run < $loop; $run++) {
				$array[$run]['move'] = $temp_array2[$run]['move'];
			}
		}
	}
	return $array;
}
function cs_box($array,$run) {
	global $account;
	global $cs_lang;
	if($array[$run]['usersgallery_status'] == 1) {
		$data['status']['icon'] = "symbols/clansphere/green.gif";
	} else {
		$data['status']['icon'] = "symbols/clansphere/red.gif";
	}
	$pic = cs_secure($array[$run]['usersgallery_name']);
	$img_size = getimagesize('uploads/usersgallery/thumbs/Thumb_' . $pic);
	$img_w_h = $img_size[0] / $img_size[1];
	$img_height = 40;
	$img_width = $img_height * $img_w_h;
	$pic = cs_secure($array[$run]['usersgallery_id']);
	$pic = cs_html_img('mods/gallery/image.php?usersthumb=' . $pic,$img_height,$img_width);
	$link = 'id=' . $account['users_id'] . '&amp;cat_id=' . $array[$run]['folders_id'] . '&amp;move=' . $array[$run]['move'];
	$data['link']['img'] = cs_link($pic,'usersgallery','com_view',$link);
	$data['link']['titel'] = cs_link(cs_secure($array[$run]['usersgallery_titel']),'usersgallery','com_view',$link);
	$link = 'id=' . $account['users_id'] . '&amp;cat_id=' . $array[$run]['folders_id'];
	$data['link']['folders_name'] = cs_link(cs_secure($array[$run]['folders_name']),'usersgallery','users',$link);
	$data['data']['date'] = cs_new_date('unix',$array[$run]['usersgallery_time'],1);
	$img_edit = cs_icon('edit',22,$cs_lang['edit']);
	$data['link']['edit'] = cs_link($img_edit,'usersgallery','users_edit','id=' . $array[$run]['usersgallery_id'],0,$cs_lang['edit']);
	$img_del = cs_icon('editdelete',22,$cs_lang['remove']);
	$data['link']['remove'] = cs_link($img_del,'usersgallery','users_remove','id=' . $array[$run]['usersgallery_id'],0,$cs_lang['remove']);
	return $data;
}
function makeDIV($run) {
	$var = '';
	while(0 < $run) {
		if($run == 1) {
			$var .= cs_html_div(1,'width:16px; float:left;');
			$var .= cs_icon('add_sub_task',16,'task');
			$var .= cs_html_div(0);
			$run--;
		} else {
			$var .= cs_html_div(1,'width:16px; float:left;');
			$var .= cs_icon('add_task',16,'task');
			$var .= cs_html_div(0);
			$run--;
		}
	}
	return $var;
}
function makeTAB($run) {
	$var = '';
	while(0 < $run) {
		$var .= '&nbsp;&nbsp;';
		$run--;
	}
	return $var;
}
function make_folders_array($array) {
	$var = '';
	if(!empty($array)) {
		$array = cs_array_sort($array,SORT_ASC,'folders_position');
		$loop = count($array);
		for($run=0; $run<$loop; $run++) {
			$folders_id = $array[$run]['folders_id'];
			if ($array[$run]['sub_id'] == 0) {
				$last_id = $array[$run]['folders_id'];
				$var[] = array('depht' => 0, 'folders_id' => $array[$run]['folders_id'], 'position' => $array[$run]['folders_position'], 'name' => $array[$run]['folders_name'], 'sub_id' => $array[$run]['sub_id']);
				$cache = make_subfolders_array($array,$last_id);
				if (!empty($cache)) {
					$var[] = $cache;
				}
			}
		}
		return $var;
	}
}
function make_subfolders_array($array,$last_id = 0,$count = 1) {
	$var = '';
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if($array[$run]['sub_id'] == $last_id) {
			$next_id = $array[$run]['folders_id'];
			$var[] = array('depht' => $count, 'folders_id' => $array[$run]['folders_id'], 'position' => $array[$run]['folders_position'], 'name' => $array[$run]['folders_name'], 'sub_id' => $array[$run]['sub_id']);
			$count_1 = $count+1;
			$i = -($loop-$run-1);
			array_splice($array, $run, $i);
			$loop--;
			$run--;
			$cache = make_subfolders_array($array,$next_id,$count_1);
			if (!empty($cache)) {
				$var[] = $cache;
			}
		}
	}
	if(!empty($var)) {
		return $var;
	}
}
function make_folders_list($array) {
	global $cs_lang;
	$count = 0;
	if(!empty($array)) {
		$loop = count($array);
		for($run=0; $run<$loop; $run++) {
			if(isset($array[$run]['name'])) {
				$data['data']['name'] = $array[$run]['name'];
				$img_edit = cs_icon('edit',16,$cs_lang['edit']);
				$data['link']['edit'] = cs_link($img_edit,'usersgallery','folders_edit','id=' . $array[$run]['folders_id'],0,$cs_lang['edit']);
				$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
				$data['link']['remove'] = cs_link($img_del,'usersgallery','folders_remove','id=' . $array[$run]['folders_id'],0,$cs_lang['remove']);
				$var[$run]['folders_box'] = cs_subtemplate(__FILE__,$data,'usersgallery','folders_box');
			}
			if(!empty($array[$run+1][0]['name'])) {
				$count++;
				$var = $var + make_subfolders_list($array[$run+1],$count);
			}
		}
		return $var;
	}
}
function make_subfolders_list($array,$count) {
	global $cs_lang;
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if(!empty($array[$run][0])) {
			$var = $var + make_subfolders_list($array[$run],$count);
		} else {
			$div = makeDIV($array[$run]['depht']) . cs_html_div(1,'float:left;');
			$data['data']['name'] = $div . $array[$run]['name'] . cs_html_div(0);
			$img_edit = cs_icon('edit',16,$cs_lang['edit']);
			$data['link']['edit'] = cs_link($img_edit,'usersgallery','folders_edit','id=' . $array[$run]['folders_id'],0,$cs_lang['edit']);
			$img_del = cs_icon('editdelete',16,$cs_lang['remove']);
			$data['link']['remove'] = cs_link($img_del,'usersgallery','folders_remove','id=' . $array[$run]['folders_id'],0,$cs_lang['remove']);
			$var[$count]['folders_box'] = cs_subtemplate(__FILE__,$data,'usersgallery','folders_box');
			$count++;
		}
	}
	return $var;
}
function make_folders_select($name,$select,$id,$mod, $folders_id = 0) {
	$from = 'folders';
	$sql_select = 'folders_id, sub_id, folders_name, folders_order, folders_position, ';
	$sql_select .= 'folders_url, folders_text, folders_access';
	$where = "users_id='" . $id . "' AND folders_mod='" . $mod . "'";
	$order = 'folders_id ASC';
	$array = cs_sql_select(__FILE__,$from,$sql_select,$where,$order,0,0);
	$array = make_folders_array($array);
  
	$var = cs_html_select(1,$name);
	$sel = 0;
	$var .= cs_html_option('&nbsp;','0',$sel);
	if(!empty($array))
	{
		$loop = count($array);
		for($run=0; $run<$loop; $run++) {
			if(isset($array[$run]['name']) && $array[$run]['folders_id'] != $folders_id) {
				$array[$run]['folders_id'] == $select ? $sel = 1 : $sel = 0;
				$var .= cs_html_option($array[$run]['name'],$array[$run]['folders_id'],$sel);
			}
			if(!empty($array[$run+1][0])) {
				$var .= make_subfolders_select($array[$run+1],$select, $folders_id);
			}
		}
	}
	$var .= cs_html_select(0);
	return $var;
}
function make_subfolders_select($array,$select, $folders_id = 0) {
	$var = '';
	$sel = 0;
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if(!empty($array[$run][0])) {
			$var .= make_subfolders_select($array[$run],$select, $folders_id);
		} elseif ($array[$run]['folders_id'] != $folders_id) {
			$array[$run]['folders_id'] == $select ? $sel = 1 : $sel = 0;
			$tab = makeTAB($array[$run]['depht']);
			$var .= cs_html_option($tab . $array[$run]['name'],$array[$run]['folders_id'],$sel);
		}
	}
	return $var;
}
function make_folders_remove($array,$id) {
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if(empty($array[$run][0])) {
			if($array[$run]['folders_id'] == $id) {
				cs_sql_delete(__FILE__,'folders',$array[$run]['folders_id']);
				if(!empty($array[$run+1][0])) {
					make_subfolders_remove($array[$run+1],$array[$run]['folders_id']);
				}
			}
		} else {
			make_folders_remove($array[$run],$id);
		}
	}
}
function make_subfolders_remove($array,$id) {
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if(empty($array[$run][0])) {
			if($array[$run]['sub_id'] == $id) {
				cs_sql_delete(__FILE__,'folders',$array[$run]['folders_id']);
				if(!empty($array[$run+1][0])) {
					make_subfolders_remove($array[$run+1],$array[$run]['folders_id']);
				}
			}
		}
	}
}
function make_folders_head($array,$id,$users_id,$count = 0,$var = array()) {
	$loop = count($array);
	for($run=0; $run<$loop; $run++) {
		if($array[$run]['folders_id'] == $id) {
			$var[$count]['id'] = $array[$run]['folders_id'];
			$var[$count]['name'] = $array[$run]['folders_name'];
			$count++;
			$count_new = $count;
			make_folders_head($array,$array[$run]['sub_id'],$users_id,$count_new,$var);
		}
	}
	if(!isset($count_new)) {
		$cache = '';
		$loop = count($var);
		while ($loop > 0) {
			$loop--;
			$id = 1;
			$cache .= ' - ' . cs_link($var[$loop]['name'],'usersgallery','users','id='. $users_id .'&amp;cat_id='. $var[$loop]['id']);
		}
		echo $cache;
	}
}
?>