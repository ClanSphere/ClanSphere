<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$data = array();

$thread_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $thread_id = $cs_post['id'];

require_once('mods/board/functions.php');

$check_pw = 1;

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$select = 'frm.board_pwd AS board_pwd, frm.board_access AS board_access, frm.board_id AS board_id, thr.threads_headline AS threads_headline, ';
$select .= 'thr.users_id AS users_id, frm.squads_id AS squads_id';
$where = "thr.threads_id = '" . $thread_id . "'";
$cs_thread = cs_sql_select(__FILE__,$from,$select,$where);

//Sicherheitsabfrage Beginn
$cs_boardfiles = cs_sql_select(__FILE__,'boardfiles','boardfiles_name,boardfiles_id',"threads_id='" . (int) $thread_id . "'",0,0,0);
$cs_boardfiles_loop = count($cs_boardfiles); 

$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_del',"users_id = '" . $account['users_id'] . "'",0,0,1);

if(!empty($cs_thread['board_pwd'])) {
  $where = 'users_id = "' . $account['users_id'] . '" AND board_id = "' . $cs_thread['board_id'] . '"';
  $check_pw = cs_sql_count(__FILE__,'boardpws',$where);
}

if(!empty($cs_thread['squads_id'])) {
  $where = "squads_id = '" . $cs_thread['squads_id'] . "' AND users_id = '" .$account['users_id'] . "'";
  $check_sq = cs_sql_count(__FILE__,'members',$where);
}

$allowed = 0;
if(empty($thread_id) || (count($cs_thread) == 0))
  return errorPage('thread_remove', $cs_lang);

if($account['access_board'] >= $cs_thread['board_access']) {
  $where_com = "comments_mod = 'board' AND comments_fid = '" . $thread_id . "'";
  $sum= cs_sql_count(__FILE__,'comments',$where_com);  
  if($account['access_comments'] >= 5 OR !empty($thread_mods['boardmods_del'])) {
    $allowed = 1;
  } elseif($cs_thread['users_id'] == $account['users_id'] AND empty($sum)) {
    $allowed = 1;  
  } else {
     return errorPage('thread_remove', $cs_lang);
  }
} elseif(!empty($check_sq)) {
  $allowed = 1;  
} elseif(empty($allowed) OR empty($check_pw)) {
  return errorPage('thread_remove', $cs_lang);
}
//Sicherheitsabfrage Ende


if(isset($_POST['agree'])) {
  
  for($run=0; $run < $cs_boardfiles_loop; $run++)
  {       
    $file = $cs_boardfiles[$run]['boardfiles_name'];
    $extension = strlen(strrchr($file,"."));
    $name = strlen($file);
    $ext = substr($file,$name - $extension + 1,$name); 
    //$file = cs_secure($cs_boardfiles[$run]['boardfiles_name']);
    //echo 'uploads/board/files/' . $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext . cs_html_br(1);
    cs_unlink('board', $cs_boardfiles[$run]['boardfiles_id'] . '.' . $ext, 'files');
  }
  
  cs_sql_delete(__FILE__,'threads',$thread_id);
  $query = "DELETE FROM {pre}_comments WHERE comments_mod='board' AND ";
  $query .= "comments_fid='" . $thread_id . "'";
  cs_sql_query(__FILE__,$query); 
  $query = "DELETE FROM {pre}_abonements WHERE threads_id='" . $thread_id . "'";
  cs_sql_query(__FILE__,$query);
  $query = "DELETE FROM {pre}_boardfiles WHERE threads_id='" . $thread_id . "'";
  cs_sql_query(__FILE__,$query);
  $query = "DELETE FROM {pre}_boardvotes WHERE threads_id='" . $thread_id . "'";
  cs_sql_query(__FILE__,$query);
  $query = "DELETE FROM {pre}_voted WHERE voted_mod='board' AND ";
  $query .= "voted_fid='" . $thread_id . "'";
  cs_sql_query(__FILE__,$query);
  // Delte GhostLinks
  $query = "DELETE FROM {pre}_threads WHERE threads_ghost_thread = '" . $thread_id ."'";
  cs_sql_query(__FILE__,$query);
  

  # Update board entry to get correct threads and comments count
  include_once('mods/board/repair.php');
  cs_board_threads($cs_thread['board_id']);
  cs_board_comments($cs_thread['board_id']);

  # Remove attached boardreports if there are any
  cs_sql_delete(__FILE__, 'boardreport', $thread_id, 'threads_id');
  
  cs_redirect($cs_lang['del_true'],'board','listcat','where='.$cs_thread['board_id']);
}

if(isset($_POST['cancel']))
 cs_redirect($cs_lang['del_false'],'board','thread','where=' .$thread_id);

else {
  $data['head']['body'] = sprintf($cs_lang['del_thread_rly'], cs_secure($cs_thread['threads_headline']));
  $data['thread']['id'] = $thread_id;
  
 echo cs_subtemplate(__FILE__,$data,'board','thread_remove');
}