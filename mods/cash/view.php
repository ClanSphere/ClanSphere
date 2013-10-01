<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

$cs_get = cs_get('id');
$cash_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$data = array();
$data['op'] = cs_sql_option(__FILE__, 'cash');

$data['if']['not_allowed'] = FALSE;

$from = 'cash ca INNER JOIN {pre}_users usr ON ca.users_id = usr.users_id';
$select = 'usr.users_nick AS users_nick, ca.users_id AS users_id, usr.users_active AS users_active, usr.users_delete AS users_delete, ';
$select .= 'ca.cash_money AS cash_money, ca.cash_text AS cash_text, ca.cash_inout AS cash_inout, ';
$select .= 'ca.cash_time AS cash_time, ca.cash_info AS cash_info';
$cs_cash = cs_sql_select(__FILE__,$from,$select,"cash_id = '" . $cash_id . "'",0,0,1);

if($cs_cash['users_id'] == $account['users_id']) {
  $data['if']['allowed'] = TRUE;
}elseif($account['access_cash'] > 3) {
  $data['if']['allowed'] = TRUE;
} else {
  $data['if']['allowed'] = FALSE;
  $data['if']['not_allowed'] = TRUE;
}

$data['cash']['user'] = cs_user($cs_cash['users_id'],$cs_cash['users_nick'],$cs_cash['users_active'],$cs_cash['users_delete']);

$data['cash']['money'] = cs_secure ($cs_cash['cash_money']);
$data['cash']['text'] = cs_secure($cs_cash['cash_text']); 

$inout = cs_secure($cs_cash['cash_inout']);
$data['cash']['inout'] = $cs_lang["drop_$inout"]; 

$data['cash']['date'] = cs_date('date',$cs_cash['cash_time']);
$data['cash']['info'] = cs_secure($cs_cash['cash_info'],1,1);

echo cs_subtemplate(__FILE__,$data,'cash','view');