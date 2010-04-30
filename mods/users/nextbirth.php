<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$time_now = explode('-', date('Y-m-d'));
$output = array();
$data = array();
$data = cs_cache_load('nextbirth');
$cs_lang = cs_translate('users');
$options = cs_sql_option(__FILE__,'users');

if($data['day'] != $time_now['2'].$time_now['1']) {
  $nextday = cs_datereal('d', cs_time()+$options['nextbirth_time_interval']);
  $nextmonth = cs_datereal('m', cs_time()+$options['nextbirth_time_interval']);
  $data['day'] = $time_now['2'].$time_now['1'];

  $select = 'users_id, users_nick, users_age';
  $where = "users_hidden NOT LIKE '%users_age%' AND users_active = 1 ";
  $where .= $nextmonth == $time_now['1'] ? " AND users_age LIKE '%-". $time_now['1'] ."-%'" : "AND (users_age LIKE '%-". $time_now['1'] ."-%' OR users_age LIKE '%-". $nextmonth ."-%')";
  $cs_users = cs_sql_select(__FILE__,'users',$select,$where,0,0,0);
  if(!empty($cs_users)) {
    $run=0;
    foreach($cs_users as $birth_users) {
      $birth = explode('-', $birth_users['users_age']);
      if($birth[1].$birth[2] < $nextmonth.$nextday AND $birth[1].$birth[2] > $time_now['1'].$time_now['2']) {
        $data['users'][$run]['users_id'] =  $birth_users['users_id'];
        $data['users'][$run]['users_nick'] = $birth_users['users_nick'];
        $data['users'][$run]['users_day'] = $birth[2];
        $data['users'][$run]['users_month'] = $birth[1];
        $data['users'][$run]['users_year'] = $birth[0];
        $run++;
      }
    }

    foreach($data['users'] as $sortarray) {
      $column[] = $sortarray['users_month'];
      $column2[] = $sortarray['users_day'];
    }
    if(!empty($data['users'])) array_multisort($column, SORT_ASC, $column2, SORT_ASC, $data['users']);
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