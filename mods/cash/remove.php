<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('cash');
$cs_get = cs_get('id');
$data = array();

$cash_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
	cs_sql_delete(__FILE__,'cash',$cash_id);
	cs_redirect($cs_lang['del_true'],'cash');
}

if(isset($_GET['cancel'])) {
	cs_redirect($cs_lang['del_false'],'cash');
}
else {

	$data['head']['body'] = sprintf($cs_lang['del_rly'],$cash_id);
	$data['url']['agree'] = cs_url('cash','remove','id=' . $cash_id . '&amp;agree');
	$data['url']['cancel'] = cs_url('cash','remove','id=' . $cash_id . '&amp;cancel');

	echo cs_subtemplate(__FILE__,$data,'cash','remove');
}
?>