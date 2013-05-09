<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');
$cs_get = cs_get('id,agree,cancel');

$cols = 'comments_mod, comments_text, comments_id, comments_fid, users_id';
$cs_com = cs_sql_select(__FILE__,'comments',$cols,'comments_id = ' . $cs_get['id'],0,0);

$usid = (int) $cs_com['users_id'];

function cs_repair_board ($thread_id)
{
  $q_time = "UPDATE {pre}_threads thr SET threads_last_time = (SELECT "
          . "MAX(com.comments_time) FROM {pre}_comments com WHERE thr.threads_id = "
          . "com.comments_fid AND com.comments_mod = 'board')";
  $q_time .= empty($thread_id) ? '' : " WHERE threads_id = " . (int) $thread_id;
  cs_sql_query(__FILE__, $q_time);
         
  $q_user = "UPDATE {pre}_threads thr SET threads_last_user = (SELECT com.users_id "
          . "FROM {pre}_comments com WHERE com.comments_fid = thr.threads_id GROUP BY "
          . " com.comments_fid HAVING MAX(com.comments_time))";
  $q_user .= empty($thread_id) ? '' : " WHERE threads_id = " . (int) $thread_id;
  cs_sql_query(__FILE__, $q_user);
}

if(isset($cs_get['cancel'])) {

  cs_redirect($cs_lang['del_false'],'comments','manage','where=' . $cs_com['comments_mod']);
}
elseif(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'comments',$cs_get['id']);

  if($cs_com['comments_mod'] == 'board') {
    cs_repair_board($cs_com['comments_fid']);
  }

  cs_redirect($cs_lang['del_true'],'comments','manage','where=' . $cs_com['comments_mod']);
}
elseif(isset($cs_get['del_all'])) {

  cs_sql_delete(__FILE__,'comments',$usid, 'users_id');

  cs_repair_board();

  cs_redirect($cs_lang['del_true'],'comments','manage','where=' . $cs_com['comments_mod']);
}

if(!empty($cs_com)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$cs_com['comments_id']);
  $data['head']['com'] = cs_secure($cs_com['comments_text']);
  $data['url']['agree'] = cs_url('comments','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('comments','remove','id=' . $cs_get['id'] . '&amp;cancel');
  $data['url']['del_all'] = cs_url('comments','remove','id=' . $cs_get['id'] . '&amp;del_all');

  echo cs_subtemplate(__FILE__,$data,'comments','remove');
}
else {
  cs_redirect($cs_lang['del_false'],'comments','manage','where=' . $cs_com['comments_mod']);
}