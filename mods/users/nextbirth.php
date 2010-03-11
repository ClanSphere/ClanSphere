<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$time_now = explode('-', date('Y-m-d'));
$cache = array();
$cache = cs_cache_load('nextbirth');

if($cache['day'] != $time_now['2'].$time_now['1']) {
  $cs_lang = cs_translate('users');
  $options = cs_sql_option(__FILE__,'users');
  $nextday = cs_datereal('d', cs_time()+$options['nextbirth_time_interval']);
  $nextmonth = cs_datereal('m', cs_time()+$options['nextbirth_time_interval']);
  $cache['day'] = $time_now['2'].$time_now['1'];

  $select = 'users_id, users_nick, users_age';
  $where = "users_hidden NOT LIKE '%users_age%' AND users_active = '1' AND users_age < '". $time_now['0'] ."-%'";
  $where .= $nextmonth == $time_now['1'] ? " AND users_age LIKE '%-". $time_now['1'] ."-%'" : "AND (users_age LIKE '%-". $time_now['1'] ."-%' OR users_age LIKE '%-". $nextmonth ."-%')";
  $cs_users = cs_sql_select(__FILE__,'users',$select,$where,0,0,0);

  $users_count = count($cs_users);
  $data = array();
  
  for($run=0; $run < $users_count; $run++) {
    $birth = explode('-', $cs_users[$run]['users_age']);
    if($birth[1].$birth[2] < $nextmonth.$nextday AND $birth[1].$birth[2] > $time_now['1'].$time_now['2']) {
      $data[$run]['users_id'] =  $cs_users[$run]['users_id'];
      $data[$run]['users_nick'] = $cs_users[$run]['users_nick'];
      $data[$run]['users_day'] = $birth[2];
      $data[$run]['users_month'] = $birth[1];
      $data[$run]['users_year'] = $birth[0];
      }
  }

  foreach($data as $sortarray) {
    $column[] = $sortarray['users_month'];
    $column2[] = $sortarray['users_day'];
  }
  array_multisort($column, SORT_ASC, $column2, SORT_ASC, $data);
  $new_count = empty($options['nextbirth_max_users']) ? count($data) : min(count($data), $options['nextbirth_max_users']);

  if(empty($new_count)) {
    $cache['text'] = $cs_lang['no_data'];
  }
  else {
    $cache['text'] = '';
    for($run = 0; $run < $new_count; $run++) {
        $age = $time_now['0'] - $data[$run]['users_year'];
        $cache['text'] .= $data[$run]['users_day'] . '.' . $data[$run]['users_month'] . '. ';
        $cache['text'] .= cs_user($data[$run]['users_id'], $data[$run]['users_nick']);
        $cache['text'] .= ' (' . $age . ')';
        $cache['text'] .= cs_html_br(1);
    }
  }
  cs_cache_save('nextbirth', $cache);
}
echo $cache['text'];