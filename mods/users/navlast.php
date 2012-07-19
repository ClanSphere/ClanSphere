<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$select = 'users_id, users_nick, users_register, users_active';
$order = 'users_register DESC';
$cs_users = cs_sql_select(__FILE__,'users',$select,"users_active = '1'",$order,0,4);
$data = array();

if(empty($cs_users)) {
  echo $cs_lang['no_data'];
}
else {
  
  $count_users = count($cs_users);
  for ($run = 0; $run < $count_users; $run++) {
      $data['users'][$run]['register'] = cs_date('unix',$cs_users[$run]['users_register'],1);
    $data['users'][$run]['user'] = cs_user($cs_users[$run]['users_id'], $cs_users[$run]['users_nick'], $cs_users[$run]['users_active']);
  }
  echo cs_subtemplate(__FILE__,$data,'users','navlast');
}