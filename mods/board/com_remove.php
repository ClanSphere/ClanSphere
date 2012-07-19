<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$comments_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $comments_id = $cs_post['id'];

require_once('mods/board/functions.php');

$cells = 'comments_fid';
$cs_comments = cs_sql_select(__FILE__,'comments',$cells,"comments_id = '" . $comments_id . "'");
$com_fid = $cs_comments['comments_fid'];

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$select = 'frm.board_access AS board_access, frm.board_id AS board_id, '
        . 'thr.threads_time AS threads_time, thr.users_id AS users_id';
$where = "thr.threads_id = '" . $com_fid . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where);

// Board files auslesen
$where = "comments_id = '" . $comments_id ."'";
$cs_com_files = cs_sql_select(__FILE__,'boardfiles','boardfiles_name,boardfiles_id',$where,0,0,0);
$cs_com_files_loop = count($cs_com_files); 

//Sicherheitsabfrage Beginn 
$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_del',"users_id = '" . $account['users_id'] . "'",0,0,1);
$allowed = 0;      

if(empty($comments_id) || (count($cs_comments) == 0))
  return errorPage('com_remove', $cs_lang);

if($account['access_board'] >= $cs_thread['board_access'])
{
  $allowed = 0;
  if($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_del'])) 
    $allowed = 1;
  else  
    return errorPage('com_remove', $cs_lang);
}  
else if(empty($allowed))
  return errorPage('com_remove', $cs_lang);
//Sicherheitsabfrage Ende

if(isset($_POST['agree'])) {

  for($run=0; $run < $cs_com_files_loop; $run++)
  {    
    $file = $cs_com_files[$run]['boardfiles_name'];
    $extension = strlen(strrchr($file,"."));
    $name = strlen($file);
    $ext = substr($file,$name - $extension + 1,$name); 
    //$file = cs_secure($cs_boardfiles[$run]['boardfiles_name']);
    //echo 'uploads/board/files/' . $cs_com_files[$run]['boardfiles_id'] . '.' . $ext . cs_html_br(1);
    cs_unlink('board', $cs_com_files[$run]['boardfiles_id'] . '.' . $ext, 'files');
    $query = "DELETE FROM {pre}_boardfiles WHERE boardfiles_id = '" . $cs_com_files[$run]['boardfiles_id'] . "'";
    cs_sql_query(__FILE__,$query);
  }

  $where = "comments_id > '" . $comments_id . "' AND comments_fid = '" . $com_fid . "'";
  $where .= " AND comments_mod = 'board'";
  $before = cs_sql_count(__FILE__,'comments',$where);
  $start = floor($before / $account['users_limit']) * $account['users_limit'];

  cs_sql_delete(__FILE__,'comments',$comments_id);

  $update_last = cs_sql_select(__FILE__,'comments','*',"comments_fid = '" . $com_fid . "'",'comments_time DESC',0,1);
  $cells = array('threads_last_time','threads_last_user');

  if(empty($update_last['comments_time']))
    $saves = array((int) $cs_thread['threads_time'], (int) $cs_thread['users_id']);
  else
    $saves = array((int) $update_last['comments_time'], (int) $update_last['users_id']);

  cs_sql_update(__FILE__,'threads',$cells,$saves,$com_fid); 

  # Update board entry to get correct threads and comments count
  include_once('mods/board/repair.php');
  cs_board_comments($cs_thread['board_id']);
  cs_board_last($cs_thread['board_id']);
  cs_threads_comments($com_fid);
  
  # Remove attached boardreport if there is one
  cs_sql_delete(__FILE__, 'boardreport', $comments_id, 'comments_id');

  $more = 'where=' . $com_fid . '&amp;start=' . $start;

  cs_redirect($cs_lang['del_true'],'board','thread',$more);
}

if(isset($_POST['cancel'])) {

  $options_board = cs_sql_option(__FILE__, 'board');
  $where = "comments_fid = \"" . $com_fid . "\" AND comments_mod = 'board' AND comments_id <= \"" . $comments_id . "\"";
  $comnr = cs_sql_count(__FILE__,'comments',$where);

  if ($options_board['sort'] == 'ASC') {
    $start = $comnr - $comnr % $account['users_limit'];
  } else {
    $where = "comments_fid = \"" . $com_fid . "\" AND comments_mod = 'board' AND comments_id > \"" . $comments_id . "\"";
    $after = cs_sql_count(__FILE__,'comments',$where);
    $start = $after - $after % $account['users_limit'];
  }

  $add_start = empty($start) ? '' : '&start=' . $start;
  $more = 'where=' . $com_fid . $add_start . '#com' . $comnr;
  cs_redirect($cs_lang['del_false'],'board','thread',$more);
}

else {

  $data['head']['body'] = sprintf($cs_lang['del_rly'],$comments_id);
  $data['comments']['id'] = $comments_id;

  echo cs_subtemplate(__FILE__,$data,'board','com_remove');
}