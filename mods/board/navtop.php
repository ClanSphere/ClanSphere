<?php
// ClanSphere 2009 - www.clansphere.net
// $Id: $

$max = 5;
$data = array();
$time = (int) date('mdHi');
$data = cs_cache_load('brd_navtop');
if (empty($data) OR $data['time'] < $time-100) {
  $data['time'] = $time;
  $tables  = "comments cms LEFT JOIN {pre}_users usr ON cms.users_id = usr.users_id AND usr.users_active = '1' ";
  $tables .= 'LEFT JOIN {pre}_threads thr ON thr.users_id = usr.users_id GROUP BY usr.users_id, usr.users_nick';
  $cells  = 'usr.users_id AS users_id, usr.users_nick AS users_nick, ';
  $cells .= 'COUNT(DISTINCT cms.comments_id) + COUNT(DISTINCT thr.threads_id) AS comments';
  $data['top'] = cs_sql_select(__FILE__,$tables,$cells,0,'comments DESC, usr.users_nick',0,$max);
  cs_cache_save('brd_navtop', $data);
}
echo cs_subtemplate(__FILE__,$data, 'board', 'navtop');