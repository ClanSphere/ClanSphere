<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$lanpartys_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];
settype($lanpartys_id,'integer');

$error = '';

$where = "lanpartys_id = '" . $lanpartys_id . "' AND users_id ='" . $account['users_id'] . "'";
$languests = cs_sql_count(__FILE__,'languests',$where);
$where2 = "lanpartys_id = '" . $lanpartys_id . "'";
$lanpartys = cs_sql_select(__FILE__,'lanpartys','lanpartys_end',$where2);

if(empty($lanpartys_id) OR empty($lanpartys))
  $error .= $cs_lang['no_lan'] . cs_html_br(1);
elseif($lanpartys['lanpartys_end'] < cs_time())
  $error .= $cs_lang['event_done'] . cs_html_br(1);
elseif(!empty($languests))
  $error .= $cs_lang['user_found'] . cs_html_br(1);

if(empty($error)) {
  $array_keys = array('lanpartys_id','users_id','languests_status','languests_since');
  $array_values = array($lanpartys_id,$account['users_id'],1,cs_time());
  cs_sql_insert(__FILE__,'languests',$array_keys,$array_values);

  $select = 'lanpartys_name, lanpartys_money, lanpartys_bankaccount, lanpartys_url';
  $cs_lans = cs_sql_select(__FILE__,'lanpartys',$select,"lanpartys_id = '" . $lanpartys_id . "'");
  $cs_user = cs_sql_select(__FILE__,'users','users_email',"users_id = '" . $account['users_id'] . "'");

  $content = sprintf($cs_lang['mail_start'],$account['users_nick']);
  $content .= sprintf($cs_lang['mail_party'],$cs_lans['lanpartys_name']);
  $content .= $cs_lang['mail_place'] . $cs_lang['mail_pay'] . $cs_lans['lanpartys_money'];
  $content .= $cs_lang['mail_bank'] . $cs_lans['lanpartys_bankaccount'];
  $content .= $cs_lang['mail_usage'] . $cs_lans['lanpartys_name'] . ' ';
  $content .= $account['users_nick'] . ' ' . $account['users_id'];
  $content .= $cs_lang['mail_more'] . $cs_lang['mail_contact'];
  $content .= $cs_lang['mail_page'] . $cs_lans['lanpartys_url'] . $cs_lang['mail_end'];
  cs_mail($cs_user['users_email'],$cs_lang['mail_head'],$content);

  $msg = $cs_lang['body_signin'];
}
else {
  $msg = $error;
}
  
cs_redirect($msg,'lanpartys','center');

?>