<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$from  = 'abonements abo INNER JOIN {pre}_threads thr ON abo.threads_id = thr.threads_id ';
$from .= 'INNER JOIN {pre}_users usr ON thr.users_id = usr.users_id '; 
$select = 'abo.abonements_id AS abonements_id, thr.threads_headline AS threads_headline, thr.threads_last_time AS threads_last_time, thr.threads_last_user AS threads_last_user, thr.threads_id AS threads_id, usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete';
$order = 'thr.threads_last_time DESC';
$where = "abo.users_id = '" . $account['users_id'] . "'";
$cs_abo = cs_sql_select(__FILE__,$from,$select,$where,$order,0,0);

$count_abo = cs_sql_count(__FILE__,'abonements',"users_id = '" . $account['users_id'] . "'");
$count_att = cs_sql_count(__FILE__,'boardfiles','users_id=' . $account['users_id']);

$data['count']['abos'] = $count_abo;
$data['count']['attachments'] = $count_att;
$data['link']['attachments'] = cs_url('board','attachments');
$data['link']['avatar'] = cs_url('board','avatar');
$data['link']['signature'] = cs_url('board','signature');

if(empty($count_abo)) {
  $data['abos'] = '';
}

for($run = 0; $run < $count_abo; $run++) {
  $com_count = cs_sql_count(__FILE__, 'comments', "comments_mod = 'board' AND comments_fid = " . $cs_abo[$run]['threads_id']);
  
  $start = floor($com_count / $account['users_limit']) * $account['users_limit'];
  $more = 'where=' . $cs_abo[$run]['threads_id'] . '&amp;start=' . $start . '#' . $com_count;
  
  $from = 'users';
  $user = $cs_abo[$run]['threads_last_user'];
  $select = 'users_nick, users_id, users_active, users_delete';
  $where = "users_id = '" . $user . "'";
  $cs_users = cs_sql_select(__FILE__,$from,$select,$where,0,0,1);
  
  
  $data['abos'][$run]['topics'] = $cs_abo[$run]['threads_headline'];
  $data['abos'][$run]['topics_link'] = cs_url('board','thread','where=' . $cs_abo[$run]['threads_id']);
  $data['abos'][$run]['replies'] = $com_count; 
  $data['abos'][$run]['created_by'] = cs_user($cs_abo[$run]['users_id'], $cs_abo[$run]['users_nick'], $cs_abo[$run]['users_active'], $cs_abo[$run]['users_delete']);
  $data['abos'][$run]['date'] = cs_date('unix',$cs_abo[$run]['threads_last_time'],1); 
  $data['abos'][$run]['date_link'] = cs_url('board','thread',$more); 
  $data['abos'][$run]['lastpost_user'] = cs_user($cs_users['users_id'], $cs_users['users_nick'], $cs_users['users_active'], $cs_users['users_delete']);
  $data['abos'][$run]['remove'] = cs_url('board','delabo','id=' . $cs_abo[$run]['abonements_id']);
}  

echo cs_subtemplate(__FILE__,$data,'board','center');