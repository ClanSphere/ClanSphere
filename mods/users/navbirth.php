<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$thisday = cs_datereal('m-d');
$cache = array();
$cache = cs_cache_load('navbirth');
if($cache['day'] != $thisday) {
  $cs_lang = cs_translate('users');
  $options = cs_sql_option(__FILE__,'users');
  $cache['day'] = $thisday;
  
  $select = 'users_id, users_nick, users_age';
  $where = "users_age LIKE '%-" .$cache['day'] . "' AND users_hidden NOT LIKE '%users_age%' AND users_active = 1";
  $order = 'users_nick ASC';
  $cs_users = cs_sql_select(__FILE__,'users',$select,$where,$order,0,0);
  $count = empty($options['navbirth_max_users']) ? count($cs_users) : min(count($cs_users), $options['navbirth_max_users']);
  
  if(empty($count)) {
    $cache['text'] = $cs_lang['no_data'];
  }
  else {
    $cache['text'] = '';
    for($run = 0; $run < $count; $run++) {
      $birth = explode ('-', $cs_users[$run]['users_age']);
      $age = cs_datereal('Y') - $birth[0];
      if ($age > 0) {
        $cache['text'] .= cs_user($cs_users[$run]['users_id'], $cs_users[$run]['users_nick']);
        $cache['text'] .= ' (' . $age . ')';
        $cache['text'] .= cs_html_br(1);
      }
    }
  }
  cs_cache_save('navbirth', $cache);
}
echo $cache['text'];