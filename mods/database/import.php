
<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('database');

global $cs_db;
$error = 0;
$install_sql = 0;
$actions = '';
$sql_content = '';

$content = cs_paths('uploads/cache');
unset($content['index.html']);

if(isset($_FILES['update']['name']) AND preg_match("=^(.*?)\.sql$=si",$_FILES['update']['name'])) {
  if($_FILES['update']['name'] == 'install.sql') { $install_sql++; } else {
  $sql_content = file_get_contents($_FILES['update']['tmp_name']);
  }
}
elseif(!empty($_POST['text'])) {
  $sql_content = $_POST['text'];
}

if(!empty($sql_content)) {

  $sql_update = str_replace('{time}',cs_time(),$sql_content);
  if($cs_db['type'] == 'mysql') {
    $sql_update = str_replace('{optimize}','OPTIMIZE TABLE',$sql_update);
    $sql_update = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_update);
    $sql_update = str_replace('{engine}',' TYPE=MyISAM',$sql_update);
    $sql_update = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_update);
  }
  elseif($cs_db['type'] == 'mysqli' OR $cs_db['type'] == 'pdo_mysql') {
    $sql_update = str_replace('{optimize}','OPTIMIZE TABLE',$sql_update);
    $sql_update = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_update);
    $sql_update = str_replace('{engine}',' ENGINE=MyISAM',$sql_update);
    $sql_update = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_update);
  }
  elseif($cs_db['type'] == 'pgsql' OR $cs_db['type'] == 'pdo_pgsql') {
    $sql_update = str_replace('{optimize}','VACUUM',$sql_update);
    $sql_update = str_replace('{serial}','serial NOT NULL',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'integer',$sql_update);
  }
  elseif($cs_db['type'] == 'mssql') {
    $sql_update = str_replace('{serial}','int IDENTITY(1,1)',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'int',$sql_update);
  }
  elseif($cs_db['type'] == 'sqlite' OR $cs_db['type'] == 'pdo_sqlite') {
    $sql_update = str_replace('{optimize}','VACUUM',$sql_update);
    $sql_update = str_replace('{serial}','integer',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'integer',$sql_update);
  }

  global $com_lang;
  $sql_update = str_replace('\;','{serial}',$sql_update);
  $sql_array = explode(';',$sql_update);
  foreach($sql_array AS $sql_query) {
    $sql_query = trim(str_replace('{serial}',';',$sql_query));
    if(!empty($sql_query)) {
      if($check = cs_sql_query(__FILE__, $sql_query)) {
        $para[1] = 'green';
        $info = $check['affected_rows'];
      }
      else {
        $para[1] = 'red';
        $info = $cs_db['last_error'];
        $error++;
      }
      $para[2] = nl2br(htmlentities($sql_query, ENT_QUOTES, $com_lang['charset']));
      $actions .= cs_abcode_color($para);
      $actions .= ' # ' . $info;
      $actions .= cs_html_br(1);
    }
  }
}
else {
  $error++;
}


if(empty($_FILES['update']['tmp_name'])) {
  $data['lang']['body'] = $cs_lang['body_import'];
}
elseif(empty($error)) {
  $data['lang']['body'] = $cs_lang['update_done'];
}
else {
  if(!empty($install_sql)) {
    $data['lang']['body'] = '<b>' . $cs_lang['update_error'] . '</b>' . cs_html_br(1) . $cs_lang['error_inst_sql'];
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
?>