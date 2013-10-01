<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

$data = array();
$data['op'] = cs_sql_option(__FILE__, 'cash');

$tables = 'cash ca INNER JOIN {pre}_users usr ON ca.users_id = usr.users_id';
$cells = 'ca.cash_id AS cash_id, ca.cash_time AS cash_time, ca.cash_inout AS cash_inout, ca.users_id AS users_id, usr.users_nick AS users_nick, ca.cash_text AS cash_text';
$cells .= ', ca.cash_money AS cash_money, ca.cash_id AS cash_id, usr.users_country AS users_country, usr.users_active AS users_active, usr.users_delete AS users_delete';
$cond = "cash_inout = 'in' AND ca.cash_time LIKE '" . cs_datereal('Y-m') . "%'";
$data['cash'] = cs_sql_select(__FILE__,$tables,$cells,$cond,'cash_time DESC',0,0);
if (!empty($data['cash'])) {
  $count_cash = count($data['cash']);

  for($run=0; $run<$count_cash; $run++)
  {
    $data['cash'][$run]['users_flag'] = cs_html_img('symbols/countries/'.$data['cash'][$run]['users_country'].'.png');
    $data['cash'][$run]['user'] = cs_user($data['cash'][$run]['users_id'], $data['cash'][$run]['users_nick'], $data['cash'][$run]['users_active'], $data['cash'][$run]['users_delete']);
    $data['cash'][$run]['date'] = cs_date('date',$data['cash'][$run]['cash_time']);
    $data['cash'][$run]['cash_text'] = cs_secure($data['cash'][$run]['cash_text'], 0, 0, 0);
    $data['cash'][$run]['cash_money'] = cs_secure($data['cash'][$run]['cash_money'], 0, 0, 0);
  }
}
echo cs_subtemplate(__FILE__,$data,'cash','view_cash');