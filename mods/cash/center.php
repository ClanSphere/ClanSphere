<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'cash_time DESC';
$cs_sort[2] = 'cash_time ASC';
$cs_sort[3] = 'cash_money DESC';
$cs_sort[4] = 'cash_money ASC';
$cs_sort[5] = 'cash_inout DESC';
$cs_sort[6] = 'cash_inout ASC';
empty($_REQUEST['sort']) ? $sort = 1 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$cash_count = cs_sql_count(__FILE__,'cash');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['mod'] . ' - ' . $cs_lang['head'];
echo cs_html_roco(0);
echo cs_html_roco(1,'centerb');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $cash_count; 
echo cs_html_roco(2,'rightb');
echo cs_pages('cash','center',$cash_count,$start,0,$sort);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

// Kontodaten
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,2);
echo $cs_lang['kt'];
echo cs_html_roco(0);
$konto = cs_sql_select(__FILE__,'account','*',0,0,0);
$konto_count = count($konto);

if(!empty($konto_count)) {
  echo cs_html_roco(1,'leftb',0,0,'150px');
  echo $cs_lang['owner'];
  echo cs_html_roco(2,'leftc');
  echo $konto['account_owner'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftb');
  echo $cs_lang['number'];
  echo cs_html_roco(2,'leftc');
  echo $konto['account_number'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftb');
  echo $cs_lang['bcn'];
  echo cs_html_roco(2,'leftc');
  echo $konto['account_bcn'];
  echo cs_html_roco(0);

  echo cs_html_roco(1,'leftb');
  echo $cs_lang['bank'];
  echo cs_html_roco(2,'leftc');
  echo $konto['account_bank'];
  echo cs_html_roco(0);

  if(!empty($konto['account_iban'])) {
    echo cs_html_roco(1,'leftb');
    echo $cs_lang['iban'];
    echo cs_html_roco(2,'leftc');
    echo $konto['account_iban'];
    echo cs_html_roco(0);
  }

  if(!empty($konto['account_bic'])) {
    echo cs_html_roco(1,'leftb');
    echo $cs_lang['bic'];
    echo cs_html_roco(2,'leftc');
    echo $konto['account_bic'];
    echo cs_html_roco(0);
  }
} else {
  echo cs_html_roco(1,'centerb');
  echo $cs_lang['nonumber'];
  echo cs_html_roco(0);
}
echo cs_html_table(0);
echo cs_html_br(1);
// Ende Kontodaten



echo cs_html_table(1,'forum',1);

$money = 0;
$where = "cash_inout = 'in'"; 
$cs_cash_overview = cs_sql_select(__FILE__,'cash','cash_money',$where,0,0,0);
$over_loop = count($cs_cash_overview);
for($run=0; $run<$over_loop; $run++) {
$money = $money + $cs_cash_overview[$run]['cash_money'];
}
$money_in = $money;
$money = 0;
$where = "cash_inout = 'out'"; 
$cs_cash_overview = cs_sql_select(__FILE__,'cash','cash_money',$where,0,0,0);
$over_loop = count($cs_cash_overview);
for($run=0; $run<$over_loop; $run++) {
$money = $money + $cs_cash_overview[$run]['cash_money'];
}
$money_out = $money;
$money_now = $money_in - $money_out;
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['mod'] . ' - ' . $cs_lang['overview'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,0,10);
echo cs_html_img('symbols/clansphere/green.gif');
echo cs_html_roco(2,'rightb',0,0,20);
echo $cs_lang['in'];
echo cs_html_roco(3,'leftb');
echo cs_secure($money_in .' '. $cs_lang['euro']);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb',0,0,10);
echo cs_html_img('symbols/clansphere/red.gif');
echo cs_html_roco(2,'rightb',0,0,20);
echo $cs_lang['out'];
echo cs_html_roco(3,'leftb');
echo cs_secure($money_out .' '. $cs_lang['euro']);
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc',0,0,10);
echo cs_html_img('symbols/clansphere/grey.gif');
echo cs_html_roco(2,'rightc',0,0,20);
echo $cs_lang['now'];
echo cs_html_roco(3,'leftc');
echo cs_secure($money_now .' '. $cs_lang['euro']);
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

// User Finanzen
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,5);
echo $cs_lang['mycash'];
echo cs_html_roco(0);
echo cs_html_roco(1,'headb');
echo cs_sort('cash','center',$start,0,1,$sort);
echo $cs_lang['date'];
echo cs_html_roco(2,'headb');
echo $cs_lang['for'];
echo cs_html_roco(3,'headb');
echo cs_sort('cash','center',$start,0,3,$sort);
echo $cs_lang['money'];
echo cs_html_roco(4,'headb',0,2);
echo cs_sort('cash','center',$start,0,5,$sort);
echo $cs_lang['options'];
echo cs_html_roco(0);

$where = "users_id = '" . $account['users_id'] . "'";
$cs_cash = cs_sql_select(__FILE__,'cash','*',$where,$order,$start,$account['users_limit']);
$cash_loop = count($cs_cash);

for($run=0; $run<$cash_loop; $run++) {
        
	echo cs_html_roco(1,'leftc');
	echo cs_date('date',$cs_cash[$run]['cash_time']);
    echo cs_html_roco(2,'leftc');
	$text1 = $cs_cash[$run]['cash_text'];
	$text2 = substr($text1, 0, 25);
	echo cs_secure($text2);
	echo cs_html_roco(3,'leftc');
	echo cs_secure($cs_cash[$run]['cash_money'] .' '. $cs_lang['euro']);
	echo cs_html_roco(4,'centerc');
	$inout = $cs_cash[$run]['cash_inout'];
	if ($inout == 'in') {
	$icon = 'green'; } else {
	if ($inout == 'out') {
	$icon = 'red'; }}
	echo cs_html_img('symbols/clansphere/' . $icon . '.gif');
	echo cs_html_roco(5,'centerc');
  $img_edit = cs_icon('documentinfo');
	echo cs_link($img_edit,'cash','view','id=' . $cs_cash[$run]['cash_id'],0,$cs_lang['edit']);
	echo cs_html_roco(0);
}

echo cs_html_table(0);

// Komplette Finanzen
/*$cs_cash = cs_sql_select(__FILE__,'cash','*',0,$order,$start,$account['users_limit']);
$cash_loop = count($cs_cash);
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo cs_sort('cash','center',$start,0,1,$sort);
echo $cs_lang['date'];
echo cs_html_roco(2,'headb');
echo $cs_lang['for'];
echo cs_html_roco(3,'headb');
echo cs_sort('cash','center',$start,0,3,$sort);
echo $cs_lang['money'];
echo cs_html_roco(4,'headb');
echo cs_sort('cash','center',$start,0,5,$sort);
echo cs_html_roco(5,'headb');
echo cs_html_roco(0);

for($run=0; $run<$cash_loop; $run++) {
        
	echo cs_html_roco(1,'leftc');
	echo cs_date('date',$cs_cash[$run]['cash_time']);
  echo cs_html_roco(2,'leftc');
	$text1 = $cs_cash[$run]['cash_text'];
	$text2 = substr($text1, 0, 25);
	echo cs_secure($text2);
	echo cs_html_roco(3,'leftc');
	echo cs_secure($cs_cash[$run]['cash_money'] .' '. $cs_lang['euro']);
	echo cs_html_roco(4,'centerc');
	$inout = $cs_cash[$run]['cash_inout'];
	if ($inout == 'in') {
	$icon = 'green'; } else {
	if ($inout == 'out') {
	$icon = 'red'; }}
	echo cs_html_img('symbols/clansphere/' . $icon . '.gif');
	echo cs_html_roco(5,'centerc');
  $img_edit = cs_icon('documentinfo');
	echo cs_link($img_edit,'cash','view','id=' . $cs_cash[$run]['cash_id'],0,$cs_lang['edit']);
	echo cs_html_roco(0);
}

echo cs_html_table(0);*/

echo cs_html_br(1);

// Auszahlungen
echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,6);
echo $cs_lang['out'];
echo cs_html_roco(0);
echo cs_html_roco(1,'headb');
echo $cs_lang['nick'];
echo cs_html_roco(2,'headb');
echo cs_sort('cash','center',$start,0,1,$sort);
echo $cs_lang['date'];
echo cs_html_roco(3,'headb');
echo $cs_lang['for'];
echo cs_html_roco(4,'headb');
echo cs_sort('cash','center',$start,0,3,$sort);
echo $cs_lang['money'];
echo cs_html_roco(5,'headb',0,2);
echo cs_sort('cash','center',$start,0,5,$sort);
echo $cs_lang['options'];
echo cs_html_roco(0);

