<?php

$cs_lang = cs_translate('buddys');

$five_min = cs_time() - 300;
$from = 'buddys bs LEFT JOIN {pre}_users usr ON bs.buddys_user = usr.users_id';
$select = 'usr.users_id AS users_id, usr.users_nick AS users_nick, usr.users_country AS users_country';
$upcome = "users_laston > '" . $five_min . "' AND bs.users_id = '" . $account['users_id'] . "'";
$order = 'users_laston DESC';
$cs_users = cs_sql_select(__FILE__,$from,$select,$upcome,$order,0,8);

if(empty($cs_users)) {
	$data['if']['empty']  = TRUE;
  $data['if']['buddys'] = FALSE;
  
  $data['lang']['no_buddys'] = $cs_lang['no_buddys_online'];
}
else {

	$data['if']['empty']  = FALSE;
  $data['if']['buddys'] = TRUE;
  
  $count_users = count($cs_users);
  for ($run = 0; $run < $count_users; $run++) {
    $data['users'][$run]['nick'] = cs_secure($cs_users[$run]['users_nick']);
    $data['users'][$run]['countryicon'] = cs_html_img('symbols/countries/'.$cs_users[$run]['users_country'].'.png');
    $data['users'][$run]['url'] = cs_url('users','view','id='.$cs_users[$run]['users_id']);
    $data['users'][$run]['messageurl'] = cs_url('messages','create','to='.cs_secure($cs_users[$run]['users_nick']));
	}
}

echo cs_subtemplate(__FILE__,$data,'buddys','navlist');
 
?>