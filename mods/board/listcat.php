<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

require_once 'mods/board/functions.php';

$zugriff = 1;
$check_pw = 1;
$check_sq = 0;

$board_id = empty($_REQUEST['id']) ? 0 : (int) $_REQUEST['id'];
if(!empty($_REQUEST['where']))
  $board_id = (int) $_REQUEST['where']; 

$cs_usertime = cs_sql_select(__FILE__, 'users', 'users_readtime', "users_id = " . $account["users_id"]);
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];

$where = "boa.board_id = " . $board_id;
$select = 'cat.categories_name AS categories_name, cat.categories_id AS categories_id, boa.board_id AS board_id, boa.board_name AS board_name, boa.board_pwd AS board_pwd, boa.board_threads AS board_threads, boa.board_access AS board_access, boa.squads_id AS squads_id, boa.board_read AS board_read';
$from = 'board boa INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id';
$cs_board = cs_sql_select(__FILE__, $from, $select, $where);

$data = array();
$data['count']['topics'] = 0;
$data['pages']['list'] = '';
$data['link']['board'] = cs_url('board', 'list');
$data['link']['name'] = cs_url('board', 'list', 'id=' . $cs_board['categories_id']);
$data['categories']['name'] = $cs_board['categories_name'];
$data['board']['name'] = cs_secure($cs_board['board_name']);
$data['link']['newthread'] = cs_url('board', 'thread_add', 'id=' . $cs_board['board_id']);
$data['link']['mark_board'] = cs_url('board', 'mark', 'id=' . $board_id);
if(!empty($cs_board['board_read']) AND $account['access_board'] < 5) { $data['if']['newthread'] = false; } else { $data['if']['newthread'] = true; }

if (!empty($cs_board['squads_id']) and $account['access_board'] < $cs_board['board_access']) {
  $sq_where = "users_id = " . $account['users_id'] . " AND squads_id = " . $cs_board['squads_id'];
  $check_sq = cs_sql_count(__FILE__, 'members', $sq_where);
}

if (empty($cs_board['board_name']) or $account['access_board'] < $cs_board['board_access'] and empty($check_sq)) {

  echo cs_subtemplate(__FILE__, $data, 'board', 'no_board');
  
  return 0;
  $zugriff = 0;
} elseif (!empty($cs_board['board_pwd'])) {
  $where = "users_id = " . $account['users_id'] . " AND board_id = " . $cs_board['board_id'];
  $check_pw = cs_sql_count(__FILE__, 'boardpws', $where);
  
  if(empty($check_pw) AND empty($account['users_id'])) {
    cs_redirect('', 'users', 'login');
  }
  elseif(empty($check_pw)) {
    global $cs_db;
    $sec_pw = isset($_POST['sec_pw']) ? $_POST['sec_pw'] : 0;
    
    if ($cs_db['hash'] == 'md5') {
      $sec_pw = md5($sec_pw);
    } elseif ($cs_db['hash'] == 'sha1') {
      $sec_pw = sha1($sec_pw);
    }
    
    if ($sec_pw == $cs_board['board_pwd'] and !empty($account['users_id'])) {
      $board_cells = array('users_id', 'board_id');
      $board_save = array($account['users_id'], $cs_board['board_id']);
      cs_sql_insert(__FILE__, 'boardpws', $board_cells, $board_save);
      $check_pw = 1;
    } else {
      $data['action']['form'] = cs_url('board', 'listcat', 'where=' . $cs_board['board_id']);
      
      $text = isset($_POST['submit']) ? $cs_lang['wrong_pwd'] : $cs_lang['need_pwd'];
      $data['pw']['body'] = $text;
      $data['pw']['id'] = $cs_board['board_id'];
      
      echo cs_subtemplate(__FILE__, $data, 'board', 'password');
    }
  }
}

