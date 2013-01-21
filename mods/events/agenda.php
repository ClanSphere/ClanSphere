<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');
$data = array();

$year = !empty($_GET['year']) ? (int) $_GET['year'] : cs_datereal('Y');
if(1970 > $year) { $year = 1970; } # unixtime start
elseif(2037 < $year) { $year = 2037; } # limited by current operating systems 
$month = !empty($_GET['month']) ? (int) $_GET['month'] : cs_datereal('n');
$nom = date('F', mktime(0, 0, 0, $month, 1, $year));
$days = date('t', mktime(0, 0, 0, $month, 1, $year));
$min = cs_datereal('U',mktime(0, 0, 0, $month, 1, $year), 1);
$max = cs_datereal('U',mktime(23, 59, 59, $month, $days, $year), 1);

$data['month'][1] = ($month == 1) ? $cs_lang['January'] : cs_link($cs_lang['January'], 'events','agenda','year=' . $year . '&amp;month=1');
$data['month'][2] = ($month == 2) ? $cs_lang['February'] : cs_link($cs_lang['February'], 'events','agenda','year=' . $year . '&amp;month=2');
$data['month'][3] = ($month == 3) ? $cs_lang['March'] : cs_link($cs_lang['March'], 'events','agenda','year=' . $year . '&amp;month=3');
$data['month'][4] = ($month == 4) ? $cs_lang['April'] : cs_link($cs_lang['April'], 'events','agenda','year=' . $year . '&amp;month=4');
$data['month'][5] = ($month == 5) ? $cs_lang['May'] : cs_link($cs_lang['May'], 'events','agenda','year=' . $year . '&amp;month=5');
$data['month'][6] = ($month == 6) ? $cs_lang['June'] : cs_link($cs_lang['June'], 'events','agenda','year=' . $year . '&amp;month=6');
$data['month'][7] = ($month == 7) ? $cs_lang['July'] : cs_link($cs_lang['July'], 'events','agenda','year=' . $year . '&amp;month=7');
$data['month'][8] = ($month == 8) ? $cs_lang['August'] : cs_link($cs_lang['August'], 'events','agenda','year=' . $year . '&amp;month=8');
$data['month'][9] = ($month == 9) ? $cs_lang['September'] : cs_link($cs_lang['September'], 'events','agenda','year=' . $year . '&amp;month=9');
$data['month'][10] = ($month == 10) ? $cs_lang['October'] : cs_link($cs_lang['October'], 'events','agenda','year=' . $year . '&amp;month=10');
$data['month'][11] = ($month == 11) ? $cs_lang['November'] : cs_link($cs_lang['November'], 'events','agenda','year=' . $year . '&amp;month=11');
$data['month'][12] = ($month == 12) ? $cs_lang['December'] : cs_link($cs_lang['December'], 'events','agenda','year=' . $year . '&amp;month=12');

$data['year']['last'] = (1970 > $year) ? '' : cs_link(($year - 1), 'events','agenda','year=' . ($year - 1) . '&amp;month=' . $month);
$data['year']['current'] = $year;
$data['year']['next'] = (2037 < $year) ? '' : cs_link(($year + 1), 'events','agenda','year=' . ($year + 1) . '&amp;month=' . $month);
$data['head']['time'] = $cs_lang[$nom] . ' ' . $year;

$order = 'events_time DESC';
$where = "events_time >= '" . $min . "' AND events_time <= '" . $max . "'";
$cells = 'evs.events_name AS events_name, evs.events_time AS events_time, evs.events_guestsmax AS events_guestsmax, evs.events_id AS events_id, evs.categories_id AS categories_id, cat.categories_name AS categories_name, cat.categories_picture AS categories_picture, evs.events_cancel AS events_cancel';
$tables = 'events evs INNER JOIN {pre}_categories cat ON evs.categories_id = cat.categories_id';
$data['events'] = cs_sql_select(__FILE__,$tables,$cells,$where,$order,0,0);
$events_count = count($data['events']);

for ($i = 0; $i < $events_count; $i++) {

  $data['events'][$i]['time'] = cs_date('unix',$data['events'][$i]['events_time'],1);
  $data['events'][$i]['canceled'] = empty($data['events'][$i]['events_cancel']) ? '' : $cs_lang['canceled'];
  $signed = empty($account['users_id']) ? 0 : cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $data['events'][$i]['events_id'] . "' AND users_id = '" . $account['users_id'] . "'");
  $data['events'][$i]['signed'] = empty($signed) ? '' : $cs_lang['signed'];
  $data['events'][$i]['eventguests'] = cs_sql_count(__FILE__, 'eventguests', "events_id = '" . $data['events'][$i]['events_id'] . "'");
  $data['events'][$i]['class'] = $data['events'][$i]['events_time'] > cs_time() ? 'b' : 'c';

  if(empty($data['events'][$i]['events_guestsmax'])) {
    $data['events'][$i]['bar'] = '';
    $data['events'][$i]['perc'] = '';
  }
  else {
    $bar = cs_html_img('symbols/clansphere/bar1.gif',0,0);
    $perc = round($data['events'][$i]['eventguests'] * 100 / $data['events'][$i]['events_guestsmax']);
    $perc = $perc > 100 ? 100 : $perc;
    $bar_style = "style=\"height:12px;width:" . ($perc / 1.2) . "%\"";
    $bar .= cs_html_img('symbols/clansphere/bar2.gif',0,0,$bar_style);
    $bar .= cs_html_img('symbols/clansphere/bar3.gif',0,0);
    $data['events'][$i]['bar'] = $bar;
    $data['events'][$i]['perc'] = '(' . $perc . '%)';
  }

  if(empty($data['events'][$i]['categories_picture'])) {
    $data['events'][$i]['categories_picture'] = '&nbsp;';
  } else {
    $place = 'uploads/categories/' . $data['events'][$i]['categories_picture'];
    $size = file_exists($cs_main['def_path'] . '/' . $place) ? getimagesize($cs_main['def_path'] . '/' . $place) : array(0,1);
    $data['events'][$i]['categories_picture'] = cs_html_img($place,$size[1],$size[0]);
  }  

  if(empty($data['events'][$i]['events_guestsmax']) OR $data['events'][$i]['events_time'] < cs_time())
    $data['events'][$i]['indicator'] = cs_html_img('symbols/clansphere/grey.gif');
  elseif($data['events'][$i]['eventguests'] >= $data['events'][$i]['events_guestsmax'])
    $data['events'][$i]['indicator'] = cs_html_img('symbols/clansphere/red.gif');
  else
    $data['events'][$i]['indicator'] = cs_html_img('symbols/clansphere/green.gif');
}

$data['if']['access'] = $account['access_events'] > 2 ? 1 : 0;
$data['if']['no_access'] = $account['access_events'] > 2 ? 0 : 1;

echo cs_subtemplate(__FILE__, $data, 'events', 'agenda');