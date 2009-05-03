<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$five_min = cs_time() - 300;
$select = 'users_id, users_nick, users_country, users_active, users_invisible, users_picture';
$upcome = "users_laston > " . $five_min . " AND users_active = '1' AND users_invisible = '0'";
$order = 'users_laston DESC';
$cs_users = cs_sql_select(__FILE__,'users',$select,$upcome,$order,0,8);
$data = array();

if(empty($cs_users)) {

  $data['lang']['no_users'] = $cs_lang['no_data'];
  
  echo cs_subtemplate(__FILE__,$data,'users','no_users');
  
} else {
  
  $count_users = count($cs_users);
  for ($run = 0; $run < $count_users; $run++) {
    if(!empty($cs_users[$run]['users_picture'])) {
    $data['users'][$run]['picture'] = 'uploads/users/' . $cs_users[$run]['users_picture'];
  }
  else {
    $data['users'][$run]['picture'] = 'symbols/users/no_pic.png';
  }
    $data['users'][$run]['nick'] = $cs_users[$run]['users_nick'];
    $data['users'][$run]['url'] = cs_url('users','view','id='.$cs_users[$run]['users_id']);
  }
  echo cs_subtemplate(__FILE__,$data,'users','navonline_pic');
}