<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

global $cs_main, $account;

if(!empty($account['access_count']))
{
  $time = cs_time();
  $ip = empty($login['mode']) ? cs_getip() : $_SESSION['users_ip'];

  if(!isset($_SESSION['count_id']) OR !isset($_SESSION['count_last']))
  {
    $fetch_me = cs_sql_select(__FILE__,'count','count_id, count_time',"count_ip = '" . cs_sql_escape($ip) . "'",'count_id DESC');
    $_SESSION['count_id'] = $fetch_me['count_id'];
    $_SESSION['count_time'] = $fetch_me['count_time'];
    $_SESSION['count_last'] = $fetch_me['count_time'];
  }
  else
  {
    $fetch_me = array();
    $fetch_me['count_id'] = $_SESSION['count_id'];
    $fetch_me['count_time'] = $_SESSION['count_time'];
  }

  $time_lock = isset($fetch_me['count_time']) ? ($fetch_me['count_time'] + 43200) : 0;

  $_SESSION['count_time'] = $time;

  if($time > ($_SESSION['count_last'] + 30))
  {
    if($time < $time_lock)
    {
      $counter_cells = array('count_time','count_location');
      $counter_content = array($time,$cs_main['mod'] . '/' . $cs_main['action']);
      cs_sql_update(__FILE__,'count',$counter_cells,$counter_content,$fetch_me['count_id'], 0, 0);
    }
    else 
    {
      $counter_cells = array('count_ip','count_time','count_location');
      $counter_save = array($ip,$time,$cs_main['mod'] . '/' . $cs_main['action']);
      cs_sql_insert(__FILE__,'count',$counter_cells,$counter_save);
      $_SESSION['count_id'] = cs_sql_insertid(__FILE__);
    }
    $_SESSION['count_last'] = $time;
  }

  //Backup the files in counter
  $op_counter = cs_sql_option(__FILE__,'counter');
  $month = cs_datereal('n');
  $yesterday = cs_datereal('d') - 1;

  if ($op_counter['last_archiv_day'] < $yesterday) {

    $days_max = cs_datereal('t');
    $year = cs_datereal('Y');
    $timer = mktime(0, 0, 0, $month, $op_counter['last_archiv_day'] - 1, $year);

    for ($day = $op_counter['last_archiv_day']; $day < $yesterday; $day++) {

      $timer2 = $timer + 86400;
      $cond = "count_time > '" . $timer . "' AND count_time < '" .$timer2 . "'";
      $count_day = cs_sql_count(__FILE__, 'count', $cond);

      if (!empty($count_day)) {
        $cells = array('count_month', 'count_num', 'count_mode');
        $values = array($day . '-' . $month . '-' . $year, $count_day, 1);
        cs_sql_insert(__FILE__, 'count_archiv', $cells, $values);
      }
      $timer = $timer2;
    }

    cs_sql_query(__FILE__, "DELETE FROM {pre}_count WHERE count_time < '" . $timer . "'");

    $save = array('last_archiv_day' => $yesterday);

    require_once 'mods/clansphere/func_options.php';

    cs_optionsave('counter', $save);
  }

  if ($op_counter['last_archiv'] != $month) {

    $year = cs_datereal('Y');
    $timer = mktime(0, 0, 0, $month, 1, $year);
    $timer2 = $timer - 86400;
    $cond = "count_time < '" .$timer . "'";
    $last_day = cs_sql_count(__FILE__,'count',$cond . " AND count_time > '" . $timer2 . "'");
    $count_month = cs_sql_count(__FILE__,'count',$cond);

    $month_archieve = cs_sql_select(__FILE__, 'count_archiv', 'SUM(count_num) AS count', 'count_mode = 1', 0, 0, 0);
    $count_month += $month_archieve[0]['count'];

    if(!empty($count_month)) {
      cs_sql_query(__FILE__, 'DELETE FROM {pre}_count WHERE ' . $cond);
      cs_sql_query(__FILE__, "DELETE FROM {pre}_count_archiv WHERE count_mode = '1'");

      if ($month == 1) {
        $old_year = $year - 1;
        $old_month = 12;
      }
      else
      {
        $old_year = $year;
        $old_month = $month - 1;
      }

      $counter_cells1 = array('count_month','count_num');
      $counter_content1 = array($old_month . '-' . $old_year, $count_month);   

      cs_sql_insert(__FILE__, 'count_archiv', $counter_cells1 ,$counter_content1);
    }

    //Save the newest month
    $save = array('last_archiv' => $month, 'last_archiv_day' => 1, 'count_lastday' => $last_day);

    require_once 'mods/clansphere/func_options.php';

    cs_optionsave('counter', $save);
  }
}