$where = "cash_inout = 'out'";
$cs_cash = cs_sql_select(__FILE__,'cash','*',$where,$order,$start,$account['users_limit']);
$cash_loop = count($cs_cash);

for($run=0; $run<$cash_loop; $run++) {
        
	echo cs_html_roco(1,'leftc');
	$data_users = cs_sql_select(__FILE__,'users','users_nick, users_id',"users_id = '" . $cs_cash[$run]['users_id'] . "'",'users_nick',0);
	echo $data_users['users_nick'];
	echo cs_html_roco(2,'leftc');
	echo cs_date('date',$cs_cash[$run]['cash_time']);
    echo cs_html_roco(3,'leftc');
	$text1 = $cs_cash[$run]['cash_text'];
	$text2 = substr($text1, 0, 25);
	echo cs_secure($text2);
	echo cs_html_roco(4,'leftc');
	echo cs_secure($cs_cash[$run]['cash_money'] .' '. $cs_lang['euro']);
	echo cs_html_roco(5,'centerc');
	$inout = $cs_cash[$run]['cash_inout'];
	if ($inout == 'in') {
	$icon = 'green'; } else {
	if ($inout == 'out') {
	$icon = 'red'; }}
	echo cs_html_img('symbols/clansphere/' . $icon . '.gif');
	echo cs_html_roco(6,'centerc');
  $img_edit = cs_icon('documentinfo');
	echo cs_link($img_edit,'cash','view','id=' . $cs_cash[$run]['cash_id'],0,$cs_lang['edit']);
	echo cs_html_roco(0);
}

echo cs_html_table(0);

?>