<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

global $cs_main;

$time = cs_time();
$ip = empty($login['mode']) ? cs_getip() : $_SESSION['users_ip'];

$fetch_me = cs_sql_select(__FILE__,'count','count_id, count_time',"count_ip = '" . cs_sql_escape($ip) . "'",'count_id DESC');

$time_lock = isset($fetch_me['count_time']) ? ($fetch_me['count_time'] + 43200) : 0;

if($time < $time_lock) 
{
  $counter_cells = array('count_time','count_location');
  $counter_content = array($time,$cs_main['mod'] . '/' . $cs_main['action']);
  cs_sql_update(__FILE__,'count',$counter_cells,$counter_content,$fetch_me['count_id']);
}
else 
{
  $counter_cells = array('count_ip','count_time','count_location');
  $counter_save = array($ip,$time,$cs_main['mod'] . '/' . $cs_main['action']);
  cs_sql_insert(__FILE__,'count',$counter_cells,$counter_save);
}


//Backup the files in counter
$month = cs_datereal('n');
$op_counter = cs_sql_option(__FILE__,'counter');
if($op_counter['last_archiv'] != $month) {
  $year = cs_datereal('Y');

  $timer = mktime(0, 0, 0, $month, 1, $year);
  $cond = "count_time < '" .$timer . "'";
  $count_month = cs_sql_count(__FILE__,'count',$cond);
  
  if(!empty($count_month)) {
    cs_sql_query(__FILE__, 'DELETE FROM {pre}_count WHERE ' . $cond);
    
    if ($month == 1) {
    	$old_year = $year - 1;
    	$old_month = 12;
    } else {
    	$old_year = $year;
    	$old_month = $month - 1;
    }
    
    $counter_cells1 = array('count_month','count_num');
    $counter_content1 = array($old_month . '-' . $old_year, $count_month);   
    
    cs_sql_insert(__FILE__, 'count_archiv', $counter_cells1 ,$counter_content1);
  }
  
  //Save the newest month
  $opt_where = "options_mod = 'counter' AND options_name = ";
  $def_cell = array('options_value');
  $def_cont = array($month);
  cs_sql_update(__FILE__,'options',$def_cell,$def_cont,0,$opt_where . "'last_archiv'");
}

?>