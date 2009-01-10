<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('fightus');
$cs_get = cs_get('id');
$data = array();

$fightus_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'fightus',$fightus_id);
  cs_redirect($cs_lang['fight_del_true'], 'fightus');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'fightus');

else {
	$data['head']['body'] = sprintf($cs_lang['del_rly'],$fightus_id);
	$data['url']['agree'] = cs_url('fightus','remove','id=' . $fightus_id . '&amp;agree');
	$data['url']['cancel'] = cs_url('fightus','remove','id=' . $fightus_id . '&amp;cancel');

	echo cs_subtemplate(__FILE__,$data,'fightus','remove');
}

?>
