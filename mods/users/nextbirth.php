<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$time_now = explode('-', date('Y-m-d'));
$output = array();

$data = cs_cache_load('nextbirth');
$cs_lang = cs_translate('users');
$options = cs_sql_option(__FILE__,'users');


if(empty($data) OR $data['day'] != $time_now['2'].$time_now['1']) { 
  $data = array();  // We need to reset the data array here, else new birthdays will be added to existing cached entries! 

  $nextday = cs_datereal('d', cs_time()+$options['nextbirth_time_interval']);
  $nextmonth = cs_datereal('m', cs_time()+$options['nextbirth_time_interval']);
  $data['day'] = $time_now['2'].$time_now['1'];
  $check_n = ($nextmonth == '01') ? (int) 13 . $nextday : (int) $nextmonth . $nextday;
  $check_t = (int) $time_now['1'] . $time_now['2'];

  $select = 'users_id, users_nick, users_age';
  $where = "users_hidden NOT LIKE '%users_age%' AND users_active = 1 ";
  $where .= ($nextmonth == $time_now['1']) ? " AND users_age LIKE '%-". $time_now['1'] ."-%'" : "AND (users_age LIKE '%-". $time_now['1'] ."-%' OR users_age LIKE '%-". $nextmonth ."-%')";
  $cs_users = cs_sql_select(__FILE__,'users',$select,$where,'users_age',0,0);
  
  if(!empty($cs_users)) {
    $run=0;
    foreach($cs_users as $birth_users) {
      $birth = explode('-', $birth_users['users_age']);
      $check_b = ($birth[1] == '01') ? (int) 13 . $birth[2] : (int) $birth[1] . $birth[2];
  
      if($check_b < $check_n AND $check_b >= $check_t) {
        $data['users'][$run]['users_id'] =  $birth_users['users_id'];
        $data['users'][$run]['users_nick'] = $birth_users['users_nick'];
        $data['users'][$run]['users_day'] = $birth[2];
        $data['users'][$run]['users_month'] = $birth[1];
        $data['users'][$run]['users_year'] = $birth[0];
        $run++;
      }
    }

    if(!empty($data['users'])) {
      foreach($data['users'] as $sortarray) {
        $column[] = $sortarray['users_month'] . $sortarray['users_day'];
      }
      array_multisort($column, SORT_ASC, $data['users']);
    }
  }

  cs_cache_save('nextbirth', $data);
}

if(empty($data['users'])) {
  echo $cs_lang['no_data'];
}
else {
  $count = empty($options['nextbirth_max_users']) ? count($data['users']) : min(count($data['users']), $options['nextbirth_max_users']);
  for($run = 0; $run < $count; $run++) {
    $output['users'][$run]['age'] = $time_now['0'] - $data['users'][$run]['users_year'];
    $output['users'][$run]['day'] = $data['users'][$run]['users_day'];
    $output['users'][$run]['month'] = $data['users'][$run]['users_month'];
    $output['users'][$run]['year'] = $data['users'][$run]['users_year'];
    $output['users'][$run]['user'] = cs_user($data['users'][$run]['users_id'], $data['users'][$run]['users_nick']);
    $output['users'][$run]['messageurl'] = cs_url('messages','create','to_id='.$data['users'][$run]['users_id']);
  }
  echo cs_subtemplate(__FILE__,$output,'users','nextbirth');
}