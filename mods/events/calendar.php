<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('events');

$op_events = cs_sql_option(__FILE__,'events');

$events = array();
$year = !empty($_GET['year']) ? $_GET['year'] : cs_datereal('Y');
if(1970 > $year) { $year = 1970; } # unixtime start
elseif(2037 < $year) { $year = 2037; } # limited by current operating systems 
$month = !empty($_GET['month']) ? $_GET['month'] : cs_datereal('n');
$zero = date('m', mktime(0, 0, 0, $month, 1, $year));
$days = date('t', mktime(0, 0, 0, $month, 1, $year));
$first = date('w', mktime(0, 0, 0, $month, 1, $year));
$min = cs_datereal('U',mktime(0, 0, 0, $month, 1, $year));
$max = cs_datereal('U',mktime(23, 59, 59, $month, $days, $year));

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['head_calendar'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['body_calendar'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$like = "users_age LIKE '%-" . $zero . "-%'";
$birthdays = cs_sql_select(__FILE__,'users','users_age',$like,0,0,0);

if(is_array($birthdays)) {
	foreach($birthdays AS $key => $value) {
		$new_key = substr($value['users_age'], 8, 10);
		settype($new_key,'integer');
		$events[$new_key] = 0;
	}
}

$between = "events_time >= '" . $min . "' AND events_time <= '" . $max . "'";
$fetch = cs_sql_select(__FILE__,'events','events_time',$between,0,0,0);

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

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'calhead',0,0,'9%');
echo $cs_lang['calweek'];
echo cs_html_roco(2,'calhead',0,0,'13%');
echo $cs_lang['Mon'];
echo cs_html_roco(3,'calhead',0,0,'13%');
echo $cs_lang['Tue'];
echo cs_html_roco(4,'calhead',0,0,'13%');
echo $cs_lang['Wed'];
echo cs_html_roco(5,'calhead',0,0,'13%');
echo $cs_lang['Thu'];
echo cs_html_roco(6,'calhead',0,0,'13%');
echo $cs_lang['Fri'];
echo cs_html_roco(7,'calhead',0,0,'13%');
echo $cs_lang['Sat'];
echo cs_html_roco(8,'calhead',0,0,'13%');
echo $cs_lang['Sun'];
echo cs_html_roco(0);

echo cs_html_roco(1,'calweek');
echo date('W', mktime(0, 0, 0, $month, 1, $year));
$colspan = $first == 0 ? 6 : $first - 1;
if($colspan >= 1) { 
	echo cs_html_roco(2,0,0,$colspan);
	echo '&nbsp;';
}
$row = $colspan + 2;
for($run = 1; $run <= $days; $run++) {
	if($row == 9) {
		echo cs_html_roco(0);
		echo cs_html_roco(1,'calweek');
		echo date('W', mktime(0, 0, 0, $month, $run, $year));
		$row = 2;
	}
	if(array_key_exists($run,$events)) {
		$css = 'calevent';
		$unix = mktime(0, 0, 0, $month, $run, $year);
		$out = cs_link($run,'events','timer','unix=' . $unix);	
	}
	else {
		$css = 'calday';
		$out = $run;	
	}
	$current = $run . '-' . $zero . '-' . $year;
	$css2 = $current == cs_datereal('j-m-Y') ? 'caltoday' : $css;
	echo cs_html_roco($row,$css2);
	$row++;
	echo $out;
}
if($row < 9) {
	$colspan2 = 9 - $row;
	echo cs_html_roco(2,0,0,$colspan2);
	echo '&nbsp;';
}
echo cs_html_roco(0);

echo cs_html_roco(1,'calhead',0,8);
$nom = date('F', mktime(0, 0, 0, $month, 1, $year));
$next = $month == 12 ? 'year=' . ($year + 1) . '&amp;month=1' : 
	'year=' . $year . '&amp;month=' . ($month + 1);
$last = $month == 1 ? 'year=' . ($year - 1) . '&amp;month=12' : 
	'year=' . $year . '&amp;month=' . ($month - 1);
echo ($year < 1970 OR $year == 1970 AND $month == 1) ? '&lt;' : cs_link('&lt;','events','calendar',$last);
echo ' [ ' . $cs_lang[$nom] . ' ' . $year . ' ] ';
echo ($year > 2037 OR $year == 2037 AND $month == 12) ? '&gt;' : cs_link('&gt;','events','calendar',$next);
echo cs_html_roco(0);
echo cs_html_table(0);

?>