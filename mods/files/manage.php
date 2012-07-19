<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$categories_id = empty($_REQUEST['where']) ? 0 : $_REQUEST['where'];
settype($categories_id,'integer');
$where = empty($categories_id) ? 0 : 'categories_id = ' . cs_sql_escape($categories_id);

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'files_name DESC';
$cs_sort[2] = 'files_name ASC';
$cs_sort[3] = 'files_time DESC';
$cs_sort[4] = 'files_time ASC';
$sort = empty($_REQUEST['sort']) ? 3 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$files_count = cs_sql_count(__FILE__,'files',$where);

$data = array();

$data['head']['count'] = $files_count;
$data['head']['paginator'] = cs_pages('files','manage',$files_count,$start,$categories_id,$sort);
$data['head']['message'] = cs_getmsg();

$filesmod = "categories_mod = 'files'";
$categories = cs_sql_select(__FILE__,'categories','categories_name, categories_id',$filesmod,'categories_name',0,0);

$data['head']['categories'] = '';
if (!empty($categories)) {
  foreach($categories AS $category) {
    $selected = $category['categories_id'] == $categories_id ? 1 : 0;
    $data['head']['categories'] .= cs_html_option($category['categories_name'], $category['categories_id'], $selected);
  }
}

$from = 'files fls LEFT JOIN {pre}_users usr ON fls.users_id = usr.users_id';
$select = 'fls.files_name AS files_name, fls.users_id AS users_id, usr.users_nick'; 
$select .= ' AS users_nick, usr.users_active AS users_active, usr.users_id AS users_id, usr.users_active AS users_active, fls.files_time AS files_time, fls.files_id AS files_id';
$select .= ', fls.files_mirror AS files_mirror';
$cs_files = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$files_loop = count($cs_files);

$data['sort']['headline'] = cs_sort('files','manage',$start,$categories_id,1,$sort);
$data['sort']['date'] =  cs_sort('files','manage',$start,$categories_id,3,$sort);

$data['files'] = array();

for($run=0; $run<$files_loop; $run++)
{       
  $files_mirror = $cs_files[$run]['files_mirror'];
  $temp = explode("-----", $files_mirror);
  $temp_loop = count($temp);
  $file_typ_array = array();
  $run_3 = '0';
  for ($run_2 = 1; $run_2 < $temp_loop; $run_2++)
  {
    $temp_a = explode("\n", $temp[$run_2]);
    if(!in_array($temp_a['3'],$file_typ_array,TRUE)) {
      $file_typ_array[$run_3] = $temp_a['3'];
      $run_3++;
    }
  }
  $loop_file_typ_array = count($file_typ_array);
  $data['files'][$run]['filetypes'] = array();
  for ($run_2 = 0; $run_2 < $loop_file_typ_array; $run_2++)
  {
    $ext = $file_typ_array[$run_2];
  
    require_once 'mods/clansphere/filetype.php';
    $data['files'][$run]['filetypes'][$run_2]['icon'] = cs_filetype($ext);
  }
  $data['files'][$run]['id'] = $cs_files[$run]['files_id'];
  $data['files'][$run]['name'] = $cs_files[$run]['files_name'];
  $data['files'][$run]['user'] = cs_user($cs_files[$run]['users_id'],$cs_files[$run]['users_nick'], $cs_files[$run]['users_active']);
  $data['files'][$run]['date'] = cs_date('unix',$cs_files[$run]['files_time'],1);
}
echo cs_subtemplate(__FILE__,$data,'files','manage');