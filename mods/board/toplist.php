<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

include 'mods/board/functions.php';

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
$array_result = array();
$toplist = array();
$count = 0;

function manageData (&$array, $key) {
    global $array_result;
    $array_result[ $array['users_id'] ] = empty($array_result[ $array['users_id'] ]) ? $array['important'] : $array_result[ $array['users_id'] ] +  $array['important'];
}

$comments = cs_sql_select (__FILE__, 'comments GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);
$threads = cs_sql_select (__FILE__, 'threads GROUP BY (users_id)', 'COUNT(*) AS important, users_id', 0, 'important DESC', 0, 0);

global $array_result;

if (!empty($comments)) array_walk($comments, 'manageData');
if (!empty($threads)) array_walk($threads, 'manageData');

if(is_array($array_result)) {
    arsort ($array_result);
    $toplist = array_slice ($array_result, $start, $account['users_limit'], true); // Comments + threads
    $count = count($array_result);
}

$array_result = array();
$user_cond = '';

foreach ($toplist as $users_id => $noneed) $user_cond .= 'users_id = "' . $users_id . '" OR '; // Select only the users needed
$user_cond = substr($user_cond, 0, -4);


function manageUsers (&$array, $key) {
    global $array_result;
    $array_result[ $array['users_id'] ] = $array;
}


$users = cs_sql_select (__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', $user_cond, 0, 0, 0);

array_walk ($users, 'manageUsers'); // To make the users more accessable
$users = $array_result; // Users
unset($array_result);

$cs_ranks = cs_sql_select(__FILE__,'boardranks','boardranks_min, boardranks_name',0,'boardranks_min ASC',0,0);
$data = array();
$data['pages']['list'] = cs_pages('board','toplist',$count,$start);
$i = 0;
if(!empty($toplist)) {
    foreach ($toplist AS $users_id => $comments) {

        if ($users_id != 0) //dont list comments of visitors
        {
            $data['toplist'][$i]['user'] = empty($users[$users_id]) ? '' : cs_user ($users_id, $users[$users_id]['users_nick'], $users[$users_id]['users_active'], $users[$users_id]['users_delete']);
            $data['toplist'][$i]['comments'] = $comments;
            $data['toplist'][$i]['number'] = $i + $start + 1;
            $data['toplist'][$i]['rank'] = cs_secure(getRankTitle($comments, $cs_ranks));
            $data['toplist'][$i]['class'] = $users_id != $account['users_id'] ? 'leftb' : 'leftc';

            $i++;
        }
    }
}
else {
    $data['toplist'] = array();
}

echo cs_subtemplate(__FILE__,$data,'board','toplist');