<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$data = array();

$mon  = cs_datereal('n');
$year = cs_datereal('Y'); 

$tables = 'cash ca INNER JOIN {pre}_users usr ON ca.users_id = usr.users_id';
$cells = 'ca.cash_time AS cash_time, ca.cash_inout AS cash_inout, ca.users_id AS users_id, usr.users_nick AS users_nick, ca.cash_text AS cash_text';
$cells .= ', ca.cash_money AS cash_money, ca.cash_id AS cash_id, usr.users_country AS users_country, usr.users_active AS users_active';
$cs_cash = cs_sql_select(__FILE__,$tables,$cells,"cash_inout = 'in'",0,0,0);
$cash_count = count($cs_cash);

$offrun = 0;
for($i = 0; $i<$cash_count; $i++) {
  $cash_year = substr($cs_cash[$i]['cash_time'], 0, 4);
  $cash_month = substr($cs_cash[$i]['cash_time'], 5, 2);
  if($cash_year == $year AND ($cash_month == $mon)) {
    $offrun++;
  }
}

for($run=0; $run<$offrun; $run++) {
  
  $cash[$run]['users_flag'] = cs_html_img('symbols/countries/'.$cs_cash[$run]['users_country'].'.png');
  $cash[$run]['user'] = cs_user($cs_cash[$run]['users_id'], $cs_cash[$run]['users_nick'], $cs_cash[$run]['users_active']);
  $cash[$run]['for'] = $cs_cash[$run]['cash_text'];
  $cash[$run]['date'] = cs_date('date',$cs_cash[$run]['cash_time']);
  $cash[$run]['money'] = $cs_cash[$run]['cash_money'];
  
}
$data['cash'] = !empty($cash) ? $cash : '';
echo cs_subtemplate(__FILE__,$data,'cash','view_cash');

?>