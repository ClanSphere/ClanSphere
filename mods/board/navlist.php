<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$cs_usertime = cs_sql_select(__FILE__,'users','users_readtime',"users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];

$data = array();
$figures = 20;

$tables  = 'threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id ';
$tables .= 'LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = \''.$account['users_id'].'\'';
$cells   = 'thr.threads_headline AS threads_headline, thr.threads_id AS threads_id, ';
$cells  .= 'thr.threads_last_time AS threads_last_time, frm.board_name AS board_name, frm.board_id AS board_id';
$cond    = 'frm.board_access <= \''.$account['access_board'].'\' AND frm.board_pwd = \'\'';
if(!empty($account['users_id'])) {
  $cond   .= ' AND thr.threads_last_time > \'' . $cs_readtime . '\' AND (thr.threads_last_time > red.read_since OR red.threads_id IS NULL)';
}
$order   = 'thr.threads_last_time DESC'; 
$data['threads'] = cs_sql_select(__FILE__,$tables,$cells,$cond,$order,0,8);

if(empty($data['threads'])) {
  echo $cs_lang['no_new_posts'];
}
else {
  $count_threads = count($data['threads']);
  
  for ($run = 0; $run < $count_threads; $run++) {
    $data['threads'][$run]['threads_date'] = cs_date('unix',$data['threads'][$run]['threads_last_time'],1);
    $data['threads'][$run]['threads_headline'] = cs_secure($data['threads'][$run]['threads_headline']);
    $data['threads'][$run]['threads_headline_short'] = strlen($data['threads'][$run]['threads_headline']) <= $figures ?
      $data['threads'][$run]['threads_headline'] : substr($data['threads'][$run]['threads_headline'],0,$figures-2) . '..';
  }
  echo cs_subtemplate(__FILE__,$data,'board','navlist');
}