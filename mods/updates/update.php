<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $cs_db;  
global $com_lang;

$cs_lang = cs_translate('updates');
$update_server = "http://update.clansphere.net/"; 

$value = explode('.', cs_sql_escape($_GET['file']));
$errormsg = '';
$actions = '';

$data = array();
$data['if']['error'] = FALSE;
$data['if']['no_error'] = FALSE;

//Get Packet
if(!@copy($update_server.'packets/'.$value[0].'.zip', $value[0].'.zip')) { 
  $error_details = error_get_last();
  $errormsg .= $cs_lang['error_download'].': '.$error_details['message'].'/';
}

//Unpack Packet
if(empty($errormsg)) {
  $zip = new ZipArchive;
  if($zip->open($value[0].'.zip') === TRUE) {
    $zip->extractTo('.');
    $zip->close();
  } else {
    $errormsg .= $cs_lang['error_unzip'].': '.$error_details['message'].'/';
  }
}

//Sql
if(empty($errormsg) AND file_exists('update.sql')) { 
  $sql_content = file_get_contents('update.sql');
  $sql_update = str_replace('{time}',cs_time(),$sql_content);
  if($cs_db['type'] == 'mysql') {
    $sql_update = str_replace('{optimize}','OPTIMIZE TABLE',$sql_update);
    $sql_update = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_update);
    $sql_update = str_replace('{engine}',' TYPE=MyISAM',$sql_update);
    $sql_update = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_update);
  } elseif($cs_db['type'] == 'mysqli' OR $cs_db['type'] == 'pdo_mysql') {
    $sql_update = str_replace('{optimize}','OPTIMIZE TABLE',$sql_update);
    $sql_update = str_replace('{serial}','int(8) unsigned NOT NULL auto_increment',$sql_update);
    $sql_update = str_replace('{engine}',' ENGINE=MyISAM',$sql_update);
    $sql_update = preg_replace("=create index (\S+) on (\S+) (\S+)=si",'ALTER TABLE $2 ADD KEY $1 $3',$sql_update);
  } elseif($cs_db['type'] == 'pgsql' OR $cs_db['type'] == 'pdo_pgsql') {
    $sql_update = str_replace('{optimize}','VACUUM',$sql_update);
    $sql_update = str_replace('{serial}','serial NOT NULL',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'integer',$sql_update);
  } elseif($cs_db['type'] == 'sqlite' OR $cs_db['type'] == 'pdo_sqlite') {
    $sql_update = str_replace('{optimize}','VACUUM',$sql_update);
    $sql_update = str_replace('{serial}','integer',$sql_update);
    $sql_update = str_replace('{engine}','',$sql_update);
    $sql_update = preg_replace("=int\((.*?)\)=si",'integer',$sql_update);
  }
  $sql_update = str_replace('\;','{serial}',$sql_update);
  $sql_array = explode(';',$sql_update);
  foreach($sql_array AS $sql_query) {
    $sql_query = trim(str_replace('{serial}',';',$sql_query));
    if(!empty($sql_query)) {
      if($check = cs_sql_query(__FILE__, $sql_query)) {
        $para[1] = 'green';
        $info = $check['affected_rows'];
      } else {
        $para[1] = 'red';
        $info = $cs_db['last_error'];
        $error++;
        $errormsg .= $cs_lang['error_sql'].': '.$error_details['message'].'/';
      }
    }
    $para[2] = nl2br(htmlentities($sql_query, ENT_QUOTES, $com_lang['charset']));
    $actions .= cs_abcode_color($para);
    $actions .= ' # ' . $info;
    $actions .= cs_html_br(1);
  }
}

//Delete Packet Files
if(empty($errormsg)) {
  if(file_exists('update.sql')) {
    if(!@unlink('update.sql')) {
      $errormsg .= $cs_lang['error_delete'].': '.$error_details['message'].'/';
    }
  }  
  if(file_exists($value[0].'.zip')) {
    if(!@unlink($value[0].'.zip')) {
      $errormsg .= $cs_lang['error_delete'].': '.$error_details['message'].'/';
    }
  }
}

//Update Log writing 
$update_num = explode('w', $value[0]);
$insert_keys = array('updates_packet','updates_name','updates_date','updates_error');
$insert_values = array($update_num[0], $value[0], cs_time(), $errormsg);
cs_sql_insert(__FILE__, 'updates', $insert_keys, $insert_values);


if(!empty($errormsg)) {

  $data['if']['error'] = TRUE;

  $errormsg = explode('/', $errormsg); 
  $errormsg_count = (count($errormsg)-1);
  unset($errormsg[$errormsg_count]); 
  foreach($errormsg AS $value) {
    $data['updates']['errors'] = cs_secure($value,1).cs_html_br(1);
  }   
} 

if(empty($errormsg)) {
  $data['if']['no_error'] = TRUE;
}

echo cs_subtemplate(__FILE__,$data,'updates','update');


?>