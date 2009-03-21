<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$options = cs_sql_option(__FILE__, 'board');

include_once 'mods/board/repair.php';
require('mods/categories/functions.php'); 
$data = array();

$cs_usertime = cs_sql_select(__FILE__, 'users', 'users_readtime', "users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];
cs_sql_query(__FILE__, "DELETE FROM {pre}_read WHERE users_id = '" . $account['users_id'] . "' AND read_since < '" . $cs_readtime . "'");

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
  $from = "board boa LEFT JOIN {pre}_members mem ON boa.squads_id = mem.squads_id AND mem.users_id = " . $account['users_id'];
  $select = 'boa.board_id AS board_id, boa.board_name AS board_name, boa.board_text AS board_text, boa.board_pwd AS board_pwd, boa.board_threads AS board_threads, boa.board_comments AS board_comments, boa.board_access AS board_access';
  $where = "categories_id = '" . $data['categories'][$run_1]['categories_id'] . "' AND (board_access <= " . $account['access_board'] . " OR mem.users_id = " . $account['users_id'] . ")";
  $order = 'board_order ASC, board_name ASC';
  $data['categories'][$run_1]['board'] = cs_sql_select(__FILE__, $from, $select, $where, $order, 0, 0);
  
  if (empty($data['categories'][$run_1]['board']))
    $data['categories'][$run_1]['board'] = array();
    
  $data['categories'][$run_1]['blank'] = ''; 
  $data['categories'][$run_1]['iconwidth'] = 36; 
  for ($i = 0; $i < $data['categories'][$run_1]['layer']; $i++) { 
     $data['categories'][$run_1]['blank'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
     $data['categories'][$run_1]['iconwidth'] += 20; 
  }
  
  if ($data['categories'][$run_1]['layer'] == 0 || !empty($options['list_subforums'])) {
  	$data['categories'][$run_1]['if']['small_subforums'] = false;
	  $count_boards = count($data['categories'][$run_1]['board']);
	  
	  for ($run_2 = 0; $run_2 < $count_boards; $run_2++) {
	    $board = $data['categories'][$run_1]['board'][$run_2];
	    $board['listcat_url'] = cs_url('board', 'listcat', 'id=' . $board['board_id']);
	    
	    $tables = 'threads thr LEFT JOIN {pre}_users usr ON thr.threads_last_user = usr.users_id LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = ' . $account['users_id'];
	    $cells = 'thr.threads_id AS threads_id, thr.threads_last_user AS threads_last_user, thr.threads_time AS threads_time, thr.threads_headline AS threads_headline, thr.threads_last_time AS threads_last_time, thr.users_id AS users_id_2, usr.users_id AS users_id, usr.users_nick AS users_nick, red.read_since AS read_since';
	    $where = "thr.board_id = " . $board['board_id'];
	    $order = 'thr.threads_last_time DESC';
	    $thread = cs_sql_select(__FILE__, $tables, $cells, $where, $order);
	    
	    $check_pw = 1;
	    if (!empty($board['board_pwd'])) {
	      $pw_where = "users_id = " . $account['users_id'] . " AND board_id = " . $board['board_id'];
	      $check_pw = cs_sql_count(__FILE__, 'boardpws', $pw_where);
	    }
	    
	    if (empty($check_pw)) {
	      $icon = 'password';
	    } else {
	      $icon = 'board_read_';
	    }
	    
	    if (!empty($account['users_id']) and !empty($check_pw)) {
	      $tables = "threads thr LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND ";
	      $tables .= "red.users_id = " . $account['users_id'];
	      $condition = "thr.board_id = " . $board['board_id'] . " AND ";
	      $condition .= "threads_last_time > '" . $cs_readtime . "' AND ";
	      $condition .= "(red.threads_id IS NULL OR thr.threads_last_time > red.read_since) AND ";
	      $condition .= "thr.threads_ghost = 0";
	      $unread = cs_sql_select(__FILE__, $tables, 'thr.threads_id', $condition);
	      if (isset($unread['threads_id'])) {
	        $icon = 'board_unread_';
	      }
	    }
	    
	    $board['icon'] = cs_html_img('symbols/board/' . $icon . '.png');
	    $board['board_text'] = cs_secure($board['board_text'], 1);
	    
	    if (!empty($thread['threads_id']) and !empty($check_pw)) {
	      $board['board_topics'] = cs_board_threads($board['board_id']);
	      $board['board_comments'] = cs_board_comments($board['board_id']);
	      $board['last_name'] = cs_secure($thread['threads_headline']);
	      $board['last_id'] = $thread['threads_id'];
	      
	      if (empty($thread['threads_last_time'])) {
	        $board['last_time'] = cs_date('unix', $thread['threads_time'], 1);
	      } else {
	        $board['last_time'] = cs_date('unix', $thread['threads_last_time'], 1);
	      }
	      
	      if (empty($thread['threads_last_user'])) {
	        $user = cs_sql_select(__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', 'users_id = ' . $thread['users_id_2']);
	        $board['last_usernick'] = cs_user($user['users_id'], $user['users_nick'], $user['users_active'], $user['users_delete']);
	      } else {
	        $user = cs_sql_select(__FILE__, 'users', 'users_id, users_nick, users_active, users_delete', 'users_id = ' . $thread['threads_last_user']);
	        $board['last_usernick'] = cs_user($user['users_id'], $user['users_nick'], $user['users_active'], $user['users_delete']);
	      }
	      
	      $board['last_userid'] = $thread['users_id'];
	      $board['of'] = $cs_lang['of'];
	    } else {
	      $board['board_topics'] = '-';
	      $board['board_comments'] = '-';
	      $board['last_name'] = '';
	      $board['last_id'] = '';
	      $board['last_time'] = '';
	      $board['last_usernick'] = '';
	      $board['last_userid'] = '';
	      $board['of'] = '';
	    }
	    $board['last_url'] = cs_url('board', 'thread', 'where=' . $board['last_id']);
	    $board['user_url'] = cs_url('users', 'view', 'id=' . $board['last_userid']);
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
    	$data['categories'][$run_1]['subboard'][$j][','] = $j != $count_boards_less ? ', ' : '';
    }
  }
}

$data['head']['message'] = cs_getmsg();
echo cs_subtemplate(__FILE__, $data, 'board', 'list',1);
?>