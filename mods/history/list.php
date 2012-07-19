<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('history');

$data = array();
$tables = 'history hs INNER JOIN {pre}_users usr ON usr.users_id = hs.users_id';
$cells  = 'hs.history_time AS history_time, hs.history_text AS history_text, ';
$cells .= 'hs.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active';
$data['history'] = cs_sql_select(__FILE__,$tables,$cells,0,'hs.history_id DESC',0,0);
$history_loop = count ($data['history']);

for($run = 0; $run < $history_loop; $run++) {
  $data['history'][$run]['history_time'] = cs_date('unix',$data['history'][$run]['history_time'],1);
  $data['history'][$run]['history_text'] = cs_secure($data['history'][$run]['history_text'],1,1,1,1);
  $data['history'][$run]['user'] = cs_user($data['history'][$run]['users_id'],$data['history'][$run]['users_nick'],$data['history'][$run]['users_active']);
}
echo cs_subtemplate(__FILE__,$data,'history','list');