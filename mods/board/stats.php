<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$d = array();

$d['stats']['topics'] = cs_sql_count(__FILE__,'threads');
$d['stats']['posts'] = cs_sql_count(__FILE__,'comments','comments_mod = \'board\'');
$d['stats']['users'] = cs_sql_count(__FILE__,'users');
$d['stats']['users_active'] = cs_sql_count(__FILE__,'comments cms RIGHT JOIN {pre}_users usr ON cms.users_id = usr.users_id AND usr.users_active = \'1\' RIGHT JOIN {pre}_threads thr ON thr.users_id = usr.users_id',0,'usr.users_id');
$d['stats']['categories'] = cs_sql_count(__FILE__,'categories','categories_mod = \'board\'');
$d['stats']['boards'] = cs_sql_count(__FILE__,'board');

$tables = 'comments cms LEFT JOIN {pre}_users usr ON cms.users_id = usr.users_id AND usr.users_active = \'1\' LEFT JOIN {pre}_threads thr ON thr.users_id = usr.users_id GROUP BY usr.users_id, usr.users_nick';
$cells = 'usr.users_id AS users_id, usr.users_nick AS users_nick, COUNT(DISTINCT cms.comments_id) + COUNT(DISTINCT thr.threads_id) AS comments'; 
$select = cs_sql_select(__FILE__,$tables,$cells,0,'comments DESC, usr.users_nick',0,3);
$d['stats']['toplist'] = '';
if (!empty($select)) {
	foreach ($select AS $user) {
	  $d['stats']['toplist'] .= cs_user($user['users_id'],$user['users_nick']);
	  $d['stats']['toplist'] .= ' (' . $user['comments'] . ' ' . $cs_lang['posts'] . '), ';
	}
	$d['stats']['toplist'] = substr($d['stats']['toplist'],0,-2);
}
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

$d['stats']['average_posts'] = !empty($d['stats']['posts']) ? round($d['stats']['topics'] / $d['stats']['posts'],2) : 0;
/*
$tables = 'comments cms LEFT JOIN {pre}_users usr ON cms.users_id = usr.users_id GROUP BY usr.users_id';
$cells = 'usr.users_nick AS users_nick, usr.users_id AS users_id, COUNT(cms.comments_id) AS smileys';
$cond = 'cms.comments_text LIKE \'%:)%\'';
$select = cs_sql_select(__FILE__,$tables,$cells,$cond,'smileys DESC');*/

echo cs_subtemplate(__FILE__,$d,'board','stats');


?>