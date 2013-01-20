<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

require_once 'mods/clansphere/filetype.php';

$data = array();

$files_size = '';

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = "categories_id = '" . $categories_id . "'";

$cs_sort[1] = 'files_name DESC';
$cs_sort[2] = 'files_name ASC';
$cs_sort[3] = 'files_time DESC';
$cs_sort[4] = 'files_time ASC';
$cs_sort[5] = 'files_size DESC';
$cs_sort[6] = 'files_size ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];

$where_acc = 'categories_access <= ' . (int) $account['access_files'] . ' AND categories_id = ' . (int) $categories_id;
$categories = cs_sql_select(__FILE__,'categories','categories_name',$where_acc);
$data['category']['name'] = $categories['categories_name'];
$data['category']['count'] = cs_sql_count(__FILE__,'files',$where);

$data['category']['paginator'] = cs_pages('files','listcat',$data['category']['count'],$start,$categories_id,$sort);

$sub_where = "categories_mod = 'files' AND categories_access <= '" . $account['access_files'] . "'";
$sub_where .= " AND categories_subid = '" . $categories_id . "'";
$sub_data = cs_sql_select(__FILE__,'categories','*',$sub_where,'categories_name',0,0);
$sub_loop = count($sub_data);
$data['if']['subcats'] = 0;

if(!empty($sub_loop)) {
  $data['if']['subcats'] = 1;
  $data['subs'] = array();

  for($runb=0; $runb < $sub_loop; $runb++) {
    $data['subs'][$runb]['name'] = cs_secure($sub_data[$runb]['categories_name']);
    $data['subs'][$runb]['id'] = $sub_data[$runb]['categories_id'];
    $data['subs'][$runb]['count'] = cs_sql_count(__FILE__,'files',"categories_id = '" . $sub_data[$runb]['categories_id'] . "'");
    $data['subs'][$runb]['if']['text'] = 0;

    if(!empty($sub_data[$runb]['categories_text'])) {
      $data['subs'][$runb]['if']['text'] = 1;
      $data['subs'][$runb]['text'] = cs_secure($sub_data[$runb]['categories_text'],1); 
    }
  }   
}

$from = 'files fls INNER JOIN {pre}_users usr ON fls.users_id = usr.users_id';
$select = 'fls.files_name AS files_name, fls.users_id AS users_id, usr.users_nick'; 
$select .= ' AS users_nick, usr.users_active AS users_active, fls.files_time AS files_time, fls.files_id AS files_id';
$select .= ', fls.files_mirror AS files_mirror, fls.files_size AS files_size';
$cs_files = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$files_loop = count($cs_files);

$data['sort']['name'] = cs_sort('files','listcat',$start,$categories_id,1,$sort);
$data['sort']['date'] = cs_sort('files','listcat',$start,$categories_id,3,$sort);
$data['sort']['big'] = cs_sort('files','listcat',$start,$categories_id,5,$sort);

$data['files'] = array();

for($run=0; $run<$files_loop; $run++) {    
  $data['files'][$run]['id'] = $cs_files[$run]['files_id'];
  $data['files'][$run]['name'] = $cs_files[$run]['files_name'];
  $data['files'][$run]['user'] = cs_user($cs_files[$run]['users_id'],$cs_files[$run]['users_nick'], $cs_files[$run]['users_active']);
  $data['files'][$run]['date'] = cs_date('unix',$cs_files[$run]['files_time'],1);
  $data['files'][$run]['size'] = cs_filesize($cs_files[$run]['files_size']);

  $data['files'][$run]['filetypes'] = array();
  $files_mirror = $cs_files[$run]['files_mirror'];
  $temp = explode("-----", $files_mirror);
  $temp_loop = count($temp);
  $file_typ_array = array();
  $run_3 = '0';

  for ($run_2 = 1; $run_2 < $temp_loop; $run_2++) {
    $temp_a = explode("\n", $temp[$run_2]);
    if(in_array($temp_a['3'],$file_typ_array,TRUE)) {} else {
      $file_typ_array[$run_3] = $temp_a['3'];
      $run_3++;
    }
  }
  $loop_file_typ_array = count($file_typ_array);
  for ($run_2 = 0; $run_2 < $loop_file_typ_array; $run_2++) {
    $ext = $file_typ_array[$run_2];

    $data['files'][$run]['filetypes'][$run_2]['icon'] = cs_filetype($ext);  
  }
}

if(empty($categories))
  require 'mods/errors/403.php';
else
  echo cs_subtemplate(__FILE__,$data,'files','listcat');