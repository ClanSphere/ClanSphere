<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$data = array();

$mon  = cs_datereal('n');
$year = cs_datereal('Y'); 

$tables = 'cash ca INNER JOIN {pre}_users usr ON ca.users_id = usr.users_id';
$cells = 'ca.cash_id AS cash_id, ca.cash_time AS cash_time, ca.cash_inout AS cash_inout, ca.users_id AS users_id, usr.users_nick AS users_nick, ca.cash_text AS cash_text';
$cells .= ', ca.cash_money AS cash_money, ca.cash_id AS cash_id, usr.users_country AS users_country, usr.users_active AS users_active, usr.users_delete AS users_delete';
$data['cash'] = cs_sql_select(__FILE__,$tables,$cells,"cash_inout = 'in'",'cash_time DESC',0,0);
$cash_count = count($data['cash']);

$offrun = 0;
for($i = 0; $i<$cash_count; $i++)
{
	$cash_year = substr($data['cash'][$i]['cash_time'], 0, 4);
	$cash_month = (int) substr($data['cash'][$i]['cash_time'], 5, 2);
	if($cash_year == $year AND ($cash_month == $mon))
	{
   		$offrun++;
	}
}

$count_cash = count($data['cash']);

for ($run = $offrun; $run < $count_cash; $run++) unset($data['cash'][$run]);

for($run=0; $run<$offrun; $run++)
{
	$data['cash'][$run]['users_flag'] = cs_html_img('symbols/countries/'.$data['cash'][$run]['users_country'].'.png');
	$data['cash'][$run]['user'] = cs_user($data['cash'][$run]['users_id'], $data['cash'][$run]['users_nick'], $data['cash'][$run]['users_active'], $data['cash'][$run]['users_delete']);
	$data['cash'][$run]['date'] = cs_date('date',$data['cash'][$run]['cash_time']);
}

echo cs_subtemplate(__FILE__,$data,'cash','view_cash');