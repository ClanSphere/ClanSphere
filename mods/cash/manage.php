<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$cs_post = cs_post('where,start,sort');
$cs_get = cs_get('where,start,sort');
$data = array();
$data['op'] = cs_sql_option(__FILE__, 'cash');

$user = empty($cs_get['where']) ? 0 : $cs_get['where'];
if (!empty($cs_post['where']))  $user = $cs_post['where'];
$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$data['if']['all'] = TRUE;
$data['if']['only_user'] = FALSE;

$cs_sort[1] = 'cash_time DESC';
$cs_sort[2] = 'cash_time ASC';
$cs_sort[3] = 'cash_money DESC';
$cs_sort[4] = 'cash_money ASC';
$cs_sort[5] = 'cash_inout DESC';
$cs_sort[6] = 'cash_inout ASC';
$cs_sort[7] = 'users_nick DESC';
$cs_sort[8] = 'users_nick ASC';
$order = $cs_sort[$sort];

if(!empty($user)) {
  $data['if']['all'] = FALSE;
  $data['if']['only_user'] = TRUE;
  $cs_user = cs_sql_select(__FILE__,'users','users_nick',"users_id = '" . $user ."'",0,0,1);
  $data['lang']['user'] = $cs_user['users_nick'];
  $where_user = "users_id ='" . $user . "'";
  $and_user = " AND users_id ='" . $user . "'";
  $and_user2 = " AND ca.users_id ='" . $user . "'";
} else {
  $where_user = 0;
  $and_user = '';
  $and_user2 = '';
}
$cash_count = cs_sql_count(__FILE__,'cash',$where_user);


$data['head']['count'] = $cash_count;
$data['head']['pages'] = cs_pages('cash','manage',$cash_count,$start,$user,$sort);
$data['head']['getmsg'] = cs_getmsg();

$money = 0;
$where = "cash_inout = 'in'" . $and_user; 
$cs_cash_overview = cs_sql_select(__FILE__,'cash','cash_money',$where,0,0,0);
$over_loop = count($cs_cash_overview);
for($run=0; $run<$over_loop; $run++) {
  $money = $money + $cs_cash_overview[$run]['cash_money'];
}
$money_in = $money;
$money = 0;
$where = "cash_inout = 'out'" . $and_user; 
$cs_cash_overview = cs_sql_select(__FILE__,'cash','cash_money',$where,0,0,0);
$over_loop = count($cs_cash_overview);
for($run=0; $run<$over_loop; $run++) {
  $money = $money + $cs_cash_overview[$run]['cash_money'];
}
$money_out = $money;
$money_now = $money_in - $money_out;

$user_money = $data['op']['month_out'];
settype($user_money, 'float');
$data['ov']['month_out'] = $user_money;

$users = cs_sql_count(__FILE__,'users','access_id >= 3');
$user_money = $user_money / $users;
$user_money = round($user_money, 2); 
$data['ov']['user_money'] = $user_money;

$mon  = cs_datereal('n');
$year = cs_datereal('Y'); 
$zahlungen = 0;
$tables = 'cash ca INNER JOIN {pre}_users usr ON ca.users_id = usr.users_id';
$cells = 'ca.cash_time AS cash_time, ca.cash_inout AS cash_inout, ca.users_id AS users_id, usr.users_nick AS users_nick, ca.cash_text AS cash_text';
$cells .= ', ca.cash_money AS cash_money, ca.cash_id AS cash_id';
$cash = cs_sql_select(__FILE__,$tables,$cells,"cash_inout = 'in'" . $and_user2,$order,0,0);
$cash_count = count($cash);
for($run=0; $run<$cash_count; $run++) {
$cash_year = substr($cash[$run]['cash_time'], 0, 4);
$cash_month = (int) substr($cash[$run]['cash_time'], 5, 2);
  if($cash_year == $year AND ($cash_month == $mon)) {
    $zahlungen++;
  }
}

$data['ov']['view_cash'] = $zahlungen . ' / ' . $users . ' - ' . $cs_lang['show'];
$data['ov']['in'] = cs_secure($money_in);
$data['ov']['out'] = cs_secure($money_out);
$data['ov']['now'] = cs_secure($money_now);

$data['sort']['nick'] = cs_sort('cash','manage',$start,$user,7,$sort);
$data['sort']['date'] = cs_sort('cash','manage',$start,$user,1,$sort);
$data['sort']['money'] = cs_sort('cash','manage',$start,$user,3,$sort);
$data['sort']['in_out'] = cs_sort('cash','manage',$start,$user,5,$sort);

$where_user2 = !empty($user) ? "ca.users_id ='" . $user . "'" : '';
$data['cash'] = cs_sql_select(__FILE__,$tables,$cells,$where_user2,$order,$start,$account['users_limit']);
$cash_loop = count($data['cash']);


for($run=0; $run<$cash_loop; $run++) {
        
  $cs_user = cs_sql_select(__FILE__,'users','users_nick, users_id, users_active, users_delete',"users_id = '" . $data['cash'][$run]['users_id'] . "'",'users_nick',0);
  $data['cash'][$run]['users_link'] = cs_user($data['cash'][$run]['users_id'], $cs_user['users_nick'], $cs_user['users_active'], $cs_user['users_delete']);
  
  $data['cash'][$run]['date'] = cs_date('date',$data['cash'][$run]['cash_time']);
  $text = $data['cash'][$run]['cash_text'];
  $text = cs_substr($text, 0, 25);
  $data['cash'][$run]['text'] = cs_secure($text);
  $data['cash'][$run]['money'] = cs_secure($data['cash'][$run]['cash_money']);
  
  $inout = $data['cash'][$run]['cash_inout'];
  if ($inout == 'in') { $icon = 'green'; }
  elseif ($inout == 'out') { $icon = 'red'; }
  $data['cash'][$run]['in_out'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');
  
  $data['cash'][$run]['id'] = $data['cash'][$run]['cash_id'];
  
}
echo cs_subtemplate(__FILE__,$data,'cash','manage');
