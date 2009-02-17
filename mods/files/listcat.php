<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$files_size = '';

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$categories_id = $_REQUEST['where'];
settype($categories_id,'integer');
$where = "categories_id = '" . $categories_id . "'";

$cs_sort[1] = 'files_name DESC';
$cs_sort[2] = 'files_name ASC';
$cs_sort[3] = 'files_time DESC';
$cs_sort[4] = 'files_time ASC';
$cs_sort[5] = 'files_size DESC';
$cs_sort[6] = 'files_size ASC';
empty($_REQUEST['sort']) ? $sort = 3 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$files_count = cs_sql_count(__FILE__,'files',$where);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);

$categories = cs_sql_select(__FILE__,'categories','categories_name',"categories_id = '" . $categories_id . "'");
$cat = $categories['categories_name']; 
$body = cs_link($cs_lang['mod'],'files','list');
echo $body . ' - ' . $cat;
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $files_count;
echo cs_html_roco(2,'rightb',0,0);
echo cs_pages('files','listcat',$files_count,$start,$categories_id,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$sub_where = "categories_mod = 'files' AND categories_access <= '" . $account['access_files'] . "'";
$sub_where .= " AND categories_subid = '" . $categories_id . "'";
$sub_data = cs_sql_select(__FILE__,'categories','*',$sub_where,'categories_name',0,0);
$sub_loop = count($sub_data);
if(!empty($sub_loop)) {
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo 'Unterkategorien:';
  echo cs_html_roco(0);
  for($runb=0; $runb < $sub_loop; $runb++) {
    echo cs_html_roco(1,'leftc');
    echo cs_link(cs_secure($sub_data[$runb]['categories_name']),'files','listcat','where=' . $sub_data[$runb]['categories_id']);
    $content = cs_sql_count(__FILE__,'files',"categories_id = '" . $sub_data[$runb]['categories_id'] . "'");
    echo ' ('. $content .')';
  echo cs_html_roco(0);
  if(!empty($sub_data[$runb]['categories_text'])) {
      echo cs_html_roco(1,'leftb');
    echo cs_secure($sub_data[$runb]['categories_text'],1);
    echo cs_html_roco(0);  
    }
  }   
  echo cs_html_table(0);
  echo cs_html_br(1);  
}



$from = 'files fls INNER JOIN {pre}_users usr ON fls.users_id = usr.users_id';
$select = 'fls.files_name AS files_name, fls.users_id AS users_id, usr.users_nick'; 
$select .= ' AS users_nick, usr.users_active AS users_active, fls.files_time AS files_time, fls.files_id AS files_id';
$select .= ', fls.files_mirror AS files_mirror, fls.files_size AS files_size';
$cs_files = cs_sql_select(__FILE__,$from,$select,$where,$order,$start,$account['users_limit']);
$files_loop = count($cs_files);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('files','listcat',$start,$categories_id,1,$sort);
echo $cs_lang['name'];
echo cs_html_roco(2,'headb');
echo $cs_lang['user'];
echo cs_html_roco(3,'headb');
echo cs_sort('files','listcat',$start,$categories_id,3,$sort);
echo $cs_lang['date'];
echo cs_html_roco(4,'headb');
echo cs_sort('files','listcat',$start,$categories_id,5,$sort);
echo $cs_lang['big'];
echo cs_html_roco(5,'headb'); 
echo $cs_lang['typ'];
echo cs_html_roco(0);

for($run=0; $run<$files_loop; $run++) {       
  echo cs_html_roco(1,'leftc');
  echo cs_link($cs_files[$run]['files_name'],'files','view','where=' .$cs_files[$run]['files_id']);
  echo cs_html_roco(2,'leftc');
  $cs_files_user = cs_secure($cs_files[$run]['users_nick']);
  echo cs_user($cs_files[$run]['users_id'],$cs_files[$run]['users_nick'], $cs_files[$run]['users_active']);
  echo cs_html_roco(3,'leftc');
  echo cs_date('unix',$cs_files[$run]['files_time'],1);
  echo cs_html_roco(4,'leftc');
  if($cs_files[$run]['files_size'] >= 1024) {
    $files_size = cs_secure(round($cs_files[$run]['files_size'] / 1024,2) .' KB'); 
  }
  if($cs_files[$run]['files_size'] >= 1024 * 1024) {       
    $files_size = cs_secure(round($cs_files[$run]['files_size'] / 1024 / 1024,2) .' MB');
  }
  if($cs_files[$run]['files_size'] >= 1024 * 1024 * 1024) {       
    $files_size = cs_secure(round($cs_files[$run]['files_size'] / 1024 / 1024 / 1024,2) .' GB');
  }
  echo $files_size;
  $files_size = '';
  echo cs_html_roco(5,'leftc'); 
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
  echo cs_html_img('symbols/files/filetypes/' . $ext . '.gif',0,0,0,$ext);
  }
  echo cs_html_roco(0);
}
echo cs_html_table(0);
?>