<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$


function multiarray_search ($array, $innerkey, $value) {
  foreach ($array AS $outerkey => $innerarray) {
  if ($innerarray[$innerkey] == $value)
    return $outerkey;
  }
  return FALSE;
}

function cs_foldersort ($array, $id = 0) {
  
  if (empty($array)) return 0;
  
  $count = count($array);
  $result = array();
  $subid = 0;
  $order = 1;
  
  for ($i = 0; $i < $count; $i++) {
    if (empty($array[$i]['sub_id'])) {
      $array[$i]['layer'] = 0;
      $result[] = $array[$i];
    } else {
      if ($array[$i]['sub_id'] != $subid) {
        $order = 1;
        $subid = $array[$i]['sub_id'];
      }
      $pos = multiarray_search($result, 'folders_id', $array[$i]['sub_id']);
      $array[$i]['layer'] = $result[$pos]['layer'] + 1;
      $result = array_merge(array_slice($result, 0, $pos + $order), array($array[$i]), array_slice($result, $pos + $order));
      $order++;
    }
  }
  
  if (!empty($id)) {
    $count = count($result);
    for ($i = 0; $i < $count; $i++) {
      if ($id == $result[$i]['folders_id']) {
        $layer = $result[$i]['layer'];
        $name = $result[$i]['folders_name'];
        $start = $i;
      } elseif (isset($layer) && $result[$i]['layer'] <= $layer) {
        $end = $i;
        break;
      }
    }
    $end = !empty($end) ? $end - $start : $count;
    $result = array_slice($result,$start,$end);
  }
  
  return $result;
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

function makeTAB($run) {
  $var = '';
  while(0 < $run) {
    $var .= '&nbsp;&nbsp;&nbsp;';
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

function make_folders_select($name,$select,$users_id = 0,$mod = 0,$create = 1, $folders_id = 0) {

  $sql_select = 'folders_id, sub_id, folders_name, folders_order, folders_position, folders_url, folders_text, folders_access';
  $sql_where = "folders_mod = '" . $mod . "' AND users_id = '" . (int) $users_id . "'";
  $array = cs_sql_select(__FILE__, 'folders', $sql_select, $sql_where, 'folders_id ASC', 0, 0);
  $array = make_folders_array($array);
  
  $data['select']['name'] = $name;
  $data['folders']['options'] = make_folders_options($array,0,$select, $folders_id);
  $data['if']['create'] = !empty($create) ? TRUE : FALSE;

  return cs_subtemplate(__FILE__,$data,'gallery','folders_select');
}

function make_folders_options($array, $hierarchy = 0, $select = 0, $folders_id = 0) {

  $string = '';
  $space = '';
  for ($run = 0; $run < $hierarchy; $run++) {
    $space .= '&nbsp;';
  }
  if (!empty($array)) {
    foreach ($array AS $folder) {
      if (!empty($folder[0]['name'])) {
        $string .= make_folders_options($folder,$hierarchy+1,$select,$folders_id);
      } elseif ($folder['folders_id'] != $folders_id) {
        $string .= cs_html_option($space . cs_secure($folder['name']),$folder['folders_id'],$folder['folders_id'] == $select);
      }
    }
  }
  return $string;
}

function get_subfolders ($id) {

  settype($id, 'integer');
  
  $folders = cs_sql_select(__FILE__,'folders','folders_id','sub_id = \''.$id.'\'',0,0,0);
  $count_folders = count($folders);
  
  for ($run = 0; $run < $count_folders; $run++) {
    $new_folders = get_subfolders($folders[$run]['folders_id']);
    if (!empty($new_folders))
      $folders = array_merge($folders, $new_folders);
  }
  return $folders;
}

function make_subfolders_select($array,$select) {
  $var = '';
  $sel = 0;
  $loop = count($array);
  for($run=0; $run<$loop; $run++) {
    if(!empty($array[$run][0])) {
      make_subfolders_select($array[$run],$select);
    } else {
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
function make_folders_head($array, $last_id, $folders_name) {
  $loop = count($array);
  $cache = '';
  for($run=0; $run < $loop; $run++) {
    if($array[$run]['folders_id'] == $last_id) {
    $last_id = $array[$run]['sub_id'];
    if($array[$run]['folders_name'] != $folders_name) {
      $more = 'folders_id='. $array[$run]['folders_id'];
      $cache = ' - ' . cs_link($array[$run]['folders_name'],'gallery','list',$more) . $cache;
    }
      $run = -1;
      }
  }
  return $cache;
}
function make_folders_create($mod, $folders_name, $users_id = 0) {
  
  $get = "folders_mod = '" . $mod . "' AND folders_name = '" . cs_sql_escape($folders_name) . "' AND users_id = '" . (int) $users_id . "'";
  $count = cs_sql_count(__FILE__,'folders',$get);
  if(!empty($count)) {
    return false;
  }
  else {
    $columns = array('folders_mod','folders_name','users_id');
    $values = array($mod, $folders_name, $users_id);
    cs_sql_insert(__FILE__,'folders',$columns,$values);
    return cs_sql_insertid(__FILE__);
  }
}