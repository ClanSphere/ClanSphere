<?php
$cs_lang = cs_translate('users');

// Wieviele sollen angezeigte werden
$max_users = 5;

$month = cs_datereal('m', cs_time());
$select = 'users_id, users_nick, users_age, users_active';
$where = "users_hidden NOT LIKE '%users_age%' AND users_age != '0' AND users_active = '1'";
$where .= " AND users_age > '%-" . $month . "-%'";
$cs_users = cs_sql_select(__FILE__,'users',$select,$where,"users_age DESC",0,0);
$users_count = count($cs_users);

$data = array();
if(empty($users_count)) {
  echo $cs_lang['no_data'];
} else {
  for($run=0; $run < $users_count; $run++) {
    if(!empty($cs_users[$run]['users_age'])) {
    $birth = explode('-', $cs_users[$run]['users_age']);
    if($birth[1] >= $month) {
    $data[$run]['users_id'] =  $cs_users[$run]['users_id'];
    $data[$run]['users_nick'] = $cs_users[$run]['users_nick'];
    $data[$run]['users_day'] = $birth[2];
    $data[$run]['users_month'] = $birth[1];
    $data[$run]['users_year'] = $birth[0];
    }
    }
  }
  foreach($data as $sortarray) {
    $column[] = $sortarray['users_month'];
    $column2[] = $sortarray['users_day'];
  }
  array_multisort($column, SORT_ASC, $column2, SORT_ASC, $data);
  $new_count = count($data);

  for($run = 0; $run < $new_count; $run++) {
    $max_users = $max_users - 1;
    if($run <= $max_users) {
      echo cs_user($data[$run]['users_id'], $data[$run]['users_nick'], $data[$run]['users_active']);
    echo ' ' . $data[$run]['users_day'] . '.' . $data[$run]['users_month'];
    $age = cs_datereal('Y') - $data[$run]['users_year'];
    echo ' (' . $age . ')';
    echo cs_html_br(1);
  }
  }
}
?>