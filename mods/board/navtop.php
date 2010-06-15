<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

require_once 'mods/board/functions.php';

$max = 5;
$data = array();

$toplist = users_comments_toplist($max);

$data['top'] = '';
if(!empty($toplist)) {
  $run = 0;
  foreach ($toplist AS $users_id => $user_data) {
    $data['top'][$run]['users'] = empty($user_data['users_nick']) ? '' : cs_user($users_id, $user_data['users_nick'], $user_data['users_active'], $user_data['users_delete']);
    $data['top'][$run]['comments'] = $user_data['comments'];
    $run++;
  }
}
  
echo cs_subtemplate(__FILE__,$data, 'board', 'navtop');