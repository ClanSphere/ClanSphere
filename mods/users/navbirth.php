<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$thisday = cs_datereal('m-d');
$output = array();
$data = array();
$data = cs_cache_load('navbirth');
$cs_lang = cs_translate('users');
$options = cs_sql_option(__FILE__,'users');

if($data['day'] != $thisday) {
  $data['day'] = $thisday;
  $select = 'users_id, users_nick, users_age';
  $where = "users_age LIKE '%-" .$data['day'] . "' AND users_hidden NOT LIKE '%users_age%' AND users_active = 1";
  $order = 'users_nick ASC';
  $data['users'] = cs_sql_select(__FILE__,'users',$select,$where,$order,0,0);
  cs_cache_save('navbirth', $data);
}

if(empty($data['users'])) {
  echo $cs_lang['no_data'];
}
else {
  $count = empty($options['navbirth_max_users']) ? count($data['users']) : min(count($data['users']), $options['navbirth_max_users']);
  for($run = 0; $run < $count; $run++) {
    $birth = explode ('-', $data['users'][$run]['users_age']);
    $output['users'][$run]['age'] = cs_datereal('Y') - $birth[0];
    $output['users'][$run]['day'] = $birth[2];
    $output['users'][$run]['month'] = $birth[1];
    $output['users'][$run]['year'] = $birth[0];
    $output['users'][$run]['user'] = cs_user($data['users'][$run]['users_id'], $data['users'][$run]['users_nick']);
    $output['users'][$run]['messageurl'] = cs_url('messages','create','to_id='.$data['users'][$run]['users_id']);
  }
  echo cs_subtemplate(__FILE__,$output,'users','navbirth');
}