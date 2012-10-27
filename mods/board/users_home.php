<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once 'mods/board/functions.php';

$data = array();

$cs_homelimit = cs_sql_select(__FILE__,'users','users_homelimit, users_readtime',"users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_homelimit['users_readtime'];
cs_sql_query(__FILE__, "DELETE FROM {pre}_read WHERE users_id = '" . $account['users_id'] . "' AND read_since < '" . $cs_readtime . "'");

$from  = "threads thr " .
         "INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id " . 
         "INNER JOIN {pre}_categories cat ON cat.categories_id = frm.categories_id " .
         "INNER JOIN {pre}_users usr ON thr.threads_last_user = usr.users_id " .
         "LEFT JOIN {pre}_members mem ON frm.squads_id = mem.squads_id AND mem.users_id = '" . $account['users_id'] . "' " .
         "LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = '" . $account['users_id'] . "'";

$where = "(frm.board_access <= '" . $account['access_board'] . "' OR mem.users_id = '" . $account['users_id'] . "') AND frm.board_pwd = '' AND thr.threads_last_time > '" . $cs_readtime . "' AND (thr.threads_last_time > red.read_since OR red.threads_id IS NULL)";

$select  = 'cat.categories_name AS categories_name, cat.categories_id AS categories_id, frm.board_name AS board_name, frm.board_id AS board_id, thr.threads_headline AS threads_headline, thr.threads_last_time AS threads_last_time, thr.threads_comments AS threads_comments, thr.threads_id AS threads_id, usr.users_nick AS users_nick, usr.users_id AS users_id, usr.users_active AS users_active, usr.users_delete AS users_delete';

$order = 'thr.threads_last_time DESC'; 
$data['threads'] = cs_sql_select(__FILE__,$from,$select,$where,$order,0,$cs_homelimit['users_homelimit']);

if (!empty($data['threads'])) {

  $count_threads = count($data['threads']);

  for ($run = 0; $run < $count_threads; $run++) {
    $data['threads'][$run]['threads_last_time'] = !empty($data['threads'][$run]['threads_last_time']) ? cs_date('unix',$data['threads'][$run]['threads_last_time'],1) : '';
    $data['threads'][$run]['pages'] = $data['threads'][$run]['threads_comments'] <= $account['users_limit'] ? '' : cs_html_br(1) . cs_pages('board','thread',$data['threads'][$run]['threads_comments'],0,$data['threads'][$run]['threads_id'],0,0,1);
    $data['threads'][$run]['users_nick'] = !empty($data['threads'][$run]['users_nick']) ? cs_html_br(1) . $cs_lang['from'] . ' ' . cs_user($data['threads'][$run]['users_id'],$data['threads'][$run]['users_nick'],$data['threads'][$run]['users_active'],$data['threads'][$run]['users_delete']) : '';
    $data['threads'][$run]['new_posts'] = last_comment($data['threads'][$run]['threads_id'], $account['users_id'], $account['users_limit']);
  }
  echo cs_subtemplate(__FILE__,$data,'board','users_home');
}