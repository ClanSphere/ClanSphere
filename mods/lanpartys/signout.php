<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$languests_id = $_REQUEST['id'];
settype($languests_id,'integer');

$error = 0;
$errormsg = '';

$where = "languests_id = '" . $languests_id . "'";
$languests = cs_sql_select(__FILE__,'languests','*',$where);
$where2 = "lanpartys_id = '" . $languests['lanpartys_id'] . "'";
$lanpartys = cs_sql_select(__FILE__,'lanpartys','lanpartys_end',$where2);

if($languests['users_id'] != $account['users_id']) {
  $error++;
  $errormsg .= $cs_lang['userid_diff'] . cs_html_br(1);
}

if(!empty($languests['languests_money']) OR $languests['languests_status'] > 2) {
  $error++;
  $errormsg .= $cs_lang['payed_for'] . cs_html_br(1);
}

if($lanpartys['lanpartys_end'] < cs_time()) {
  $error++;
  $errormsg .= $cs_lang['event_done'] . cs_html_br(1);
}

if(isset($_GET['agree']) AND empty($error)) {
  cs_sql_delete(__FILE__,'languests',$languests_id);

  cs_redirect($cs_lang['signout_true'],'lanpartys','center');
}
elseif(isset($_GET['cancel']) OR !empty($error)) {
  cs_redirect(empty($error) ? $cs_lang['signout_false'] : $errormsg,'lanpartys','center');
}
else {
  $data['lang']['remove'] = $cs_lang['head_signout'];
  
  $data['lang']['body'] = $cs_lang['signout_confirm'];
  
  $data['lang']['content'] = cs_link($cs_lang['confirm'],'lanpartys','signout','id=' . $languests_id . '&amp;agree');
  $data['lang']['content'] .= ' - ';
  $data['lang']['content'] .= cs_link($cs_lang['cancel'],'lanpartys','signout','id=' . $languests_id . '&amp;cancel');
	
  echo cs_subtemplate(__FILE__,$data,'lanpartys','remove');
}
?>
