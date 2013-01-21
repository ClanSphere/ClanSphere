<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('access');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$access_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

$cs_access = cs_sql_select(__FILE__,'access','*',"access_id = '" . $access_id . "'");
unset($cs_access['access_id']);

if(isset($cs_post['submit'])) {
  foreach($cs_access AS $key => $value) {
    if(isset($cs_post[$key])) {
      $cs_access[$key] = $cs_post[$key];
    }
  }
  
  $error = 0;
  $errormsg = '';
  $name2 = str_replace(' ','',$cs_access['access_name']);
  $namechars = strlen($name2);
  
  if($namechars<4) {
    $error++;
    $errormsg .= $cs_lang['short_name'] . cs_html_br(1);
  }

  $where = "access_name = '" . cs_sql_escape($cs_access['access_name']) . "' AND access_id != ";
  $search_name = cs_sql_count(__FILE__,'access',$where . $access_id);
  
  if(!empty($search_name)) {
    $error++;
    $errormsg .= $cs_lang['name_exists'] . cs_html_br(1);
  }
}

if(!isset($cs_post['submit'])) {
  $data['lang']['body'] = $cs_lang['body_edit'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($error) OR !isset($cs_post['submit'])) {
  $data['action']['form'] = cs_url('access','edit');
  $data['access2']['name'] = $cs_access['access_name'];
  $data['access2']['clansphere'] = cs_link('ClanSphere','modules','view','dir=clansphere');
    
  $sel = array(0 => 0,3 => 0,4 => 0,5 => 0);
  $cs_access['access_clansphere'] == 3 ? $sel[3] = 1 : $sel[3] = 0;
  $cs_access['access_clansphere'] == 4 ? $sel[4] = 1 : $sel[4] = 0;
  $cs_access['access_clansphere'] == 5 ? $sel[5] = 1 : $sel[5] = 0;
  
  if($cs_access['access_clansphere'] == '3') {
    $data['access2']['select_3'] = 'selected="selected"';
  }
  else {
    $data['access2']['select_3'] = '';
  }
  
  if($cs_access['access_clansphere'] == '4') {
    $data['access2']['select_4'] = 'selected="selected"';
  }
  else {
    $data['access2']['select_4'] = '';
  }
  
  if($cs_access['access_clansphere'] == '5') {
    $data['access2']['select_5'] = 'selected="selected"';
  }
  else {
    $data['access2']['select_5'] = '';
  }

  $modules = cs_checkdirs('mods');
  
  $run = 0;
  foreach($modules as $mod) {
    $acc_dir = 'access_' . $mod['dir'];
    if(array_key_exists($acc_dir,$cs_access) AND $mod['dir'] != 'clansphere') {
      if(!empty($mod['icon'])) {
        $data['access'][$run]['icon'] = cs_icon($mod['icon']); 
      }
    else {
      $data['access'][$run]['icon'] = '';
    } 
    $data['access'][$run]['name'] = cs_link($mod['name'],'modules','view','dir=' . $mod['dir']);
      $data['access'][$run]['select'] = cs_html_select(1,$acc_dir);
      $levels = 0;
      while($levels < 6) {
        $cs_access[$acc_dir] == $levels ? $sel = 1 : $sel = 0;
        $data['access'][$run]['select'] .= cs_html_option($levels . ' - ' . $cs_lang['lev_' . $levels],$levels,$sel);
        $levels++;
      }
      $data['access'][$run]['select'] .= cs_html_select(0);
    $run++;
    }
  }
  
  $data['access2']['id'] = $access_id;

  $data['if']['warning'] = ($access_id < 6) ? 1 : 0;
  $data['data']['warning_detail'] = empty($data['if']['warning']) ? '' : $cs_lang['warning_id_' . $access_id];

  echo cs_subtemplate(__FILE__,$data,'access','edit');
}
else {
  $access_cells = array_keys($cs_access);
  $access_save = array_values($cs_access);
  cs_sql_update(__FILE__,'access',$access_cells,$access_save,$access_id);
  
  cs_cache_delete('access_' . $access_id);
  
  cs_redirect($cs_lang['changes_done'], 'access') ;
}  