<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$options = cs_sql_option(__FILE__, 'board');

require 'mods/categories/functions.php';
require_once 'mods/board/functions.php';
 
$data = array();

$unread_array = array();

if(!empty($account['users_id'])) {

  # clear old read data that is no longer needed for checks
  $cs_usertime = cs_sql_select(__FILE__, 'users', 'users_readtime', "users_id = '" . $account["users_id"] . "'");
  $cs_readtime = cs_time() - $cs_usertime['users_readtime'];
  cs_sql_query(__FILE__, "DELETE FROM {pre}_read WHERE users_id = '" . $account['users_id'] . "' AND read_since < '" . $cs_readtime . "'");

  # fetch unread threads grouped per board for later checks
  $tables = 'threads thr LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = ' . $account['users_id'];
  $needed = "thr.threads_last_time > '" . $cs_readtime . "' AND (red.threads_id IS NULL OR thr.threads_last_time > red.read_since)" .
          ' AND thr.threads_ghost = 0 GROUP BY thr.board_id';
  $values = 'thr.board_id AS board_id';
  $unread = cs_sql_select(__FILE__, $tables, $values, $needed, 0, 0, 0);
  $unread = is_array($unread) ? $unread : array();
  foreach($unread AS $untop => $unboard) {
    $unread_array['' . $unboard['board_id'] . ''] = 0;
  }
}

$categories_id = empty($_GET['id']) ? 0 : (int)$_GET['id'];

$where = "categories_mod = 'board' AND categories_access <= " . $account['access_board'];
$select = 'categories_name, categories_id, categories_subid';
$order = 'categories_subid ASC, categories_order ASC, categories_name ASC';
$data['categories'] = cs_catsort( cs_sql_select(__FILE__, 'categories', $select, $where, $order, 0, 0), $categories_id);
$count_categories = empty($data['categories']) ? 0 : count($data['categories']); 

$data['if']['category'] = empty($categories_id) ? false : true;

$data['category']['name'] = !empty($categories_id) ? $data['categories'][0]['categories_name'] : '';

for ($run_1 = 0; $run_1 < $count_categories; $run_1++) {

  $data['categories'][$run_1]['list_url'] = cs_url('board', 'list', 'id=' . $data['categories'][$run_1]['categories_id']);

  $from = "board boa LEFT JOIN {pre}_read red ON boa.board_last_threadid = red.threads_id AND red.users_id = " . $account['users_id'] .
          " LEFT JOIN {pre}_members mem ON boa.squads_id = mem.squads_id AND mem.users_id = " . $account['users_id'];
  $select = 'boa.board_id AS board_id, boa.board_name AS board_name, boa.board_text AS board_text, boa.board_pwd AS board_pwd, ' .
            'boa.board_threads AS board_threads, boa.board_comments AS board_comments, boa.board_access AS board_access,' .
            'boa.board_last_time AS board_last_time, boa.board_last_user AS board_last_user, boa.board_last_userid AS board_last_userid,' . 
            'boa.board_last_thread AS board_last_thread, boa.board_last_threadid AS board_last_threadid, red.read_since AS read_since';
  $where = "categories_id = '" . $data['categories'][$run_1]['categories_id'] . "' AND (board_access <= " .
           $account['access_board'] . " OR mem.users_id = " . $account['users_id'] . ")";
  $order = 'board_order ASC, board_name ASC';

  $data['categories'][$run_1]['board'] = cs_sql_select(__FILE__, $from, $select, $where, $order, 0, 0);

  if (empty($data['categories'][$run_1]['board']))
    $data['categories'][$run_1]['board'] = array();

  $data['categories'][$run_1]['blank'] = ''; 
  $data['categories'][$run_1]['iconwidth'] = 36; 
  for ($i = 0; $i < $data['categories'][$run_1]['layer']; $i++) {
    $data['categories'][$run_1]['blank'] .= '&nbsp;&nbsp;&nbsp;&raquo; '; 
    $data['categories'][$run_1]['iconwidth'] += 20; 
  }
  
  if ($data['categories'][$run_1]['layer'] == 0 || !empty($options['list_subforums'])) {
    $data['categories'][$run_1]['if']['small_subforums'] = false;
    $count_boards = count($data['categories'][$run_1]['board']);

    for ($run_2 = 0; $run_2 < $count_boards; $run_2++) {
      $board = $data['categories'][$run_1]['board'][$run_2];
      $board['listcat_url'] = cs_url('board', 'listcat', 'id=' . $board['board_id']);

      $check_pw = 1;
      if (!empty($board['board_pwd'])) {
        $pw_where = 'users_id = "' . $account['users_id'] . '" AND board_id = "' . $board['board_id'] . '"';
        $check_pw = cs_sql_count(__FILE__, 'boardpws', $pw_where);
      }

      if (empty($check_pw)) {
        $icon = 'password';
      } else {
        $icon = 'board_read_';
      }

      if (!empty($check_pw)) {
        if (isset($unread_array['' . $board['board_id'] . ''])) {
          $icon = 'board_unread_';
        }
      }

      $board['icon'] = cs_html_img('symbols/board/' . $icon . '.png');
      $board['board_text'] = cs_secure($board['board_text'], 1);

      # new - set board_last_* content if empty
      if(empty($board['board_last_threadid']) AND !empty($board['board_threads'])) {
        include_once 'mods/board/repair.php';
        $new = cs_board_last($board['board_id']);
        $board = is_array($new) ? array_merge($board, $new) : $board;
      }

      if(!empty($board['board_last_threadid']) and !empty($check_pw)) {
        $board['last_name'] = cs_secure($board['board_last_thread']);
        $board['board_last_id'] = $board['board_last_threadid'];

        if (empty($board['board_last_time']))
          $board['last_time'] = '';
        else
          $board['last_time'] = cs_date('unix', $board['board_last_time'], 1);

        if (empty($board['board_last_userid']))
          $board['last_usernick'] = empty($board['board_last_user']) ? '-' : cs_secure($board['board_last_user']);
        else
          $board['last_usernick'] = cs_user($board['board_last_userid'], $board['board_last_user']);

        $board['of'] = $cs_lang['of'];
      }
      else {
        if(empty($check_pw)) {
          $board['board_threads'] = '-';
          $board['board_comments'] = '-';
        }
        $board['last_name'] = '';
        $board['board_last_id'] = '';
        $board['last_time'] = '';
        $board['last_usernick'] = '';
        $board['board_last_userid'] = '';
        $board['of'] = '';
      }

      $board['last_url'] = cs_url('board', 'thread', 'where=' . $board['board_last_threadid'] . '&amp;start=' . last_comment($board['board_last_threadid'], $account["users_id"], $account['users_limit']));
      $board['user_url'] = cs_url('users', 'view', 'id=' . $board['board_last_userid']);
      $board['board_name'] = cs_secure($board['board_name']);
    
      
      $data['categories'][$run_1]['board'][$run_2] = $board;
    }
  } else {
    $data['categories'][$run_1]['subboard'] = $data['categories'][$run_1]['board'];
    $data['categories'][$run_1]['board'] = array();
    $data['categories'][$run_1]['if']['small_subforums'] = true;
    $count_boards = count($data['categories'][$run_1]['subboard']);
    $count_boards_less = $count_boards - 1;
    
    for ($j = 0; $j < $count_boards; $j++) {
      $data['categories'][$run_1]['subboard'][$j]['comma'] = $j != $count_boards_less ? ', ' : '';
    }
  }
}

$data['head']['message'] = cs_getmsg();

echo cs_subtemplate(__FILE__, $data, 'board', 'list',1);