if (!empty($cs_board['board_name']) and !empty($check_pw)) {
  $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
  
  $data['count']['topics'] = $cs_board['board_threads'];
  $data['pages']['list'] = cs_pages('board', 'listcat', $cs_board['board_threads'], $start, $cs_board['board_id']);
  
  $from = "threads thr LEFT JOIN {pre}_users usr ON thr.threads_last_user = usr.users_id  LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = " . $account['users_id'];
  $select = 'thr.threads_id AS threads_id, thr.threads_headline AS threads_headline, thr.threads_view AS threads_view, thr.threads_comments AS threads_comments, thr.threads_important AS threads_important, thr.threads_close AS threads_close, thr.threads_last_time AS threads_last_time, thr.threads_time AS threads_time, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, red.read_since AS read_since, thr.users_id AS starter_id, thr.threads_ghost AS threads_ghost, thr.threads_ghost_board AS threads_ghost_board, thr.threads_ghost_thread AS threads_ghost_thread';
  $where = "thr.board_id = " . $cs_board['board_id'];
  $order = 'thr.threads_important DESC, thr.threads_last_time DESC';
  $cs_threads = cs_sql_select(__FILE__, $from, $select, $where, $order, $start, $account['users_limit']);
  
  if (empty($cs_threads)) {
    $data['lang']['no_board'] = $cs_lang['no_threads'];
    echo cs_subtemplate(__FILE__, $data, 'board', 'no_board');
  } else {
    $run = 0;
    foreach ($cs_threads as $thread) {
      if (empty($thread['threads_comments'])) {
        include_once('mods/board/repair.php');
        $thread['threads_comments'] = cs_threads_comments($thread['threads_id']);
      }
      
      $icon = 'post_';
      $tid = $thread['threads_id'];
      
      if (!empty($account['users_id']) and $thread['threads_last_time'] > $cs_readtime and $thread['threads_last_time'] > $thread['read_since'])
        $icon .= 'unread_';
      
      if (!empty($thread['threads_close']))
        $icon .= 'close_';
      if ($thread['threads_important'])
        $icon .= 'important_';
      if (!empty($thread['threads_ghost'])) {
        $icon = 'post_';
      }
      
      $data['threads'][$run]['icon'] = cs_html_img('symbols/board/' . $icon . '.png');
      
      
      if (!empty($thread['threads_important'])) {
        $data['threads'][$run]['important'] = $cs_lang['important'] . ' ';
      } else {
        $data['threads'][$run]['important'] = '';
      }
      
      $headline = cs_secure($thread['threads_headline']);
      
      if (!empty($thread['threads_ghost'])) {
        $data['threads'][$run]['headline'] = $headline;
    $data['threads'][$run]['headline'] .= ' ' . cs_link(cs_icon('cancel'),'board','thread_remove','id=' . $thread['threads_id']);
        $data['threads'][$run]['ghost_thread'] = cs_html_br(2);
    $data['threads'][$run]['ghost_thread'] .= cs_link($cs_lang['ghost_topic'], 'board', 'thread', 'where=' . $thread['threads_ghost_thread']);
        $data['threads'][$run]['ghost_board'] = ' - ' . cs_link($cs_lang['ghost_board'], 'board', 'listcat', 'id=' . $thread['threads_ghost_board']);
      } else {
        $data['threads'][$run]['headline'] = cs_link($headline, 'board', 'thread', 'where=' . $thread['threads_id'] . '&amp;start=' . last_comment($thread['threads_id'], $account["users_id"], $account['users_limit']));
        $data['threads'][$run]['ghost_thread'] = '';
        $data['threads'][$run]['ghost_board'] = '';
      }
      
      
      $check_file = cs_sql_count(__FILE__, 'boardfiles', 'threads_id = ' . $thread['threads_id']);
      
      if (!empty($check_file)) {
        $data['threads'][$run]['attach'] = cs_icon('attach');
      } else {
        $data['threads'][$run]['attach'] = '';
      }
      
      if ($account['access_board'] >= 4) {
        $check_rp = cs_sql_count(__FILE__, 'boardreport', 'boardreport_done = 0 AND threads_id = ' . $thread['threads_id']);
        if (!empty($check_rp)) {
          $data['threads'][$run]['report'] = cs_icon('special_paste', 16, $cs_lang['report']);
        } else {
          $data['threads'][$run]['report'] = '';
        }
      } else {
        $data['threads'][$run]['report'] = '';
      }
      
      if (!empty($thread['starter_id'])) {
        $thread_starter = cs_sql_select(__FILE__, 'users', 'users_nick, users_active, users_delete', 'users_id = ' . $thread['starter_id'], 0, 0, 1);
        $data['threads'][$run]['user'] = cs_user($thread['starter_id'],$thread_starter['users_nick'], $thread_starter['users_active'], $thread_starter['users_delete']);
      } else {
        $data['threads'][$run]['user'] = '';
      }
      
      if ($thread['threads_comments'] > $account['users_limit']) {
        $data['threads'][$run]['page'] = cs_html_br(1);
        $data['threads'][$run]['page'] .= cs_pages('board', 'thread', $thread['threads_comments'], 0, $thread['threads_id'], 0, 0, 1);
      } else {
        $data['threads'][$run]['page'] = '';
      }
      
      $data['threads'][$run]['comments'] = $thread['threads_comments'];
      $data['threads'][$run]['view'] = $thread['threads_view'];
      
      
      if (!empty($thread['threads_last_time'])) {
        $date = cs_date('unix', $thread['threads_last_time'], 1);
        $goto = floor($thread['threads_comments'] / $account['users_limit']) * $account['users_limit'];
        $goto .= '#' . $thread['threads_comments'];
        
        $data['threads'][$run]['date'] = $date;
        
        if (!empty($thread['users_id'])) {
          $data['threads'][$run]['from'] = $cs_lang['from'];
          $data['threads'][$run]['user_name'] = cs_user($thread['users_id'], $thread['users_nick'], $thread['users_active'], $thread['users_delete']);
        } else {
          $data['threads'][$run]['from'] = '';
          $data['threads'][$run]['user_name'] = '';
          $data['threads'][$run]['user_link'] = '';
        }
      } else {
        $data['threads'][$run]['date'] = cs_date('unix', $thread['threads_time'], 1);
        $data['threads'][$run]['from'] = '';
        $data['threads'][$run]['user_name'] = '';
        $data['threads'][$run]['user_link'] = '';
      }
      $run++;
    }
    
	$data['head']['message'] = cs_getmsg();
	
    echo cs_subtemplate(__FILE__, $data, 'board', 'listcat',1);
  }
}