<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$languests_id = $_REQUEST['id'];
settype($languests_id,'integer');

if(isset($_POST['languests_team']) AND !empty($_REQUEST['id'])) {
  $array_keys = array('languests_team');
  $array_values = array($_POST['languests_team']);
  cs_sql_update(__FILE__,'languests',$array_keys,$array_values,$languests_id);
}

$error = 0;
$errormsg = '';

$where = "languests_id = '" . $languests_id . "'";
$languests = cs_sql_select(__FILE__,'languests','*',$where);
$select = 'lanpartys_bankaccount, lanpartys_name, lanpartys_id';
$where2 = "lanpartys_id = '" . $languests['lanpartys_id'] . "'";
$lanpartys = cs_sql_select(__FILE__,'lanpartys',$select,$where2);

if($languests['users_id'] != $account['users_id']) {
  $error++;
  $errormsg .= $cs_lang['userid_diff'] . cs_html_br(1);
}



$data['lang']['body'] = empty($error) ? $cs_lang['body_status'] : $errormsg;

$data['lang']['done'] = cs_link($cs_lang['my_center'],'lanpartys','center');

echo cs_subtemplate(__FILE__,$data,'lanpartys','head');

if(!empty($error)) {
  cs_redirect($cs_lang['elect_done'],'lanpartys','manage');
}
else {
  $data['lanpartys']['lanparty'] = cs_link(cs_secure($lanpartys['lanpartys_name']),'lanpartys','view','id=' . $lanpartys['lanpartys_id']);
  $data['url']['form'] = cs_url('lanpartys','status');
  $data['lanpartys']['team'] = $languests['languests_team'];
  $data['data']['id'] = $languests_id;

  if(isset($_POST['languests_team']) AND !empty($_REQUEST['id'])) {
    $data['lanpartys']['team_done'] = $cs_lang['team_done'];
  }
  else {
    $data['lanpartys']['team_done'] = '';
  }

  $data['lanpartys']['status'] = $cs_lang['status_' . $languests['languests_status']];
  $data['lanpartys']['money'] = cs_secure($languests['languests_money']);

  if(empty($languests['languests_paytime'])) {
    $data['lanpartys']['paytime'] = ' - ';
  }
  else {
    $data['lanpartys']['paytime'] = cs_date('unix',$languests['languests_paytime'],1);
  }

  $data['lanpartys']['bankaccount'] = cs_secure($lanpartys['lanpartys_bankaccount'],1);
  $data['lanpartys']['usage'] = $lanpartys['lanpartys_name'] . ' ' . cs_secure($account['users_nick']) . ' ' . $account['users_id'];
  
  echo cs_subtemplate(__FILE__,$data,'lanpartys','status');
}
?>
