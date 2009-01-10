<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('gbook');

$data['head']['mod'] = $cs_lang['mod_name'];
$data['head']['action'] = $cs_lang['ip'];

$gbook_id = $_REQUEST['id'];
settype($gbook_id,'integer');
$action = $_REQUEST['action1'];

$gbook_show = cs_sql_select(__FILE__,'gbook','*',"gbook_id = '" . $gbook_id . "'");
$gbook_ip = $gbook_show['gbook_ip'];

if($account['access_gbook'] == 4) {
	$last = strlen(substr(strrchr ($gbook_ip, '.'), 1 ));
	$ip = strlen($gbook_ip);
	$ip = substr($gbook_ip,0,$ip-$last);
	$ip = $ip . '*';
	$data['data']['ip'] = $ip;
}
if($account['access_gbook'] == 5) {
	$data['lang']['ip_incomplet'] = '';
	$data['data']['ip'] = $gbook_ip;
}
$data['link']['continue'] = cs_link($cs_lang['continue'],'gbook',$action);
echo cs_subtemplate(__FILE__,$data,'gbook','ip');
?>