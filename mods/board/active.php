<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$cs_usertime = cs_sql_select(__FILE__,'users','users_readtime',"users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];


$from = 'threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id';
$conditions = "frm.board_access <= '" . $account['access_board'] . "' AND frm.board_pwd = ''";
$cs_count = cs_sql_count(__FILE__,$from,$conditions);

$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;


$data['lang']['count'] = $cs_count;
$data['pages']['list'] = cs_pages('board','active',$cs_count,$start);

$from = "threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id INNER JOIN {pre}_categories cat ON cat.categories_id = frm.categories_id INNER JOIN {pre}_users usr ON thr.threads_last_user = usr.users_id LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = '" . $account['users_id'] . "'";
$select = 'thr.threads_id AS threads_id, thr.threads_headline AS threads_headline, thr.threads_view AS threads_view, thr.threads_comments AS threads_comments, thr.threads_important AS threads_important, thr.threads_close AS threads_close, thr.threads_last_time AS threads_last_time, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, red.read_since AS read_since';
$order = 'thr.threads_view DESC, thr.threads_last_time DESC';
$cs_threads = cs_sql_select(__FILE__,$from,$select,$conditions,$order,$start,$account['users_limit']);

if(empty($cs_threads)) {
  $data['if']['not_active'] = true;
  $data['if']['active'] = false;
}
else {
  $data['if']['not_active'] = false;
  $data['if']['active'] = true;
  $run = 0;
  
  foreach($cs_threads AS $thread) {
    if(empty($thread['threads_comments'])) {
      include_once('mods/board/repair.php');
      $thread['threads_comments'] = cs_threads_comments($thread['threads_id']);
    }
    
    $icon = 'post_';
    $tid = $thread['threads_id']; 
    
  if(!empty($account['users_id']) AND $thread['threads_last_time'] > $cs_readtime AND $thread['threads_last_time'] > $thread['read_since']) {
      $icon .= 'unread_';
    }
  
  if(!empty($thread['threads_close'])) {
      $icon .= 'close_';
  }
  
    if($thread['threads_important']) {
      $icon .= 'important_';
  }
    
    $data['threads'][$run]['icon'] = cs_html_img('symbols/board/' .$icon. '.png');
    
  if(!empty($thread['threads_important'])) {
      $data['threads'][$run]['important'] = $cs_lang['important'] . ' ';
    }
  else {
    $data['threads'][$run]['important'] = '';
  }
    
  $headline = cs_secure($thread['threads_headline']);
    
  $data['threads'][$run]['headline'] = cs_link($headline,'board','thread','where=' . $thread['threads_id']);
    
  if($thread['threads_comments'] > $account['users_limit']) {
      $data['threads'][$run]['pages'] = cs_html_br(1);
      $data['threads'][$run]['pages'] .= $cs_lang['page'] . ' ';
      $data['threads'][$run]['pages'] .= cs_pages('board','thread',$thread['threads_comments'],0,$thread['threads_id'],0,0,1);
    }
  else {
    $data['threads'][$run]['pages'] = '';
  }
    
    $data['threads'][$run]['comments'] = $thread['threads_comments'];
    $data['threads'][$run]['view'] = $thread['threads_view'];
      
  if(!empty($thread['threads_last_time'])) {
      $date = cs_date('unix',$thread['threads_last_time'],1);
      $comments = ($thread['threads_comments'] == 0) ? 0 : $thread['threads_comments'] - 1;
      $goto = floor($comments / $account['users_limit']) * $account['users_limit'];
      $goto .= '#com' . $thread['threads_comments'];
      
    $data['threads'][$run]['last'] =  cs_link($date,'board','thread','where=' . $thread['threads_id'] . '&amp;start=' . $goto);
      
    if(!empty($thread['users_id'])) {
        $data['threads'][$run]['last_user'] = cs_html_br(1);
        $data['threads'][$run]['last_user'] .= $cs_lang['from'] . ' ';
        $data['threads'][$run]['last_user'] .= cs_user($thread['users_id'],$thread['users_nick'],$thread['users_active']);
      }
    else {
      $data['threads'][$run]['last_user'] = '';
    }
    }
    
  $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'board','active');
