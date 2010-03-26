<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$max = 5;
$data = array();

  // START user-top
  require_once 'mods/board/functions.php';
  $array_result = array();
  $toplist = array();
  $count = 0;
  global $array_result;

  $comments = cs_sql_select(__FILE__, 'comments GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);
  $threads = cs_sql_select(__FILE__, 'threads GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);

  if (!empty($comments)) array_walk($comments, 'manageData');
  if (!empty($threads)) array_walk($threads, 'manageData');

  if(is_array($array_result)) {
      arsort($array_result);
      $toplist = array_slice($array_result, 0, $max, true); // only $max needed
      $count = count($array_result);
  }

  $array_result = array();
  $user_cond = '';

  foreach ($toplist as $users_id => $noneed) $user_cond .= 'users_id = "' . $users_id . '" OR '; // Select only the users needed
  $user_cond = substr($user_cond, 0, -4);

  $user = cs_sql_select (__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', $user_cond, 0, 0, 0);

  array_walk ($user, 'manageUsers'); // To make the users more accessable
  $user = $array_result; // Users
  unset($array_result);

  $data['top'] = '';
  if(!empty($toplist)) {
    $run = 0;
    foreach ($toplist AS $users_id => $comments) {
      $data['top'][$run]['users'] = empty($user[$users_id]) ? '' : cs_user($users_id, $user[$users_id]['users_nick'], $user[$users_id]['users_active'], $user[$users_id]['users_delete']);
      $data['top'][$run]['comments'] = $comments;
      $run++;
    }
  }
  // STOP user-top
  
echo cs_subtemplate(__FILE__,$data, 'board', 'navtop');