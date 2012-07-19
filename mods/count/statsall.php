<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$data['options'] = cs_sql_option(__FILE__,'count');

$year = empty($_REQUEST['where']) ? cs_datereal('Y') : $_REQUEST['where'];
$year = empty($_REQUEST['year']) ? $year : $_REQUEST['year'];

$year_min = 10;

for ($run=0; $run < $year_min; $run++){
  $data['count'][$run]['id'] = $run + 1;
  $data['count'][$run]['year']  = $year - $year_min + $run + 1;

  $data['countall'][$run]['id'] = $run + 1;
  $data['countall'][$run]['value'] = 0;
}

// actual month if actual year is one of the given years
$ayear = cs_datereal('Y');
if (($ayear <= $year) && ($ayear >= ($year - $year_min + 1))){
  $count_all = cs_sql_count(__FILE__,'count');
  $count_arcday = cs_sql_select(__FILE__, 'count_archiv', 'SUM(count_num) AS count', 'count_mode = 1', 0, 0, 1);

  $data['countall'][$ayear - $year + $year_min - 1]['value'] += $count_all + $count_arcday['count'];
}

// other months from given years
$cs_arcmon = cs_sql_select(__FILE__, 'count_archiv', 'count_month, count_num', "count_mode = 0", 0, 0, 0);
$count_arcmon = count($cs_arcmon);
for ($run=0; $run < $count_arcmon; $run++){
  $date = explode("-", $cs_arcmon[$run]['count_month']);
  $days = cs_datereal('t', mktime(0,0,0,(int)$date[0],1,$year));

  $place = ((int)$date[1]) - $year + $year_min - 1;
  if ($place >= 0 && $place < $year_min){
    $data['countall'][$place]['value'] += $cs_arcmon[$run]['count_num'];
  }
}

echo cs_subtemplate(__FILE__,$data,'count','statsall');
