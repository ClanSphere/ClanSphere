<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

$data = array();
$data['op'] = cs_sql_option(__FILE__, 'cash');

$users_nick = '';
$cs_cash['users_id'] = 0;

if(isset($_POST['submit'])) {
  
  $cs_cash['cash_inout'] = $_POST['cash_inout'];
  $cs_cash['cash_money'] = $_POST['cash_money'];
  $cs_cash['cash_text'] = $_POST['cash_text'];
  $cs_cash['cash_info'] = $_POST['cash_info'];
  $cs_cash['cash_time'] = cs_datepost('datum','date');

  $users_nick = empty($_REQUEST['users_nick']) ? '' : $_REQUEST['users_nick'];

  $error = '';

  $where = "users_nick = '" . cs_sql_escape($users_nick) . "'";
  $users_data = cs_sql_select(__FILE__, 'users', 'users_id', $where);
  if(empty($users_data['users_id'])) {
    $error .= $cs_lang['no_user'] . cs_html_br(1);
  }
  else
    $cs_cash['users_id'] = $users_data['users_id'];

  if(empty($cs_cash['cash_inout'])) {
    $error .= $cs_lang['no_inout'] . cs_html_br(1);
  }
  if(empty($cs_cash['cash_money'])) {
    $error .= $cs_lang['no_money'] . cs_html_br(1);
  }
  if(empty($cs_cash['cash_text'])) {
    $error .= $cs_lang['no_text'] . cs_html_br(1);
  }
  if(empty($cs_cash['cash_time'])) {
    $error .= $cs_lang['no_date'] . cs_html_br(1);
  }
}
else {

  $cs_cash['cash_inout'] = '';
  $cs_cash['cash_money'] = '';
  $cs_cash['cash_text'] = '';
  $cs_cash['cash_info'] = '';
  $cs_cash['users_id'] = $account['users_id'];
  $cs_cash['cash_time'] = cs_date('unix',cs_time(),0,1,'Y-m-d');
}

if(!isset($_POST['submit']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['body_info'];
} elseif (!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $data['cash'] = $cs_cash;
  $data['cash']['cash_money'] = cs_secure($data['cash']['cash_money'], 0, 0, 0);
  $data['cash']['cash_text'] = cs_secure($data['cash']['cash_text'], 0, 0, 0);
  $data['cash']['cash_info'] = cs_secure($data['cash']['cash_info'], 0, 0, 0);
  
  $cs_users = cs_sql_select(__FILE__,'users','users_nick,users_id','users_delete = "0"','users_nick',0,0);
  $data['cash']['users_sel'] = cs_dropdown('users_id','users_nick',$cs_users,$cs_cash['users_id']);

  $inoutlist[0]['cash_inout'] = 'in';
  $inoutlist[0]['name'] = $cs_lang['drop_in'];
  $inoutlist[1]['cash_inout'] = 'out';
  $inoutlist[1]['name'] = $cs_lang['drop_out'];
  $data['cash']['inout_sel'] = cs_dropdown('cash_inout','name',$inoutlist,$cs_cash['cash_inout']);

  $data['cash']['date_sel'] = cs_dateselect('datum','date',$cs_cash['cash_time'],2000);

  $data['cash']['abcode_smileys'] = cs_abcode_smileys('cash_info');
  $data['cash']['abcode_features'] = cs_abcode_features('cash_info');

  $data['users']['nick'] = cs_secure($users_nick, 0, 0, 0);

  echo cs_subtemplate(__FILE__,$data,'cash','create');
}
else {
  
  $cash_cells = array_keys($cs_cash);
  $cash_save = array_values($cs_cash);
  cs_sql_insert(__FILE__,'cash',$cash_cells,$cash_save);

  cs_redirect($cs_lang['create_done'],'cash');
}