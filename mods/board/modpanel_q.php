<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$thread_error = 2; 
$thread_form = 1;

$thread_id = empty($_GET['id']) ? 0 : $_GET['id']; 

settype($thread_id,'integer');

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$from .= 'INNER JOIN {pre}_users usr ON thr.users_id = usr.users_id ';
$from .= 'INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'thr.threads_headline AS threads_headline, frm.board_name AS board_name, cat.categories_name AS categories_name, thr.threads_id AS threads_id, frm.board_id AS board_id, frm.board_threads AS board_threads, cat.categories_id AS categories_id, frm.board_access AS board_access, thr.threads_important AS threads_important, thr.threads_close AS threads_close, thr.threads_time AS threads_time, thr.threads_last_time AS threads_last_time, usr.users_nick AS users_nick, usr.users_id AS users_id';
$where = 'threads_id = ' . (int) $thread_id;
$thread_edit = cs_sql_select(__FILE__,$from,$select,$where);
$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_modpanel',"users_id = '" . $account['users_id'] . "'",0,0,1);
$thread_headline = $thread_edit['threads_headline'];
$board_id = $thread_edit['board_id'];
require_once('mods/board/functions.php');
//Sicherheitsabfrage
if($account['access_board'] < $thread_edit['board_access'])
  return errorPage('modpanel_q', $cs_lang);          
if($account['access_board'] < 5 AND empty($thread_mods['boardmods_modpanel']))
  return errorPage('modpanel_q', $cs_lang);   
//Sicherheitsabfarge Ende

//Daten Abfragen
if(isset($_POST['close'])) {
  $thread_cells = array('threads_close');
  $thread_save = array($account['users_id']);
  $action_lang = $cs_lang['action_close'];

} elseif(!empty($_POST['open'])) {
  $thread_cells = array('threads_close');
  $thread_save = array(0);
  $action_lang = $cs_lang['action_open'];

} elseif(!empty($_POST['addpin'])) {
  $thread_cells = array('threads_important');
  $thread_save = array(1);
  $action_lang = $cs_lang['action_addpin'];

} elseif(!empty($_POST['delpin'])) {
  $thread_cells = array('threads_important');
  $thread_save = array(0);
  $action_lang = $cs_lang['action_delpin'];

} elseif(!empty($_POST['submit_move'])) {       
  if(empty($_POST['board_id']) OR $_POST['board_id'] == $board_id) {
     return cs_redirect(NULL, 'board', 'thread', 'where=' . $thread_id);
  }
  if($_POST['ghost'] == '1') {
    $ghost['board_id'] = $thread_edit['board_id'];
    $ghost['threads_headline'] = $cs_lang['movedto'] . ' (' . $thread_edit['threads_headline'] . ')';
    $ghost['threads_close'] = $account['users_id'];
    $ghost['users_id'] = $thread_edit['users_id'];
    $ghost['threads_time'] = $thread_edit['threads_time'];
    $ghost['threads_last_time'] = $thread_edit['threads_last_time'];
    $ghost['threads_ghost'] = 1;
    $ghost['threads_ghost_board'] = $_POST['board_id'];
    $ghost['threads_ghost_thread'] = $thread_edit['threads_id'];
    $ghost_cells = array_keys($ghost);
    $ghost_save = array_values($ghost);
    $ghost_insert = cs_sql_insert(__FILE__,'threads',$ghost_cells,$ghost_save);  
  }
  $board_new_id = $_POST['board_id'];
  $thread_closed = !empty($_POST['thread_closed']) ? $account['users_id'] : 0;
//  echo $thread_closed;
  settype($board_new_id,'integer');
  settype($thread_closed,'integer');
  $thread_cells = array('board_id','threads_close');
  $thread_save = array($board_new_id,$thread_closed);
  $action_lang = $cs_lang['action_move'];

} elseif(!empty($_POST['submit_rename'])) {       
  if(empty($_POST['thread_headline'])) {
     return cs_redirect($cs_lang['mark_all'], 'board', 'thread', 'where=' . $thread_id);
  }
  $thread_headline = $_POST['thread_headline'];
  $thread_cells = array('threads_headline');
  $thread_save = array($thread_headline);
  $update_board = 1;
  $action_lang = $cs_lang['action_rename'];

} elseif(!empty($_POST['move']) OR !empty($_POST['rename'])) {
  
  $data['threads']['id'] = $thread_edit['threads_id'];

  $head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
  $head .= cs_link($thread_edit['categories_name'],'board','list','where=' .$thread_edit['categories_id'],'normalb') .' -> ';
  $head .= cs_link($thread_edit['board_name'],'board','listcat','where=' .$board_id,'normalb') .' -> ';
  $head .= cs_link($thread_edit['threads_headline'],'board','thread','where=' .$thread_edit['threads_id'],'normalb');
  
  $data['head']['links'] = $head;
  $data['if']['move'] = FALSE;
  $data['if']['rename'] = FALSE;

  //move
  if(!empty($_POST['move'])) {
  
    $data['if']['move'] = TRUE;

    $tables = "board boa INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id";
    $select = "boa.board_id AS board_id, boa.board_name AS board_name, cat.categories_name AS categories_name";
    $axx_where = "boa.board_access <= '" . $account['access_board'] . "'";
    $sorting = 'cat.categories_name ASC, boa.board_name ASC';
    $board_data = cs_sql_select(__FILE__,$tables,$select,$axx_where,$sorting,0,0);

    $data['board']['select'] = '';
    foreach($board_data AS $board) {
      $sel = $board_id == $board['board_id'] ? 1 : 0;
      $content = $board['categories_name'] . ' -> ' . $board['board_name'];
      $data['board']['select'] .= cs_html_option($content,$board['board_id'],$sel);
    }
    $data['checked']['closed']    =  empty($thread_edit['threads_close']) ? '' : 'checked="checked" ';
    $data['checked']['notclosed'] = !empty($thread_edit['threads_close']) ? '' : 'checked="checked" ';
  
  }

  //rename
  if(!empty($_POST['rename'])) {
  
    $data['if']['rename'] = TRUE;
    $data['val']['thread_headline'] = $thread_headline;
  }

 echo cs_subtemplate(__FILE__,$data,'board','modpanel_q');

} else {
   cs_redirect($cs_lang['mark_all'], 'board', 'thread', 'where=' . $thread_id);
}

//Daten verarbeiten und in SQL Eintragen   
if(!empty($thread_cells) AND !empty($thread_save)) {
  cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$thread_id);

  if (!empty($update_board)) {
    include_once('mods/board/repair.php');
    cs_board_last($board_id);
  }
  
  if(isset($board_new_id)) {
    //Update board entry to get correct threads and comments count

    include_once('mods/board/repair.php');
    cs_board_threads($board_id);
    cs_board_comments($board_id);
    cs_board_threads($board_new_id);
    cs_board_comments($board_new_id);
    cs_board_last($board_id);
  }
   cs_redirect($action_lang, 'board', 'thread', 'where=' . $thread_id);
}