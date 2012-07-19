<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

require_once 'mods/board/functions.php';

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$array_result = array();
$toplist = array();
$cs_ranks = cs_sql_select(__FILE__,'boardranks','boardranks_min, boardranks_name',0,'boardranks_min ASC',0,0);

$toplist = toplist_comments($start, $account['users_limit']);
$count = cs_sql_count(__FILE__,'comments','comments_mod = \'board\'', 'users_id');

$data = array();
$data['pages']['list'] = cs_pages('board','toplist',$count,$start);
$i = 0;
if(!empty($toplist)) {
  foreach ($toplist AS $users_data) {
    if ($users_data['users_id'] != 0) { //dont list comments of visitors
      $data['toplist'][$i]['user'] = empty($users_data['users_nick']) ? '' : 
        cs_user($users_data['users_id'], $users_data['users_nick'], $users_data['users_active'], $users_data['users_delete']);
      $data['toplist'][$i]['number'] = $i + $start + 1;
      $data['toplist'][$i]['rank'] = cs_secure(getRankTitle($users_data['num_comments'], $cs_ranks));
      $data['toplist'][$i]['class'] = $users_data['users_id'] != $account['users_id'] ? 'leftb' : 'leftc';
      $data['toplist'][$i]['comments'] = $users_data['num_comments'];
      $i++;
    }
  }
}
else {
  $data['toplist'] = array();
}

echo cs_subtemplate(__FILE__,$data,'board','toplist');