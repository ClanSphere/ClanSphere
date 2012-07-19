<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$board_id = empty($_GET['id']) ? 0 : (int) $_GET['id'];

$cs_readtime = cs_time() - $account['users_readtime'];

# update alreay read threads with new time
$cells = 'rea.read_id AS read_id, rea.threads_id, rea.users_id, thr.threads_last_time';
$from = 'read rea INNER JOIN {pre}_threads thr ON rea.threads_id = thr.threads_id';
$where = "rea.users_id = " . (int) $account['users_id'] . " AND thr.threads_last_time > " . (int) $cs_readtime;

if(!empty($board_id)) {
  $cells .= ', thr.board_id';
  $where = "thr.board_id = " . (int) $board_id . " AND " . $where;
}

$readed = cs_sql_select(__FILE__, $from, $cells, $where, 0, 0, 0);

$read_cells = array('read_since');
$read_save = array(cs_time());

if(!empty($readed)) {
foreach($readed AS $readme)
  cs_sql_update(__FILE__, 'read', $read_cells, $read_save, $readme['read_id'], 0, 0);
}

# add threads that are not read at all
$cells = 'thr.threads_id AS threads_id, thr.threads_last_time, rea.users_id AS users_id';
$from = 'threads thr LEFT JOIN {pre}_read rea ON (thr.threads_id = rea.threads_id AND rea.users_id = ' . (int) $account['users_id'] . ')';
$where = "thr.threads_last_time > " . (int) $cs_readtime;

if(!empty($board_id)) {
  $cells .= ', thr.board_id';
  $where = "thr.board_id = " . (int) $board_id . " AND " . $where;
}

$readed = cs_sql_select(__FILE__, $from, $cells, $where, 0, 0, 0);

$read_cells = array('read_since', 'users_id', 'threads_id');

if(!empty($readed)) {
  foreach($readed AS $readme) {
    if(empty($readme['users_id'])) {
      $read_save = array(cs_time(), $account['users_id'], $readme['threads_id']);
      cs_sql_insert(__FILE__, 'read', $read_cells, $read_save);
    }
  }
}

# redirect
if(empty($board_id))
    cs_redirect($cs_lang['mark_all'], 'board', 'list');
else
  cs_redirect($cs_lang['mark_board'], 'board', 'listcat', 'id=' . $board_id);