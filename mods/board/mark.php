<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_usertime = cs_sql_select(__FILE__,'users','users_readtime',"users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];

$cells = 'thr.threads_id, thr.board_id, rea.users_id, rea.read_id, rea.read_since';
$from ='threads thr INNER JOIN {pre}_read rea ON thr.threads_id = rea.threads_id';
$order = 'thr.threads_id';
$where = "rea.users_id= '". $account['users_id'] ."' AND thr.threads_last_time > '" . $cs_readtime . "'";

if(isset($_GET['id']) AND !empty($_GET['id'])) {
  $where .=" AND thr.board_id= '". $_GET['id'] ."'";
  $thr_where = "board_id= '". $_GET['id'] ."' AND threads_last_time > '" . $cs_readtime . "'";
}
else {    
  $thr_where = "threads_last_time > '" . $cs_readtime . "'";
}

$readed = cs_sql_select(__FILE__,$from,$cells,$where,$order,0,0);    
$threads = cs_sql_select(__FILE__,'threads','threads_id, threads_last_time',$thr_where,'threads_id',0,0); 
$threads_loop=count($threads);
         
for($run=0; $run < $threads_loop; $run++) {
  if(@!in_array($readed[$run]['threads_id'], $threads[$run])) {
    $data['threads_id'] = $threads[$run]['threads_id'];
    $data['users_id'] = $account['users_id'];
    $data['read_since'] = cs_time();
    $cells = array_keys($data);
    $save = array_values($data); 
    cs_sql_insert(__FILE__,'read',$cells,$save);
  }
  else {    
    if($readed[$run]['read_since'] < $threads[$run]['threads_last_time']) {       
      $data['read_since'] = cs_time();
      $cells = array_keys($data);
      $save = array_values($data);  
      cs_sql_update(__FILE__,'read',$cells,$save,$readed[$run]['read_id']);
    }
  }  
}
           
if($thr_where == "threads_last_time > '" . $cs_readtime . "'") {
    header('location:' . $_SERVER['PHP_SELF'] . '?mod=board');
}
else {
  header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=listcat&id=' .$_GET['id']);
}
?>