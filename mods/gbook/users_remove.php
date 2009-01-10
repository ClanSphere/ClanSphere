<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

$gbook_form = 1;
$gbook_id = $_REQUEST['id'];
settype($gbook_id,'integer');

if (isset($_POST['agree']))
{
	$gbook_form = 0;
	$where = "gbook_id = '" . $gbook_id . "'";
	$user_check = cs_sql_select(__FILE__,'gbook','gbook_users_id',$where);
	if($user_check['gbook_users_id'] == $account['users_id'])
	{
		cs_sql_delete(__FILE__,'gbook',$gbook_id);
		$msg = $cs_lang['del_true'];
	}
	else
	{
		$msg = $cs_lang['del_false'];
		$msg .= $cs_lang['del_noaccess'];
	}

	cs_redirect($msg,'gbook','center');
}

if (isset($_POST['cancel']))
{
	$gbook_form = 0;
	
	cs_redirect($cs_lang['del_false'],'gbook','center');
}

if(!empty($gbook_form))
{
	echo cs_html_table(1,'forum',1);
    echo cs_html_roco(1,'headb');
    echo $cs_lang['mod_name'] . ' - ' . $cs_lang['head_remove'];
    echo cs_html_roco(0);
    echo cs_html_roco(1,'leftb');
	echo sprintf($cs_lang['del_rly'],$gbook_id);
	echo cs_html_roco(0);

	echo cs_html_roco(1,'centerc');
	echo cs_html_form(1,'gbook_remove','gbook','users_remove');
	echo cs_html_vote('id',$gbook_id,'hidden');
	echo cs_html_vote('agree',$cs_lang['confirm'],'submit');
	echo cs_html_vote('cancel',$cs_lang['cancel'],'submit');
	echo cs_html_form (0);
	echo cs_html_roco(0);
	echo cs_html_table(0);
}
?>