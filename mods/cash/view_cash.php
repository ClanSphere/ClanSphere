<?php
$cs_lang = cs_translate('cash');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['akt_users_month'];
echo cs_html_roco(0);
echo cs_html_roco(1,'centerb');
echo $cs_lang['user_cash_month'];
echo cs_html_roco(0);
echo cs_html_roco(1,'centerb');
echo cs_link($cs_lang['back'],'cash','manage');
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,5);
echo $cs_lang['user_cash_ok'];
echo cs_html_roco(0);

$mon  = cs_datereal('n');
$year = cs_datereal('Y'); 

$tables = 'cash ca INNER JOIN {pre}_users usr ON ca.users_id = usr.users_id';
$cells = 'ca.cash_time AS cash_time, ca.cash_inout AS cash_inout, ca.users_id AS users_id, usr.users_nick AS users_nick, ca.cash_text AS cash_text';
$cells .= ', ca.cash_money AS cash_money, ca.cash_id AS cash_id, usr.users_country AS users_country, usr.users_active AS users_active, ca.cash_info AS cash_info';
$cash = cs_sql_select(__FILE__,$tables,$cells,"cash_inout = 'in'",0,0,0);
$cash_count = count($cash);
for($run=0; $run<$cash_count; $run++) {
	
  $cash_year = substr($cash[$run]['cash_time'], 0, 4);
  $cash_month = substr($cash[$run]['cash_time'], 5, 2);
  if($cash_year == $year AND ($cash_month == $mon)) {
	echo cs_html_roco(1,'leftb',0,0,'20px');
	echo cs_html_img('symbols/countries/'.$cash[$run]['users_country'].'.png');
	echo cs_html_roco(2,'leftb');
	echo cs_user($cash[$run]['users_id'], $cash[$run]['users_nick'], $cash[$run]['users_active']);
	echo cs_html_roco(3,'leftb');
	echo $cash[$run]['cash_money'] . ' ' . $cs_lang['euro'];
	echo cs_html_roco(4,'leftb');
	echo $cash[$run]['cash_time'];
	echo cs_html_roco(5,'leftb');
	echo $cash[$run]['cash_info'];
	echo cs_html_roco(0);
  }
}
echo cs_html_table(0);
echo cs_html_br(1);
?>