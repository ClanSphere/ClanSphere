<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wars');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'] . ' - ' . $cs_lang['join'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftc');

if (empty($_POST['submit'])) {

	$wars_id = (int) $_GET['id'];
	
	$error = '';
	
	$warselect = cs_sql_select(__FILE__,'wars','squads_id','wars_id = \''.$wars_id.'\' AND wars_status = \'upcoming\'');
	
	if (empty($warselect)) {
		$error .= cs_html_br(1) . $cs_lang['not_upcoming'];
	}
	
	$condition = 'users_id = \''.$account['users_id'].'\' AND squads_id = \''.$warselect['squads_id'].'\'';
	$squadmember = cs_sql_count(__FILE__,'members',$condition);
	
	if (empty($squadmember)) {
		$error .= cs_html_br(1) . $cs_lang['no_squadmember'];
	}
	
	
	
	if (!empty($error)) {
		
		echo $cs_lang['error_occured'];
		echo $error;
		echo cs_html_br(1) . cs_link($cs_lang['back'],'wars','view','id='.$wars_id);
	
	} else {
		
		echo $cs_lang['join_war'];
		echo cs_html_form(1,'warjoin','wars','join');
		echo cs_html_select(1,'players_status');
		echo cs_html_option($cs_lang['yes'],'yes');
		echo cs_html_option($cs_lang['maybe'],'maybe');
		echo cs_html_option($cs_lang['no'],'no');
		echo cs_html_select(0);
		echo cs_html_vote('wars_id',$wars_id,'hidden');
		echo cs_html_vote('submit',$cs_lang['confirm'],'submit');
		echo cs_html_form(0);
		
	}
} else {
	
	$wars_id = (int) $_POST['wars_id'];
	
	$error = '';
	
	$warselect = cs_sql_select(__FILE__,'wars','squads_id','wars_id = \''.$wars_id.'\' AND wars_status = \'upcoming\'');
	
	if (empty($warselect)) {
		$error .= cs_html_br(1) . $cs_lang['not_upcoming'];
	}
	
	$condition = 'users_id = \''.$account['users_id'].'\' AND squads_id = \''.$warselect['squads_id'].'\'';
	$squadmember = cs_sql_count(__FILE__,'members',$condition);
	
	if (empty($squadmember)) {
		$error .= cs_html_br(1) . $cs_lang['no_squadmember'];
	}
	
	if (!empty($error)) {
		
		echo $cs_lang['error_occured'];
		echo $error;
		echo cs_html_br(1) . cs_link($cs_lang['back'],'wars','view','id='.$wars_id);
	
	} else {
	
		$cs_players['users_id'] = $account['users_id'];
		$cs_players['wars_id'] = (int) $_POST['wars_id'];
		$cs_players['players_status'] = $_POST['players_status'];
		$cs_players['players_time'] = cs_time();
		
		$cells = array_keys($cs_players);
		$values = array_values($cs_players);
		
		cs_sql_insert(__FILE__,'players',$cells,$values);
		

		cs_redirect($cs_lang['success'],'wars','view','id='.$cs_players['wars_id']);
	
	}
}

echo cs_html_roco(0);
echo cs_html_table(0);

?>