<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$board_id = empty($_GET['id']) ? 0 : (int) $_GET['id'];

$cs_readtime = cs_time() - $account['users_readtime'];

$cells = 'thr.threads_id, thr.board_id, rea.users_id, rea.read_id, rea.read_since';
$from ='threads thr LEFT JOIN {pre}_read rea ON thr.threads_id = rea.threads_id';
$where = "rea.users_id= '". $account['users_id'] ."' AND thr.threads_last_time > '" . $cs_readtime . "'";

if(empty($board_id))
  $thr_where = "threads_last_time > '" . $cs_readtime . "'";
else {
  $where .=" AND thr.board_id = '". $board_id ."'";
  $thr_where = "board_id = '". $board_id ."' AND threads_last_time > '" . $cs_readtime . "'";
}

$readed = cs_sql_select(__FILE__,$from,$cells,$where,'thr.threads_id',0,0);
$threads = cs_sql_select(__FILE__,'threads','threads_id, threads_last_time',$thr_where,'threads_id',0,0);
$threads_loop = count($threads);

for($run=0; $run < $threads_loop; $run++) {
  if(isset($readed[$run]['threads_id']) AND in_array($readed[$run]['threads_id'], $threads[$run])) {
    if($readed[$run]['read_since'] < $threads[$run]['threads_last_time']) {
      $data['read_since'] = cs_time();
      $cells = array_keys($data);
      $save = array_values($data);  
      cs_sql_update(__FILE__,'read',$cells,$save,$readed[$run]['read_id'], 0, 0);
    }
  }
  else {
    $data['threads_id'] = $threads[$run]['threads_id'];
    $data['users_id'] = $account['users_id'];
    $data['read_since'] = cs_time();
    $cells = array_keys($data);
    $save = array_values($data); 
    cs_sql_insert(__FILE__,'read',$cells,$save);
  }
}

if($thr_where == "threads_last_time > '" . $cs_readtime . "'")
    cs_redirect($cs_lang['mark_all'], 'board', 'list');
else
  cs_redirect($cs_lang['mark_board'], 'board', 'listcat', 'id=' . $board_id);