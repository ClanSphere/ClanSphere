<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$


function cs_days($d = 0,$m = 0,$y = 0) {

  global $account;
  $var = mktime(0, 0, 0, date("m") - $m, date("d") - $d, date("Y")-$y) - $account['users_timezone'];
  
  return $var;
}
function cs_time_array() {
  global $cs_lang;
  $last_day      = cs_time() - 60 * 60 * 24;
  $last_2_days   = cs_time() - 60 * 60 * 24 *   2;
  $last_4_days   = cs_time() - 60 * 60 * 24 *   4;
  $last_7_days   = cs_time() - 60 * 60 * 24 *   7;
  $last_14_days  = cs_time() - 60 * 60 * 24 *  14;
  $last_21_days  = cs_time() - 60 * 60 * 24 *  21;
  $last_50_days  = cs_time() - 60 * 60 * 24 *  50;
  $last_100_days = cs_time() - 60 * 60 * 24 * 100;
  $last_365_days = cs_time() - 60 * 60 * 24 * 365;
  $last_730_days = cs_time() - 60 * 60 * 24 * 730;
  
  $messages_data = array (
  0 => array('messages_id' => '1', 'messages_time' => $last_day, 'messages_name' => $cs_lang['last_day']),
  1 => array('messages_id' => '2', 'messages_time' => $last_2_days, 'messages_name' => $cs_lang['last_2days']),
  2 => array('messages_id' => '3', 'messages_time' => $last_4_days, 'messages_name' => $cs_lang['last_4days']),
  3 => array('messages_id' => '4', 'messages_time' => $last_7_days, 'messages_name' => $cs_lang['last_week']),
  4 => array('messages_id' => '5', 'messages_time' => $last_14_days, 'messages_name' => $cs_lang['last_2weeks']),
  5 => array('messages_id' => '6', 'messages_time' => $last_21_days, 'messages_name' => $cs_lang['last_3weeks']),
  6 => array('messages_id' => '7', 'messages_time' => $last_50_days, 'messages_name' => $cs_lang['last_50days']),
  7 => array('messages_id' => '8', 'messages_time' => $last_100_days, 'messages_name' => $cs_lang['last_100days']),
  8 => array('messages_id' => '9', 'messages_time' => $last_365_days, 'messages_name' => $cs_lang['last_year']),
  9 => array('messages_id' => '10', 'messages_time' => $last_730_days, 'messages_name' => $cs_lang['last_2years']));
  
  return $messages_data;
}
function fetch_pm_period($array,$value) {
  $loop = count($array);
  for($run=0; $run<$loop; $run++) {
    if (empty($periods)) {
      $i = 0;
      $daynum = -1;
      $weekstart = 1 - 1;
      $timestamp = cs_days();
      $timestamp = $timestamp + 3600;
      $periods = array('today' => $timestamp);
      while ($daynum != $weekstart AND $i++ < 7) {
        $timestamp -= 86400;
        $daynum = date('w', $timestamp);
        if ($i == 1) {
          $periods['yesterday'] = $timestamp;
        } else {
          $periods[strtolower(date('l', $timestamp))] = $timestamp;
        }
      }
      $periods['last_week'] = $timestamp -= (7 * 86400);
      $periods['2_weeks_ago'] = $timestamp -= (7 * 86400);
      $periods['3_weeks_ago'] = $timestamp -= (7 * 86400);
      $periods['last_month'] = $timestamp -= (28 * 86400);
    }
    $periodtime2 = cs_time();
    foreach ($periods AS $periodname => $periodtime) {
      if ($array[$run][$value] >= $periodtime AND $array[$run][$value] <= $periodtime2) {
        $periodtime2 = $periodtime;
        $array[$run]['period'] = $periodname;
      }
    }
    if(empty($array[$run]['period'])) {
      $array[$run]['period'] = 'older';
    }
  }
  return $array;
}
function fetch_pm_period_count($array) {
  $loop = count($array);
  if(!empty($loop)) {
    for($run=0; $run<$loop; $run++) {
      if($run == 0) {
        $period = $array[$run]['period'];
        $count[$period] = 1;
      } elseif($period == $array[$run]['period']) {
        $count[$period]++;
      } elseif($period != $array[$run]['period']) {
        $period = $array[$run]['period'];
        $count[$period] = 1;
      }
    }
    return $count;
  }
}

function remove_dups($array, $row_element) {

  $new_array[0] = $array[0];
  foreach ($array as $current) {
    $add_flag = 1;
    foreach ($new_array as $temp) {
      if ($current[$row_element] == $temp[$row_element]) {
         $add_flag = 0;
        break;
      }
    }
    if ($add_flag) $new_array[] = $current;
  }
  return $new_array;
}