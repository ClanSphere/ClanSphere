<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');
$cs_post = cs_post('start');
$cs_get = cs_get('start');
$data = array();

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];

$cs_usertime = cs_sql_select(__FILE__,'users','users_readtime',"users_id = '" . $account["users_id"] . "'");
$cs_readtime = cs_time() - $cs_usertime['users_readtime'];


$from = 'threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id';
$conditions = "thr.threads_comments = 0 AND frm.board_access <= '" . $account['access_board'] . "' AND frm.board_pwd = '' AND thr.threads_last_time > '" . $cs_readtime . "'";
$cs_count = cs_sql_count(__FILE__,$from,$conditions);


$data['count']['threads'] = $cs_count;
$data['head']['pages'] = cs_pages('board','new',$cs_count,$start);


$from = "threads thr INNER JOIN {pre}_board frm ON frm.board_id = thr.board_id INNER JOIN {pre}_categories cat ON cat.categories_id = frm.categories_id INNER JOIN {pre}_users usr ON thr.threads_last_user = usr.users_id LEFT JOIN {pre}_read red ON thr.threads_id = red.threads_id AND red.users_id = '" . $account['users_id'] . "'";
$select = 'thr.threads_id AS threads_id, thr.threads_headline AS threads_headline, thr.threads_view AS threads_view, thr.threads_comments AS threads_comments, thr.threads_important AS threads_important, thr.threads_close AS threads_close, thr.threads_last_time AS threads_last_time, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, red.read_since AS read_since';
$order = 'thr.threads_last_time DESC';
$cs_threads = cs_sql_select(__FILE__,$from,$select,$conditions,$order,$start,$account['users_limit']);

$data['if']['no_threads'] = FALSE;

if(empty($cs_threads)) {
  $data['if']['no_threads'] = TRUE;
  $data['threads'] = '';
}
else {
  $run = 0;
  foreach($cs_threads AS $thread) {

    if(empty($thread['threads_comments'])) {
      include_once('mods/board/repair.php');
      $thread['threads_comments'] = cs_threads_comments($thread['threads_id']);
    }

    $icon = 'post_';
    $tid = $thread['threads_id']; 
    if(!empty($account['users_id']) AND $thread['threads_last_time'] > $thread['read_since'])
      $icon .= 'unread_';
    if(!empty($thread['threads_close'])) 
      $icon .= 'close_';
    if($thread['threads_important'])
      $icon .= 'important_';  
    $data['threads'][$run]['icon'] = cs_html_img('symbols/board/' .$icon. '.png');

    $imp = '';
    if(!empty($thread['threads_important'])) {
      $imp = $cs_lang['important'] . ' ';
    }
    $headline = cs_secure($thread['threads_headline']);
    $data['threads'][$run]['name'] = $imp . cs_link($headline,'board','thread','where=' . $thread['threads_id']);

    $data['threads'][$run]['pages'] = '';
    if($thread['threads_comments'] > $account['users_limit']) {
      $before = cs_html_br(1) . $cs_lang['page'] . ' ';
      $data['threads'][$run]['pages'] = $before . cs_pages('board','thread',$thread['threads_comments'],0,$thread['threads_id'],0,0,1);
    }
    $data['threads'][$run]['comments'] = $thread['threads_comments'];
    $data['threads'][$run]['view'] = $thread['threads_view'];

    $data['threads'][$run]['last_time'] = '';
    if(!empty($thread['threads_last_time'])) {
      $date = cs_date('unix',$thread['threads_last_time'],1);
      $comments = ($thread['threads_comments'] == 0) ? 0 : $thread['threads_comments'] - 1;
      $goto = floor($comments / $account['users_limit']) * $account['users_limit'];
      $goto .= '#com' . $thread['threads_comments'];
      $data['threads'][$run]['last_time'] = cs_link($date,'board','thread','where=' . $thread['threads_id'] . '&amp;start=' . $goto);
      if(!empty($thread['users_id'])) {
        $data['threads'][$run]['last_user'] = cs_user($thread['users_id'],$thread['users_nick'], $thread['users_active']);
      } else $data['threads'][$run]['last_user'] = '';
    }
    $run++;
  }
}

echo cs_subtemplate(__FILE__,$data,'board','new');
