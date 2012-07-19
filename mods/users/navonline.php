<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$five_min = cs_time() - 300;
$select = 'users_id, users_nick, users_country, users_active, users_invisible';
$invisible = ($account['access_users'] > 4) ? '' : " AND users_invisible = '0'";
$upcome = "users_laston > " . $five_min . " AND users_active = '1'" . $invisible;
$order = 'users_laston DESC';
$cs_users = cs_sql_select(__FILE__,'users',$select,$upcome,$order,0,8);
$data = array();

if(empty($cs_users)) {

  $data['lang']['no_users'] = $cs_lang['no_data'];
  
  echo cs_subtemplate(__FILE__,$data,'users','no_users');
  
} else {
  
  $count_users = count($cs_users);
  for ($run = 0; $run < $count_users; $run++) {

    $data['users'][$run]['nick'] = cs_user($cs_users[$run]['users_id'], $cs_users[$run]['users_nick'], $cs_users[$run]['users_active']);
    if(empty($invisible) AND !empty($cs_users[$run]['users_invisible']))
      $data['users'][$run]['nick'] = cs_html_italic(1) . $data['users'][$run]['nick'] . cs_html_italic(0);

    $data['users'][$run]['countryicon'] = cs_html_img('symbols/countries/'.$cs_users[$run]['users_country'].'.png');
    $data['users'][$run]['messageurl'] = cs_url('messages','create','to_id='.$cs_users[$run]['users_id']);
  }
  echo cs_subtemplate(__FILE__,$data,'users','navonline');
}