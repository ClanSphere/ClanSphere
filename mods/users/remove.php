<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');
$cs_get = cs_get('id');
$data = array();

$users_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
	cs_sql_delete(__FILE__,'users',$users_id);
	cs_redirect($cs_lang['del_true'], 'users');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'users');

else {
	
	$data['head']['body'] = sprintf($cs_lang['del_rly'],$users_id);
	$data['url']['agree'] = cs_url('users','remove','id=' . $users_id . '&amp;agree');
	$data['url']['cancel'] = cs_url('users','remove','id=' . $users_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'users','remove');
}

?>
