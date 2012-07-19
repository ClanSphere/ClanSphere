<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$posts   = 10;
$threads = 10;

include 'mods/board/functions.php';

$cs_lang = cs_translate('board');

$user_id = $_GET['id'];
settype($user_id,'integer');
$board_access = $account['access_board'];

$where = "users_id = '" . $user_id . "'";
$board_count = cs_sql_count(__FILE__,'board',$where);
$cs_user = cs_sql_select(__FILE__,'users','users_nick, users_register, users_active, users_delete',"users_id = '" . $user_id . "'");

$userposts = getUserPosts($user_id);

$data['users']['addons'] = cs_addons('users','view',$user_id,'board');

$cs_ranks = cs_sql_select(__FILE__,'boardranks','boardranks_min, boardranks_name',0,'boardranks_min ASC',0,0);

$data['count']['com'] = $userposts;
$since = cs_time() - $cs_user['users_register'];
$since = $since <= 86400 ? 1 : $since / 86400;
$posts_per_day = $userposts / $since;
$data['count_com']['per_day'] = round($posts_per_day,2) . $cs_lang['posts_per_day'];

$data['count']['rank'] = cs_secure(getRankTitle($userposts, $cs_ranks));

$data['last']['com'] = sprintf($cs_lang['last_com'], $posts);
$data['last']['thr'] = sprintf($cs_lang['last_thr'], $threads);

$from  = 'comments cms INNER JOIN {pre}_threads thr ON cms.comments_fid = thr.threads_id ';
$from .= 'INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id ';
$from .= 'INNER JOIN {pre}_categories cat ON cat.categories_id = frm.categories_id';

$select  = 'DISTINCT thr.threads_id AS threads_id, cat.categories_name AS categories_name, ';
$select .= 'cat.categories_id AS categories_id, frm.board_name AS board_name, frm.board_id AS board_id, ';
$select .= 'thr.threads_headline AS threads_headline, thr.threads_last_time AS threads_last_time, ';
$select .= 'thr.threads_last_user AS threads_last_user, cms.comments_time AS comments_time';
$where   = 'cms.users_id = \''.$user_id.'\' AND frm.board_access <= \''.$board_access.'\' AND frm.board_pwd = \'\'';
$where  .= ' AND cms.comments_mod = \'board\'';
$order = 'cms.comments_time DESC';
$cs_comments = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$posts);
$comments_loop = count($cs_comments);

if(empty($comments_loop)) {
  $data['com'] = '';
}

for($run=0; $run < $comments_loop; $run++) {
  $last[1] = $cs_comments[$run]['threads_last_user'];

  $data['com'][$run]['cat'] = $cs_comments[$run]['categories_name'];
  $data['com'][$run]['cat_link'] = cs_url('board','list','where=' . $cs_comments[$run]['categories_id']);
  $data['com'][$run]['board'] = $cs_comments[$run]['board_name'];
  $data['com'][$run]['board_link'] = cs_url('board','listcat','where=' . $cs_comments[$run]['board_id']);
  $data['com'][$run]['thread'] = getReducedTitle($cs_comments[$run]['threads_headline'],40);
  $data['com'][$run]['thread_link'] = cs_url('board','thread','where=' . $cs_comments[$run]['threads_id']);
  $data['com'][$run]['date'] = cs_date('unix',$cs_comments[$run]['comments_time'],1);
}

$from  = 'threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id';
$from .= ' INNER JOIN {pre}_categories cat ON cat.categories_id = frm.categories_id';
$select  = 'cat.categories_name AS categories_name, cat.categories_id AS categories_id,';
$select .= ' frm.board_name AS board_name, frm.board_id AS board_id,';
$select .= ' thr.threads_headline AS threads_headline, thr.threads_time AS threads_time, thr.threads_id AS threads_id';
$where = "frm.board_access <= '" . $board_access . "' AND thr.users_id = '" . $user_id . "' AND frm.board_pwd = ''";
$order = 'thr.threads_time DESC';
$cs_threads = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$threads);
$threads_loop = count($cs_threads);

if(empty($threads_loop)) {
  $data['thr'] = '';
}

for($run=0; $run<$threads_loop; $run++) {
  $data['thr'][$run]['cat'] = $cs_threads[$run]['categories_name'];
  $data['thr'][$run]['cat_link'] = cs_url('board','list','where=' . $cs_threads[$run]['categories_id']);
  $data['thr'][$run]['board'] = $cs_threads[$run]['board_name'];
  $data['thr'][$run]['board_link'] = cs_url('board','listcat','where=' . $cs_threads[$run]['board_id']);
  $data['thr'][$run]['thread'] = getReducedTitle($cs_threads[$run]['threads_headline'],40);
  $data['thr'][$run]['thread_link'] = cs_url('board','thread','where=' . $cs_threads[$run]['threads_id']);
  $data['thr'][$run]['date'] = cs_date('unix',$cs_threads[$run]['threads_time'],1);
}

echo cs_subtemplate(__FILE__,$data,'board','users');