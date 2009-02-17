<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$thread_error = 2; 
$thread_form = 1;
$thread_id = $_GET['id']; 

settype($thread_id,'integer');

$from = 'threads thr INNER JOIN {pre}_board frm ON thr.board_id = frm.board_id ';
$from .= 'INNER JOIN {pre}_users usr ON thr.users_id = usr.users_id ';
$from .= 'INNER JOIN {pre}_categories cat ON frm.categories_id = cat.categories_id';
$select = 'thr.threads_headline AS threads_headline, frm.board_name AS board_name, cat.categories_name AS categories_name, ';
$select .= 'thr.threads_id AS threads_id, frm.board_id AS board_id, frm.board_threads AS board_threads, cat.categories_id AS categories_id, frm.board_access AS board_access, thr.threads_important AS threads_important, thr.threads_close AS threads_close, thr.threads_last_time AS threads_last_time, usr.users_nick AS users_nick';
$where = "threads_id = '" . $thread_id . "'";
$thread_edit = cs_sql_select(__FILE__,$from,$select,$where);
$thread_mods = cs_sql_select(__FILE__,'boardmods','boardmods_modpanel',"users_id = '" . $account['users_id'] . "'",0,0,1);
$thread_headline = $thread_edit['threads_headline'];
$board_id = $thread_edit['board_id'];
require_once('mods/board/functions.php');
//Sicherheitsabfrage
if($account['access_board'] < $thread_edit['board_access'])
  return errorPage('modpanel_q');          
if($account['access_board'] < 5 AND empty($thread_mods['boardmods_modpanel']))
  return errorPage('modpanel_q');   
//Sicherheitsabfarge Ende

