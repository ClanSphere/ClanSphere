<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$data['options'] = cs_sql_option(__FILE__,'count');

$data['count'] = array();

$year = empty($_REQUEST['where']) ? cs_datereal('Y') : $_REQUEST['where'];
$year = empty($_REQUEST['year']) ? $year : $_REQUEST['year'];

settype($where,'integer');
$data['head']['year']  = $year;

$mon = array($cs_lang['January'], $cs_lang['February'], $cs_lang['March'], $cs_lang['April'],
             $cs_lang['May'], $cs_lang['June'], $cs_lang['July'], $cs_lang['August'], 
             $cs_lang['September'], $cs_lang['October'], $cs_lang['November'], $cs_lang['December']);

for ($run=0; $run < 12; $run++){
  $data['count'][$run]['id'] = $run + 1;
  $data['count'][$run]['month']  = $mon[$run];

  $data['countall'][$run]['id'] = $run + 1;
  $data['countall'][$run]['value'] = 0;

  $data['countave'][$run]['id'] = $run + 1;
  $data['countave'][$run]['value'] = 0;
}

// actual month if given year is actual year
$ayear = cs_datereal('Y');
if ($year == $ayear){
  $count_all = cs_sql_count(__FILE__,'count');
  $count_arcday = cs_sql_select(__FILE__, 'count_archiv', 'SUM(count_num) AS count', 'count_mode = 1', 0, 0, 1);

  $amonth = cs_datereal('n');
  $aday = cs_datereal('j');
  $data['countall'][$amonth - 1]['value'] = $count_all + $count_arcday['count'];
  $data['countave'][$amonth - 1]['value'] = round(($count_all + $count_arcday['count']) / $aday);
}

// other months from given year
$where = "count_month LIKE '%" . $year . "' AND count_mode = 0" ;
$cs_arcmon = cs_sql_select(__FILE__, 'count_archiv', 'count_month, count_num', $where, 0, 0, 0);

$count_arcmon = count($cs_arcmon);
for ($run=0; $run < $count_arcmon; $run++){
  $date = explode("-", $cs_arcmon[$run]['count_month']);
  $days = cs_datereal('t', mktime(0,0,0,(int)$date[0],1,$year));

  $data['countall'][((int)$date[0]) - 1]['value'] = $cs_arcmon[$run]['count_num'];
  $data['countave'][((int)$date[0]) - 1]['value'] = round($cs_arcmon[$run]['count_num'] / $days);
}

echo cs_subtemplate(__FILE__,$data,'count','statsyear');
