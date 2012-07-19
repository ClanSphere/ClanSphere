<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

require_once 'mods/board/functions.php';

$cs_option = cs_sql_option(__FILE__,'board');
$data = array();

$toplist = toplist_comments(0, $cs_option['max_navtop']);

$data['top'] = '';
if(!empty($toplist)) {
  $run = 0;
  foreach ($toplist AS $user_data) {
    $data['top'][$run]['users'] = empty($user_data['users_nick']) ? '' : cs_user($user_data['users_id'], $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
    $data['top'][$run]['comments'] = $user_data['num_comments'];
    $run++;
  }
}
  
echo cs_subtemplate(__FILE__,$data, 'board', 'navtop');