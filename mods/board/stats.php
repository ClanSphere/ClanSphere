<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once 'mods/board/functions.php';

$d = array();
$array_result = array();
$toplist = array();
$count = 0;

$d['stats']['topics'] = cs_sql_count(__FILE__,'threads');
$d['stats']['posts'] = cs_sql_count(__FILE__,'comments','comments_mod = \'board\'');
$d['stats']['users'] = cs_sql_count(__FILE__,'users', 'users_active = 1 AND users_delete = 0');
$d['stats']['categories'] = cs_sql_count(__FILE__,'categories','categories_mod = \'board\'');
$d['stats']['boards'] = cs_sql_count(__FILE__,'board');

// START user-top3
global $array_result;

$comments = cs_sql_select(__FILE__, 'comments GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);
$threads = cs_sql_select(__FILE__, 'threads GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);

if (!empty($comments)) array_walk($comments, 'manageData');
if (!empty($threads)) array_walk($threads, 'manageData');

if(is_array($array_result)) {
    arsort($array_result);
    $toplist = $array_result; // Comments + threads
}

// START "users_active"
$user_cond = '(';
foreach ($toplist as $users_id => $comments)
  $user_cond .= 'users_id = "' . $users_id . '" OR ';
$user_cond = substr($user_cond, 0, -4);
$user_cond .= ') AND users_active = 1 AND users_delete = 0';

$users_active = cs_sql_select (__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', $user_cond, 0, 0, 0);
$d['stats']['users_active'] = empty($users_active) ? 0 : count($users_active);
// STOP "users_active"

if(is_array($array_result)) {
    $toplist = array_slice($array_result, 0, 3, true); // only the top3 needed
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

$d['stats']['toplist'] = '';
if(!empty($toplist)) {
  foreach ($toplist AS $users_id => $comments)
		$d['stats']['toplist'] .= cs_user($users_id, $user[$users_id]['users_nick'], $user[$users_id]['users_active'], $user[$users_id]['users_delete']) . ' (' . $comments . ' ' . $cs_lang['posts'] . '), ';
  $d['stats']['toplist'] = substr($d['stats']['toplist'],0,-2);
}
// STOP user-top3

$tables  = 'threads t INNER JOIN {pre}_board b ON t.board_id = b.board_id ';
$tables .= 'AND b.board_access <= \''.$account['access_board'].'\' AND b.board_pwd = \'\' ';
$tables .= 'INNER JOIN {pre}_comments cms ON cms.comments_mod = \'board\' ';
$tables .= 'AND cms.comments_fid = t.threads_id GROUP BY t.threads_id';
$cells  = 't.threads_id AS threads_id, t.threads_comments AS threads_comments, ';
$cells .= 't.threads_headline AS threads_headline, COUNT(cms.comments_id) AS comments';
$select = cs_sql_select(__FILE__,$tables,$cells,0,'comments DESC');
$d['stats']['longest_thread'] = $select['threads_headline'];
$d['stats']['longest_thread_posts'] = $select['comments'];
$d['url']['longest_thread'] = cs_url('board','thread','where=' . $select['threads_id']);
$d['stats']['average_posts'] = !empty($d['stats']['topics']) ? round($d['stats']['posts'] / $d['stats']['topics'],2) : 0;
/*
$tables = 'comments cms LEFT JOIN {pre}_users usr ON cms.users_id = usr.users_id GROUP BY usr.users_id';
$cells = 'usr.users_nick AS users_nick, usr.users_id AS users_id, COUNT(cms.comments_id) AS smileys';
$cond = 'cms.comments_text LIKE \'%:)%\'';
$select = cs_sql_select(__FILE__,$tables,$cells,$cond,'smileys DESC');*/

echo cs_subtemplate(__FILE__,$d,'board','stats');