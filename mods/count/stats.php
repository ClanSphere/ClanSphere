<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('count');

$op_count = cs_sql_option(__FILE__,'count');

$data['if']['stats'] = FALSE;
$data['if']['amstats'] = FALSE;

if ($op_count['view'] == 'stats'){
  $data['if']['stats'] = TRUE;
} else if ($op_count['view'] == 'amstats'){
  $data['if']['amstats'] = TRUE;
  $data['options'] = $op_count;
}

$max_step = 8;

$ayear = cs_datereal('Y');
$aday = cs_datereal('j');
$amonth = cs_datereal('n');

$mon = array($cs_lang['January'], $cs_lang['February'], $cs_lang['March'], $cs_lang['April'],
             $cs_lang['May'], $cs_lang['June'], $cs_lang['July'], $cs_lang['August'],
             $cs_lang['September'], $cs_lang['October'], $cs_lang['November'], $cs_lang['December']);

$vyear = $ayear;
$vmon = $amonth - $max_step;
while ($vmon < 0){
  $vmon += 12;
  $vyear--;
}

for ($run=0; $run < $max_step; $run++){
  $data['count'][$run]['id'] = $run + 1;
  $data['count'][$run]['year-mon'] = $vyear . ' - ' . $mon[$vmon];
  $data['count'][$run]['day'] = 0;
  $data['count'][$run]['count'] = 0;

  if ($op_count['view'] == 'amstats'){
    $data['countall'][$run]['id'] = $run + 1;
    $data['countall'][$run]['value'] = 0;

    $data['countave'][$run]['id'] = $run + 1;
    $data['countave'][$run]['value'] = 0;
  }
  $vmon++;
  if ($vmon > 11){
    $vmon -= 12;
    $vyear++;
  }
}

//actual day
$daystart = mktime(0,0,0,$amonth,$aday,$ayear);
$daystart = cs_timediff($daystart, 1);
$count_day = cs_sql_count(__FILE__,'count','count_time > ' . $daystart);
$data['head']['today']  = number_format($count_day,0,',','.');

// actual month 
$count_all = cs_sql_count(__FILE__,'count');
$count_arcday = cs_sql_select(__FILE__, 'count_archiv', 'SUM(count_num) AS count', 'count_mode = 1', 0, 0, 1);

$cmon = $count_all + $count_arcday['count'];
$data['head']['month']  = number_format($cmon,0,',','.');
$data['count'][$max_step - 1]['count']     = $cmon;
$data['count'][$max_step - 1]['day']       = round(($count_all + $count_arcday['count']) / $aday);
$mon_max = $cmon;

if ($op_count['view'] == 'amstats'){
  $data['countall'][$max_step - 1]['value'] = $cmon;
  $data['countave'][$max_step - 1]['value'] = round(($count_all + $count_arcday['count']) / $aday);
}

// other months
$cs_arcmon = cs_sql_select(__FILE__, 'count_archiv', 'count_month, count_num', "count_mode = 0", 0, 0, 0);

$count_arcmon = count($cs_arcmon);
$count_month = 0;
for ($run=0; $run < $count_arcmon; $run++){
  $count_month += $cs_arcmon[$run]['count_num'];
  
  $date = explode("-", $cs_arcmon[$run]['count_month']);
  $days = cs_datereal('t', mktime(0,0,0,(int)$date[0],1,(int)$date[1]));

  $place = $max_step - (($ayear - (int)$date[1]) * 12) - ($amonth - (int)$date[0]) - 1;
  if ($place >= 0 && $place < $max_step){
    $data['count'][$place]['count'] = $cs_arcmon[$run]['count_num'];
    $data['count'][$place]['day'] = round($cs_arcmon[$run]['count_num'] / $days);
    if ($cs_arcmon[$run]['count_num'] > $mon_max){
      $mon_max = $cs_arcmon[$run]['count_num'];
    }

    if ($op_count['view'] == 'amstats'){
      $data['countall'][$place]['value'] = $cs_arcmon[$run]['count_num'];
      $data['countave'][$place]['value'] = round($cs_arcmon[$run]['count_num'] / $days);
    }
  }
}

// statistics
if ($op_count['view'] == 'stats'){
  for ($run=0; $run < $max_step; $run++){
    if ($data['count'][$run]['count'] == 0){
      $data['count'][$run]['size'] = '-';
      $data['count'][$run]['diff'] = '-';
      $data['count'][$run]['barp_start'] = '';
      $data['count'][$run]['barp_end'] = '';
    } else {
      $data['count'][$run]['barp'] = round($data['count'][$run]['count'] / $mon_max * 200);
      $data['count'][$run]['size'] = cs_html_img('symbols/clansphere/bar2.gif', 12, $data['count'][$run]['barp']);
  
      if (empty($data['count'][$run-1]['count'])) {
        $data['count'][$run]['diff'] = '-';
      } else {
        $diff = round($data['count'][$run]['count'] / $data['count'][$run-1]['count'] * 100 - 100,2) . '%';
        $data['count'][$run]['diff'] = substr($diff,0,1) == '-' ? str_replace('-', '- ', $diff) : '+ ' . $diff;
      }

      $data['count'][$run]['barp_start'] = cs_html_img('symbols/clansphere/bar1.gif',12,2);
      $data['count'][$run]['barp_end'] = cs_html_img('symbols/clansphere/bar3.gif',12,2);
    }  
  }
}
$data['head']['all']  = number_format($count_all + $count_arcday['count'] + $count_month,0,',','.');

echo cs_subtemplate(__FILE__,$data,'count','stats');
