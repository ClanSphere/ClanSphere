<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

require_once 'mods/board/functions.php';

$max = 5;
$data = array();

$toplist = users_comments_toplist($max,0,0,0);

$data['top2'] = '';
if(!empty($toplist)) {
  $run = 0;
  foreach ($toplist AS $users_id => $user_data) {
    $data['top2'][$run]['users'] = empty($user_data) ? '' : cs_user($users_id, $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
    $data['top2'][$run]['threads'] = $user_data['comments'];
    $run++;
  }
}
  
echo cs_subtemplate(__FILE__,$data, 'board', 'navtop2');