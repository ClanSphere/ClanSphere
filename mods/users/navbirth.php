<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$select = 'users_id, users_nick, users_age, users_active';
$where = "users_age LIKE '%-" . cs_datereal('m') . "-" .  cs_datereal('d') . "' AND users_hidden NOT LIKE '%users_age%' AND users_active = '1'";
$order = 'users_nick ASC';
$cs_users = cs_sql_select(__FILE__,'users',$select,$where,$order,0,4);

if(empty($cs_users)) {
	echo $cs_lang['no_data'];
}
else {
	foreach ($cs_users AS $users) {
		echo cs_user($users['users_id'], $users['users_nick'], $users['users_active']);
		$birth = explode ('-', $users['users_age']);
		$age = cs_datereal('Y') - $birth[0];
		echo ' (' . $age . ')';
		echo cs_html_br(1);
	}
}

?>