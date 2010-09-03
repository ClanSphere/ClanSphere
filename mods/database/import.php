<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

global $cs_db;
$files = cs_files();

$error = 0;
$install_sql = 0;
$actions = '';
$sql_content = '';

if(isset($files['update']['name']) AND preg_match("=^(.*?)\.sql$=si",$files['update']['name'])) {
  if($files['update']['name'] == 'install.sql') {
    $install_sql++;
  } else {
    $sql_content = file_get_contents($files['update']['tmp_name']);
    cs_ajaxfiles_clear();
  }
}
elseif(!empty($_POST['text'])) {
  $sql_content = $_POST['text'];
}

if(!empty($sql_content)) {

  $sql_update = str_replace('{time}',cs_time(),$sql_content);
  $sql_update = cs_sql_replace($sql_update);
  $sql_update = str_replace('\;','{serial}',$sql_update);
  $sql_array = explode(';',$sql_update);
  cs_abcode_load();
  
  foreach($sql_array AS $sql_query) {
    $sql_query = trim(str_replace('{serial}',';',$sql_query));
    if(!empty($sql_query)) {
      $sql_lower = strtolower($sql_query);
      $look_up = 0;
      if(strpos($sql_lower, 'explain') === 0 OR strpos($sql_lower, 'select') === 0 OR strpos($sql_lower, 'show') === 0)
        $look_up = 1;

      if($check = cs_sql_query(__FILE__, $sql_query, $look_up)) {
        $para[1] = 'green';
        $info = $check['affected_rows'];
        if(!empty($look_up) AND isset($check['more'][0])) {
          $hide = array('users_pwd', 'users_cookiehash');
          $explains = array();
          foreach($check['more'][0] AS $key => $value) {
            $explains['keys'][]['name'] = $key;
          }
          foreach($check['more'] AS $id => $more) {
            foreach($more AS $unused => $value)
            $explains['more'][$id]['values'][]['name'] = in_array($unused, $hide) ? '****' : $value;
          }
          $info .= cs_subtemplate(__FILE__, $explains, 'database', 'explain');
        }
      }
      else {
        $para[1] = 'red';
        $info = $cs_db['last_error'];
        $error++;
      }
      $para[2] = nl2br(htmlentities($sql_query, ENT_QUOTES, $cs_main['charset']));
      $actions .= cs_abcode_color($para);
      $actions .= ' # ' . $info;
      $actions .= cs_html_br(1);
    }
  }
}
else {
  $error++;
}

if(empty($files['update']['tmp_name'])) {
  $data['lang']['body'] = $cs_lang['body_import'];
}
elseif(empty($error)) {
  $data['lang']['body'] = $cs_lang['update_done'];
}
else {
  if(!empty($install_sql)) {
    $data['lang']['body'] = cs_html_big(1) . $cs_lang['update_error'] . cs_html_big(0) . cs_html_br(1) . $cs_lang['error_inst_sql'];
  } else {
    $data['lang']['body'] = $cs_lang['update_error'];
  }
}

$data['if']['actions'] = empty($actions) ? false : true;

if(!empty($actions)) {

  cs_cache_clear();
  $cs_lang2 = cs_translate('clansphere');
    $data['lang']['cache_cleared'] = $cs_lang2['cache_cleared'];

  $data['message']['actions'] = $actions;
}

if(empty($sql_content) OR !empty($error)) {

  $data['if']['sql_content'] = false;
  $data['action']['form'] = cs_url('database','import');
  $data['import']['sql_text'] = $sql_content;
}
else {
 $data['if']['sql_content'] = true;
  $data['link']['continue'] = cs_url('database','roots');
  $data['import']['sql_text'] = '';
}

echo cs_subtemplate(__FILE__,$data,'database','import');