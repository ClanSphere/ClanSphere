<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');
$cs_get = cs_get('id');
$data = array();

$squads_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$op_squads = cs_sql_option(__FILE__,'squads');
$data['head']['mod'] = $cs_lang[$op_squads['label'].'s'];

if(isset($_GET['agree'])) {

	$where = "squads_id = '" . $squads_id . "' AND users_id = '" . $account['users_id'] . "'";
	$search_admin = cs_sql_select(__FILE__,'members','members_admin',$where);

	if(empty($search_admin['members_admin'])) {
		$msg = $cs_lang['no_admin'];
	}
	else {
		$where = "squads_id = '" . $squads_id . "'";
		$getpic = cs_sql_select(__FILE__,'squads','squads_picture',$where);
		if(!empty($getpic['squads_picture'])) {
			cs_unlink('squads', $getpic['squads_picture']);
		}
		cs_sql_delete(__FILE__,'squads',$squads_id);
		cs_sql_delete(__FILE__,'members',$squads_id,'squads_id');
		$msg = $cs_lang['sq_del_true'];
	}

	if($account['access_squads'] >= 3) {
		$action = 'manage';
	} else {
		$action = 'center';
	}
  cs_redirect($msg,'squads',$action);
}

if(isset($_GET['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'squads');
}
else {

	$data['head']['body'] = sprintf($cs_lang['del_rly'],$squads_id);
	$data['url']['agree'] = cs_url('members','remove','id=' . $squads_id . '&amp;agree');
	$data['url']['cancel'] = cs_url('members','remove','id=' . $squads_id . '&amp;cancel');
	
  echo cs_subtemplate(__FILE__,$data,'squads','remove');

}

?>