//Daten Abfragen
if(isset($_POST['close'])) {
  $thread_cells = array('threads_close');
  $thread_save = array($account['users_id']);

} elseif(isset($_POST['open'])) {
  $thread_cells = array('threads_close');
  $thread_save = array(0);

} elseif(isset($_POST['addpin'])) {
  $thread_cells = array('threads_important');
  $thread_save = array(1);

} elseif(isset($_POST['delpin'])) {
  $thread_cells = array('threads_important');
  $thread_save = array(0);

} elseif(isset($_POST['submit_move'])) {       
  if(empty($_POST['board_id']) OR $_POST['board_id'] == $board_id) {
    return header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' .$thread_id); 
  }
  if($_POST['ghost'] == '1') {
  $ghost['board_id'] = $thread_edit['board_id'];
  $ghost['threads_headline'] = $cs_lang['movedto'] . ' (' . $thread_edit['threads_headline'] . ')';
  $ghost['threads_close'] = 1;
  $ghost['users_id'] = $account['users_id'];
  $ghost['threads_last_time'] = $thread_edit['threads_last_time'];
  $ghost['threads_ghost'] = 1;
  $ghost['threads_ghost_board'] = $_POST['board_id'];
  $ghost['threads_ghost_thread'] = $thread_edit['threads_id'];
  $ghost_cells = array_keys($ghost);
  $ghost_save = array_values($ghost);
    $ghost_insert = cs_sql_insert(__FILE__,'threads',$ghost_cells,$ghost_save);  
  }
  $board_new_id = $_POST['board_id'];
  $thread_closed = !empty($_POST['threads_closed']) ? $account['users_id'] : 0;
  echo $thread_closed;
  settype($board_new_id,'integer');
  settype($thread_closed,'integer');
  $thread_cells = array('board_id','threads_close');
  $thread_save = array($board_new_id,$thread_closed);

} elseif(isset($_POST['submit_rename'])) {       
  if(empty($_POST['thread_headline'])) {
    return header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' .$thread_id);
  }
  $thread_headline = $_POST['thread_headline'];
  $thread_cells = array('threads_headline');
  $thread_save = array($thread_headline);

} elseif(isset($_POST['move']) OR isset($_POST['rename'])) {       
  echo cs_html_form(1,'thread_mod','board','modpanel_q',0,'id=' .$thread_edit['threads_id']);
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb',0,3);  
  echo $cs_lang['board'] .' - '. $cs_lang['mod3'];
  echo cs_html_roco(1,'leftc',0,3); 
  $head  = cs_link($cs_lang['board'],'board','list','normalb') .' -> ';
  $head .= cs_link($thread_edit['categories_name'],'board','list','where=' .$thread_edit['categories_id'],'normalb') .' -> ';
  $head .= cs_link($thread_edit['board_name'],'board','listcat','where=' .$board_id,'normalb') .' -> ';
  $head .= cs_link($thread_edit['threads_headline'],'board','thread','where=' .$thread_edit['threads_id'],'normalb');
  echo $head; 
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(1);
  echo cs_html_table(1,'forum',1);

  if(isset($_POST['move'])) {       
    echo cs_html_roco(1,'leftb',0,0,'20%');
    echo cs_icon('forward') . $cs_lang['move'];
      echo cs_html_roco(2,'leftb');   
    //Neu 
    $tables = "board boa INNER JOIN {pre}_categories cat ON boa.categories_id = cat.categories_id";
    $select = "boa.board_id AS board_id, boa.board_name AS board_name, cat.categories_name AS categories_name";
    $axx_where = "boa.board_access <= '" . $account['access_board'] . "'";
    $sorting = "cat.categories_name ASC, boa.board_name ASC";
    $board_data = cs_sql_select(__FILE__,$tables,$select,$axx_where,$sorting,0,0);
    echo cs_html_select(1,'board_id');
    foreach($board_data AS $board) {
      $sel = $board_id == $board['board_id'] ? 1 : 0;
    $content = $board['categories_name'] . ' -> ' . $board['board_name'];
         echo cs_html_option($content,$board['board_id'],$sel);
    }
    //Alt
    echo cs_html_roco(0); 
    
    echo cs_html_roco(1,'leftb');
    echo cs_icon('agt_reload') . $cs_lang['ghostlink'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('ghost',1,'radio') . $cs_lang['yes'];
    echo cs_html_input('ghost',0,'radio',0,0,'checked') . $cs_lang['no'];
    echo cs_html_roco(0);
    
      echo cs_html_roco(1,'leftb');
    echo cs_icon('lockoverlay') . $cs_lang['thread_close'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('threads_closed',1,'radio') . $cs_lang['yes'];
    echo cs_html_input('threads_closed',0,'radio',0,0,'checked') . $cs_lang['no'];
    echo cs_html_roco(0);
    
    echo cs_html_roco(1,'leftb',0,0,'20%');
      echo cs_icon('ksysguard') . $cs_lang['options'];
      echo cs_html_roco(2,'leftb');
      echo cs_html_vote('submit_move',$cs_lang['change'],'submit');
      echo cs_html_roco(0);   
  }

  if(isset($_POST['rename'])) {       
    echo cs_html_roco(1,'leftb',0,0,'20%');
    echo cs_icon('kate') . $cs_lang['rename'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_input('thread_headline',$thread_headline,'text',255,50);
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb',0,0,'20%');
    echo cs_icon('ksysguard') . $cs_lang['options'];
    echo cs_html_roco(2,'leftb');
    echo cs_html_vote('submit_rename',$cs_lang['change'],'submit');
    echo cs_html_roco(0);
  }
  echo cs_html_table(0);
  echo cs_html_form(0);

} else {
  header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' .$thread_id);  
}

//Daten verarbeiten und in SQL Eintragen   
if(!empty($thread_cells) AND !empty($thread_save)) {
  cs_sql_update(__FILE__,'threads',$thread_cells,$thread_save,$thread_id);

  if(isset($board_new_id)) {
    //Update board entry to get correct threads and comments count

    include_once('mods/board/repair.php');
    cs_board_threads($board_id);
    cs_board_comments($board_id);
    cs_board_threads($board_new_id);
    cs_board_comments($board_new_id);
  }
  header('location:' . $_SERVER['PHP_SELF'] . '?mod=board&action=thread&where=' .$thread_id);
}
?>