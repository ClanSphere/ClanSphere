<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

global $cs_db;
$files = cs_files();

$error = 0;
$install_sql = 0;
$actions = '';
$sql_content = '';

$content = cs_paths('uploads/cache');
unset($content['index.html']);
unset($content['.htaccess']);

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

  if($cs_db['type'] == 'mysql' OR $cs_db['type'] == 'mysqli' OR $cs_db['type'] == 'pdo_mysql') {

    #engine since 4.0.18, but collation works since 4.1.8
    $version = cs_sql_version(__FILE__);
    $myv = explode('.', $version['server']);
    settype($myv[2], 'integer');
    if($myv[0] > 4 OR $myv[0] == 4 AND $myv[1] > 1 OR $myv[0] == 4 AND $myv[1] == 1 AND $myv[2] > 7)
      $engine = ' ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';
    else
      $engine = ' TYPE=MyISAM CHARACTER SET utf8';
  
    $sql_update = str_replace('{optimize}','OPTIMIZE TABLE',$sql_update);
    $sql_update = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_update);
    $sql_update = str_replace('{engine}',$engine,$sql_update);
    $sql_update = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_update);
  }
  elseif($cs_db['type'] == 'pgsql' OR $cs_db['type'] == 'pdo_pgsql') {
    $sql_update = str_replace('{optimize}','VACUUM',$sql_update);
    $sql_update = str_replace('{serial}','serial NOT NULL',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'integer',$sql_update);
  }
  elseif($cs_db['type'] == 'sqlite' OR $cs_db['type'] == 'pdo_sqlite') {
    $sql_update = str_replace('{optimize}','VACUUM',$sql_update);
    $sql_update = str_replace('{serial}','integer',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'integer',$sql_update);
  }

  $sql_update = str_replace('\;','{serial}',$sql_update);
  $sql_array = explode(';',$sql_update);
  cs_abcode_load();
  
  foreach($sql_array AS $sql_query) {
    $sql_query = trim(str_replace('{serial}',';',$sql_query));
    if(!empty($sql_query)) {
      $explain = strpos(strtolower($sql_query), 'explain') === 0 ? 1 : 0;
      if($check = cs_sql_query(__FILE__, $sql_query, $explain)) {
        $para[1] = 'green';
        $info = $check['affected_rows'];
        if(!empty($explain) AND isset($check['more'][0])) {
          $explains = array();
          foreach($check['more'][0] AS $key => $value) {
            $explains['keys'][]['name'] = $key;
          }
          foreach($check['more'] AS $id => $more) {
            foreach($more AS $unused => $value)
            $explains['more'][$id]['values'][]['name'] = $value;
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

  foreach($content AS $file => $name) {
    unlink('uploads/cache/' . $file);
  }
  $cs_lang2 = cs_translate('clansphere');
    $content = array();
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