<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

$data = array();

require 'mods/files/functions.php';

$file_id = !empty($_GET['where']) ? (int) $_GET['where'] : (int) $_GET['id'];

$from = 'files fls INNER JOIN {pre}_users usr ON fls.users_id = usr.users_id';
$from .= ' INNER JOIN {pre}_categories cat ON fls.categories_id = cat.categories_id';
$select = 'fls.files_name AS files_name, fls.users_id AS users_id, usr.users_nick';
$select .= ' AS users_nick, usr.users_active AS users_active, fls.files_time AS files_time, fls.files_id AS files_id';
$select .= ', fls.files_mirror AS files_mirror ,cat.categories_name AS categories_name';
$select .= ', cat.categories_id AS categories_id, fls.files_count AS files_count';
$select .= ', fls.files_description AS files_description, fls.files_close AS files_close';
$select .= ', fls.files_vote AS files_vote, fls.files_size AS files_size, fls.files_version AS files_version, fls.files_previews AS files_previews';
$where = 'cat.categories_access <= ' . (int) $account['access_files'] . ' AND fls.files_id = ' . $file_id;
$cs_file = cs_sql_select(__FILE__,$from,$select,$where);

if(!empty($_POST['brokenlink'])) {
  require_once('mods/notifymods/functions.php');
  notifymods_mail('files', $account['users_id'], $cs_file['files_name']);
  $data['if']['brokenlink'] = FALSE;
}
else
  $data['if']['brokenlink'] = TRUE;

$from = 'voted';
$select = 'users_id, voted_answer';
$where = 'voted_fid = ' . $file_id . ' AND voted_mod = \'files\'';
$cs_voted = cs_sql_select(__FILE__,$from,$select,$where,0,0,0);
$voted_loop = count($cs_voted);

if(!empty($_POST['voted_answer']))
  $voted_answer = $_POST['voted_answer'];

$users_id = !empty($account['users_id']) ? $account['users_id'] : 0;

$check_user_voted = 0;
for ($run = 0; $run < $voted_loop; $run++) {
  $voted_users_id = $cs_voted[$run]['users_id'];
  if($voted_users_id == $users_id) {
    $check_user_voted++;
  }
}

if(empty($check_user_voted) AND isset($_POST['submit']) AND empty($_POST['brokenlink'])) {
  $time = cs_time();
  $voted_ip = cs_getip();
  $votes_cells = array('voted_fid','users_id','voted_time','voted_answer','voted_ip','voted_mod');
  $votes_save = array($file_id,$users_id,$time,$voted_answer,$voted_ip,'files');
  cs_sql_insert(__FILE__,'voted',$votes_cells,$votes_save);
  cs_redirect(NULL, 'files', 'view','where=' . $file_id);
}


$data['category']['name'] = $cs_file['categories_name'];
$data['category']['id'] = $cs_file['categories_id'];
$data['file']['id'] = $cs_file['files_id'];
$data['file']['name'] = cs_secure($cs_file['files_name']);
$data['file']['version'] =  cs_secure($cs_file['files_version']);
$data['file']['size'] =  cs_filesize($cs_file['files_size']);
$data['file']['user'] = cs_user($cs_file['users_id'],$cs_file['users_nick'], $cs_file['users_active']);
$data['file']['date'] = cs_date('unix',$cs_file['files_time'],1);
$data['file']['count'] = cs_secure($cs_file['files_count']); 

$data['if']['vote'] = false;

$data['if']['unvoted'] = false;

if(!empty($cs_file['files_vote'])) {
  $data['if']['vote'] = true;
  if(empty($check_user_voted)) { 
    $data['votes'] = array();
    $data['if']['unvoted'] = true;
    for($l = 1;$l < 7;$l++) {
      $data['votes'][$l-1]['name'] = $l . ' - ' . $cs_lang['vote_' . $l];
      $data['votes'][$l-1]['value'] = $l;
    }   
  }
  else {
    $files_votes = 0;
    for($run=0; $run<$voted_loop; $run++) {
      $a = cs_secure($cs_voted[$run]['voted_answer']);
      $files_votes += $a;
    }
    $files_votes /= $voted_loop;
    $files_votes = round($files_votes,0);
    $stars = '';
    for($run=6; $run>$files_votes; $run--)
      $stars .= cs_icon('favorites');
    for($run=1; $run<$files_votes; $run++)
      $stars .= cs_icon('favorites1');
    $data['vote']['stars'] = $stars;
  }
}

$data['file']['description'] = cs_secure($cs_file['files_description'],1,1);

$data['if']['preview'] = false;
if(!empty($cs_file['files_previews'])) {
  $data['if']['preview'] = true;
  $data['previews'] = array();
  
  $files_pics = explode("\n",$cs_file['files_previews']);
  $count = 1;
  foreach($files_pics AS $pic) {
    $data['previews'][$count-1]['image'] = cs_html_img('uploads/files/thumb-' . $pic);
    $data['previews'][$count-1]['path'] = 'uploads/files/picture-' . $pic;
    $count++;
  }
}

$data['mirrors'] = array();
$files_mirror = $cs_file['files_mirror'];
$temp = explode("-----", $files_mirror);
$temp_loop = count($temp);

if(isset($_REQUEST['target']) AND is_array($cs_file)) {
  $files_cells = array('files_count');
  $files_save = array(++$cs_file['files_count']);
  cs_sql_update(__FILE__,'files',$files_cells,$files_save,$file_id,0,0);
  $temp_a = explode("\n", $temp[$_REQUEST['target']]);
  $select_mirrow = $temp_a['1'];
  header("Location: ".$select_mirrow."");
} 

require_once 'mods/clansphere/filetype.php';

for ($run = 1; $run < $temp_loop; $run++) {
  $temp_a = explode("\n", $temp[$run]);
  if($account['access_files'] >= $temp_a['4']) {
    $data['mirrors'][$run-1]['name'] = empty($temp_a['2']) ? $temp_a['1'] : $temp_a['2'];
    $data['mirrors'][$run-1]['id'] = $run;
    $data['mirrors'][$run-1]['filetype_image'] = cs_filetype($temp_a['3']);  
    $data['mirrors'][$run-1]['filetype_name'] = $temp_a['3'];
  }
}

include_once('mods/comments/functions.php');

$where_com = 'comments_mod = \'files\' AND comments_fid = ' . $file_id;
$count_com = cs_sql_count(__FILE__,'comments',$where_com);

if(empty($cs_file))
  require 'mods/errors/404.php';
else {
  echo cs_subtemplate(__FILE__,$data,'files','view');

  if(!empty($count_com))
    echo cs_comments_view($file_id,'files','view',$count_com);

  echo cs_comments_add($file_id,'files',$cs_file['files_close']);
}