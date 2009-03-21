<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

include 'mods/board/functions.php';

$fixit = 0;

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];
if (!empty($fixit)) $start++;

#$tables = 'comments cms INNER JOIN {pre}_users usr ON cms.users_id = usr.users_id GROUP BY cms.users_id';
#$tables = 'users usr LEFT JOIN {pre}_threads thr ON thr.users_id = usr.users_id LEFT JOIN {pre}_comments cms ON cms.users_id = usr.users_id GROUP BY usr.users_id';


#$tables = 'users usr LEFT JOIN {pre}_comments cms ON cms.users_id = usr.users_id LEFT JOIN {pre}_threads thr ON thr.users_id = usr.users_id GROUP BY usr.users_id';
#$tables = 'comments cms INNER JOIN {pre}_users usr ON cms.users_id = usr.users_id LEFT JOIN {pre}_threads thr ON thr.users_id = usr.users_id GROUP BY usr.users_id';
#$tables = 'threads thr LEFT JOIN {pre}_users usr ON thr.users_id = usr.users_id LEFT JOIN {pre}_comments cms ON cms.users_id = usr.users_id GROUP BY usr.users_id';
$tables = 'comments cms LEFT JOIN {pre}_users usr ON cms.users_id = usr.users_id LEFT JOIN {pre}_threads thr ON thr.users_id = usr.users_id GROUP BY usr.users_id, usr.users_nick';

$cells = 'usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_delete AS users_delete, usr.users_active AS users_active, COUNT(DISTINCT cms.comments_id) + COUNT(DISTINCT thr.threads_id) AS comments'; 

$select = cs_sql_select(__FILE__,$tables,$cells,0,'comments DESC, usr.users_nick',$start,$account['users_limit']);

$count = cs_sql_select(__FILE__,$tables,'COUNT(usr.users_id)',0,0,0,0);
$count = count($count);

$cs_ranks = cs_sql_select(__FILE__,'boardranks','boardranks_min, boardranks_name',0,'boardranks_min ASC',0,0);

$data['pages']['list'] = cs_pages('board','toplist',$count,$start);

$cs_users = $select;

if(empty($select)) {
  $data['toplist'] = '';
}

$x = empty($fixit) ? $start : $start - 1;
$count_users = count($cs_users);

for($run = 0; $run < $count_users; $run++) {
  if(!empty($cs_users[$run]['users_id']) AND $cs_users[$run]['users_active'] > 0 AND empty($cs_users[$run]['users_delete'])) {
    $x++;
    $data['toplist'][$run]['class'] = $class = $cs_users[$run]['users_id'] != $account['users_id'] ? 'leftb' : 'leftc';
    $data['toplist'][$run]['number'] = $run == 0 || $cs_users[$run]['comments'] != $cs_users[$run-1]['comments'] ? $x : $data['toplist'][$run-1]['number'];
    $data['toplist'][$run]['nick_link'] = cs_url('users','view','id=' . $cs_users[$run]['users_id']);
    $data['toplist'][$run]['nick'] = $cs_users[$run]['users_nick'];
    $data['toplist'][$run]['comments'] = $cs_users[$run]['comments'];
    $data['toplist'][$run]['rank'] = cs_secure(getRankTitle($cs_users[$run]['comments'], $cs_ranks));
  }
}

echo cs_subtemplate(__FILE__,$data,'board','toplist');
?>