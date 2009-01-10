<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['edit_status'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');

if (empty($_POST['submit'])) {

	$wars_id = (int) $_GET['id'];
	
	$condition = 'users_id = \''.$account['users_id'].'\' AND wars_id = \''.$wars_id.'\'';
	$select = cs_sql_select(__FILE__,'players','players_id, players_status',$condition);
	
	echo $cs_lang['join_war'];
	echo cs_html_form(1,'statusedit','wars','statusedit');
	echo cs_html_select(1,'players_status');
	echo cs_html_option($cs_lang['yes'],'yes',$select['players_status'] == 'yes' ? 1 : 0);
	echo cs_html_option($cs_lang['maybe'],'maybe',$select['players_status'] == 'maybe' ? 1 : 0);
	echo cs_html_option($cs_lang['no'],'no',$select['players_status'] == 'no' ? 1 : 0);
	echo cs_html_select(0);
	echo cs_html_vote('players_id',$select['players_id'],'hidden');
	echo cs_html_vote('wars_id',$wars_id,'hidden');
	echo cs_html_vote('submit',$cs_lang['edit'],'submit');
	echo cs_html_form(0);

} else {
	
	$players_id = (int) $_POST['players_id'];
	$wars_id = (int) $_POST['wars_id'];
	
	$cs_players['players_status'] = $_POST['players_status'];
	$cs_players['players_time'] = cs_time();
	
	$cells = array_keys($cs_players);
	$values = array_values($cs_players);
	
	cs_sql_update(__FILE__,'players',$cells,$values,$players_id);
	

	cs_redirect($cs_lang['success'],'wars','view','id='.$wars_id);

}

echo cs_html_roco(0);
echo cs_html_table(0);

?>