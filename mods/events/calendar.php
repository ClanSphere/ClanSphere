<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$data = array();

$op_events = cs_sql_option(__FILE__,'events');

$events = array();
$year = !empty($_GET['year']) ? (int) $_GET['year'] : cs_datereal('Y');
if(1970 > $year) { $year = 1970; } # unixtime start
elseif(2037 < $year) { $year = 2037; } # limited by current operating systems 
$month = !empty($_GET['month']) ? (int) $_GET['month'] : cs_datereal('n');
$zero = date('m', mktime(0, 0, 0, $month, 1, $year));
$days = date('t', mktime(0, 0, 0, $month, 1, $year));
$first = date('w', mktime(0, 0, 0, $month, 1, $year));
$min = cs_datereal('U',mktime(0, 0, 0, $month, 1, $year), 1);
$max = cs_datereal('U',mktime(23, 59, 59, $month, $days, $year), 1);


$like = "users_age LIKE '%-" . $zero . "-%' AND users_hidden NOT LIKE '%users_age%'";
$birthdays = cs_sql_select(__FILE__,'users','users_age',$like,0,0,0);

if(is_array($birthdays)) {
  foreach($birthdays AS $key => $value) {
    $new_key = (int) substr(strrchr($value['users_age'],'-'),1);
    $events[$new_key] = 0;
  }
}

$from = 'events evs INNER JOIN {pre}_categories cat ON evs.categories_id = cat.categories_id';
$select = 'evs.events_time AS events_time';
$between = "events_time >= '" . $min . "' AND events_time <= '" . $max . "'";
$between .= " AND cat.categories_access <= " . $account['access_events'];
$fetch = cs_sql_select(__FILE__,$from,$select,$between,0,0,0);

if (!empty($op_events['show_wars'])) {
  $between = 'wars_date >= \'' . $min . '\' AND wars_date <= \'' . $max . '\'';
  $cells = 'wars_date AS events_time';
  $fetch2 = cs_sql_select(__FILE__,'wars',$cells,$between,0,0,0);
  $fetch = !is_array($fetch) ? array() : $fetch;
  $fetch = is_array($fetch2) ? array_merge($fetch, $fetch2) : $fetch;
}

if(is_array($fetch)) {
  foreach($fetch AS $key => $value) {
    $new_key = cs_datereal('j', $value['events_time']);
    $events[$new_key] = 0;
  }
}


$data['if']['colspan'] = FALSE;
$data['cal1']['week'] = date('W', mktime(0, 0, 0, $month, 1, $year));

$colspan = $first == 0 ? 6 : $first-1;
if($colspan >= 1) { 
  $data['if']['colspan'] = TRUE;
  $data['cal1']['colspan'] = $colspan;
}
$row = $colspan + 2;
$count = 1;
for($run = 0; $run <= $days-1; $run++) {

  $data['cal'][$run]['if']['row'] = FALSE;
  $data['cal'][$run]['if']['event'] = FALSE;
  
  if($row == 9) {
    $data['cal'][$run]['if']['row'] = TRUE;
    $data['cal'][$run]['week'] = date('W', mktime(0, 0, 0, $month, $count, $year));
    $row = 2;
  }
  
  if(array_key_exists($count,$events)) {
    $css = 'calevent';
    $unix = mktime(0, 0, 0, $month, $count, $year);
    $out = cs_link($count,'events','timer','unix=' . $unix);  
  } else {
    $css = 'calday';
    $out = $count;  
  }
  $current = $count . '-' . $zero . '-' . $year;
  $css2 = $current == cs_datereal('j-m-Y') ? 'caltoday' : $css;
  
  $data['cal'][$run]['css'] = $css2;
  $data['cal'][$run]['out'] = $out;
  
  $count++;
  $row++;
}

$data['if']['colspan2'] = FALSE;

if($row < 9) {
  $colspan2 = 9 - $row;
  $data['if']['colspan2'] = TRUE;
  $data['cal1']['colspan2'] = $colspan2;
}

$nom = date('F', mktime(0, 0, 0, $month, 1, $year));
$next = $month == 12 ? 'year=' . ($year + 1) . '&amp;month=1' : 
  'year=' . $year . '&amp;month=' . ($month + 1);
$last = $month == 1 ? 'year=' . ($year - 1) . '&amp;month=12' : 
  'year=' . $year . '&amp;month=' . ($month - 1);
$data['cal1']['bef_month'] = ($year < 1970 OR $year == 1970 AND $month == 1) ? '&lt;' : cs_link('&lt;','events','calendar',$last);
$data['cal1']['now_month'] = $cs_lang[$nom] . ' ' . $year;
$data['cal1']['nxt_month'] = ($year > 2037 OR $year == 2037 AND $month == 12) ? '&gt;' : cs_link('&gt;','events','calendar',$next);

echo cs_subtemplate(__FILE__,$data,'events','calendar');