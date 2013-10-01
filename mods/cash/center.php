<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$cs_post = cs_post('start,sort');
$cs_get = cs_get('start,sort');
$data = array();
$data['op'] = cs_sql_option(__FILE__, 'cash');

$start = empty($cs_get['start']) ? 0 : $cs_get['start'];
if (!empty($cs_post['start']))  $start = $cs_post['start'];
$sort = empty($cs_get['sort']) ? 1 : $cs_get['sort'];
if (!empty($cs_post['sort']))  $sort = $cs_post['sort'];

$data['if']['no_kt'] = TRUE;
$data['if']['kt'] = FALSE;

$cs_sort[1] = 'cash_time DESC';
$cs_sort[2] = 'cash_time ASC';
$cs_sort[3] = 'cash_money DESC';
$cs_sort[4] = 'cash_money ASC';
$cs_sort[5] = 'cash_inout DESC';
$cs_sort[6] = 'cash_inout ASC';
$order = $cs_sort[$sort];
$where_user = "users_id = '" . $account['users_id'] . "'";
$and_user = " AND users_id = '" . $account['users_id'] . "'";
$cash_count = cs_sql_count(__FILE__,'cash',$where_user);

$data['head']['count'] = $cash_count;
$data['head']['pages'] = cs_pages('cash','center',$cash_count,$start,0,$sort);

// Kontodaten
$konto = cs_sql_select(__FILE__,'account','*',0,0,0);
$konto_count = count($konto);

if(!empty($konto_count)) {

  $data['if']['no_kt'] = FALSE;
  $data['if']['kt'] = TRUE;
  $data['kt']['account_id'] = cs_secure($konto['account_id'], 0, 0, 0);
  $data['kt']['account_owner'] = cs_secure($konto['account_owner'], 0, 0, 0);
  $data['kt']['account_number'] = cs_secure($konto['account_number'], 0, 0, 0);
  $data['kt']['account_bcn'] = cs_secure($konto['account_bcn'], 0, 0, 0);
  $data['kt']['account_iban'] = cs_secure($konto['account_iban'], 0, 0, 0);
  $data['kt']['account_bic'] = cs_secure($konto['account_bic'], 0, 0, 0);
  $data['kt']['account_bank'] = cs_secure($konto['account_bank'], 0, 0, 0);
  $data['if']['iban'] = false;
  $data['if']['bic'] = false;

  if(!empty($konto['account_iban'])) {
    $data['if']['iban'] = TRUE;
  }
  if(!empty($konto['account_bic'])) {
    $data['if']['bic'] = TRUE;
  }
}
// Ende Kontodaten


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

$data['ov']['in'] = cs_secure($money_in);
$data['ov']['out'] = cs_secure($money_out);
$data['ov']['now'] = cs_secure($money_now);


// Einzahlungen (Einnahmen)
$data['sort']['date'] = cs_sort('cash','center',$start,0,1,$sort);
$data['sort']['money'] = cs_sort('cash','center',$start,0,3,$sort);


$where = "cash_inout = 'in'" . $and_user;
$data['in'] = cs_sql_select(__FILE__,'cash','*',$where,$order,$start,$account['users_limit']);
$cash_loop = count($data['in']);

for($run=0; $run<$cash_loop; $run++) {

  $data['in'][$run]['date'] = cs_date('date',$data['in'][$run]['cash_time']);

  $data['in'][$run]['id'] = $data['in'][$run]['cash_id'];
  $text = $data['in'][$run]['cash_text'];
  $text = cs_substr($text, 0, 25);
  $data['in'][$run]['for'] = cs_secure($text);

  $data['in'][$run]['money'] = cs_secure($data['in'][$run]['cash_money']);

  $inout = $data['in'][$run]['cash_inout'];
  if ($inout == 'in') { $icon = 'green'; }
  elseif ($inout == 'out') { $icon = 'red'; }
  $data['in'][$run]['in_out'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');
}


// Auszahlungen
$data['sort2']['date'] = cs_sort('cash','center',$start,0,1,$sort);
$data['sort2']['money'] = cs_sort('cash','center',$start,0,3,$sort);

$where = "cash_inout = 'out'";
$data['out'] = cs_sql_select(__FILE__,'cash','*',$where,$order,$start,$account['users_limit']);
$cash_loop = count($data['out']);

for($run=0; $run<$cash_loop; $run++) {

  $data['out'][$run]['date'] = cs_date('date',$data['out'][$run]['cash_time']);

  $data['out'][$run]['id'] = $data['out'][$run]['cash_id'];
  $text = $data['out'][$run]['cash_text'];
  $text = cs_substr($text, 0, 25);
  $data['out'][$run]['for'] = cs_secure($text);

  $data['out'][$run]['money'] = cs_secure($data['out'][$run]['cash_money']);

  $inout = $data['out'][$run]['cash_inout'];
  if ($inout == 'in') { $icon = 'green'; }
  elseif ($inout == 'out') { $icon = 'red'; }
  $data['out'][$run]['in_out'] = cs_html_img('symbols/clansphere/' . $icon . '.gif');
}
echo cs_subtemplate(__FILE__,$data,'cash','center');