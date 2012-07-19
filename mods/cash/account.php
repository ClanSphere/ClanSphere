<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');

$data['if']['form'] = 0;
$data['if']['ready'] = 0;
$data['if']['id'] = 0;


if(isset($_POST['submit'])) {
  $data['account']['account_owner'] = $_POST['owner'];
  $data['account']['account_number'] = $_POST['number'];
  $data['account']['account_bcn'] = $_POST['bcn'];
  $data['account']['account_bank'] = $_POST['bank'];
  $data['account']['account_iban'] = $_POST['iban'];
  $data['account']['account_bic'] = $_POST['bic'];
  if(!empty($_POST['id'])) {
      $data['id']['account_id'] = (int)$_POST['id'];
    $data['if']['id'] = 1;
  }
  
  $error = '';
  
  if(empty($data['account']['account_owner'])) {
    $error .= $cs_lang['no_owner'] . cs_html_br(1);
  }
  if(empty($data['account']['account_number'])) {
    $error .= $cs_lang['no_number'] . cs_html_br(1);
  }
  if(empty($data['account']['account_bcn'])) {
    $error .= $cs_lang['no_bcn'] . cs_html_br(1);
  }  
  if(empty($data['account']['account_bank'])) {
    $error .= $cs_lang['no_bank'] . cs_html_br(1);
  }

} else {

  $konto_daten = cs_sql_select(__FILE__,'account','*',0,0,0);
  $konto_count = count($konto_daten);
  if(!empty($konto_count)) {
    $data['if']['id'] = 1;
    $data['account']['account_owner'] = cs_secure($konto_daten['account_owner'], 0, 0, 0);
    $data['account']['account_number'] = cs_secure($konto_daten['account_number'], 0, 0, 0);
    $data['account']['account_bcn'] = cs_secure($konto_daten['account_bcn'], 0, 0, 0);
    $data['account']['account_bank'] = cs_secure($konto_daten['account_bank'], 0, 0, 0);
    $data['account']['account_iban'] = cs_secure($konto_daten['account_iban'], 0, 0, 0);
    $data['account']['account_bic'] = cs_secure($konto_daten['account_bic'], 0, 0, 0);
  $data['id']['account_id'] = $konto_daten['account_id'];
  } else {
    $data['account']['account_owner'] = '';
    $data['account']['account_number'] = '';
    $data['account']['account_bcn'] = '';
    $data['account']['account_bank'] = '';
    $data['account']['account_iban'] = '';
    $data['account']['account_bic'] = '';
  }
}

if(!isset($_POST['submit'])) {
  $data['table']['body'] = $cs_lang['body_info'];
}
elseif(!empty($error)) {
  $data['table']['body'] = $error;
}
else {
  $data['if']['form'] = 0;
  $data['table']['body'] = $cs_lang['create_done'];
}

if(!empty($error) OR !isset($_POST['submit'])) {
  $data['if']['form'] = 1;
} else {
  $data['if']['ready'] = 1;
  
  if(!empty($data['if']['id'])) {
    $cash_cells = array_keys($data['account']);
    $cash_save = array_values($data['account']);
    cs_sql_update(__FILE__,'account',$cash_cells,$cash_save,$data['id']['account_id']);

  cs_redirect($cs_lang['changes_done'],'cash','manage');
  } else { 
    $cash_cells = array_keys($data['account']);
    $cash_save = array_values($data['account']);
    cs_sql_insert(__FILE__,'account',$cash_cells,$cash_save);
  
  cs_redirect($cs_lang['create_done'],'cash','manage');
  }
}
echo cs_subtemplate(__FILE__,$data,'cash','account');