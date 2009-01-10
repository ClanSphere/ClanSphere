<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('lanpartys');

$lanpartys_id = $_REQUEST['id'];
settype($lanpartys_id,'integer');
$cs_lanpartys = cs_sql_select(__FILE__,'lanpartys','*','lanpartys_id = ' . $lanpartys_id);

$data['lang']['addons'] = cs_addons('lanpartys','view',$lanpartys_id,'lanpartys');
$data['lang']['getmsg'] = cs_getmsg();
$where = "lanpartys_id = '" . $lanpartys_id . "' AND users_id = '" . $account['users_id'] . "'";
$status = cs_sql_select(__FILE__,'languests','languests_status, languests_id',$where);

if(empty($status['languests_status'])) {
  $data['lanpartys']['status'] = cs_link($cs_lang['status_0'],'lanpartys','signin','id=' . $lanpartys_id);
}
else {
  $data['lanpartys']['status'] = cs_link($cs_lang['status_' . $status['languests_status']],'lanpartys','status','id=' . $status['languests_id']);
}

$data['lanpartys']['name'] = cs_secure($cs_lanpartys['lanpartys_name']);
$data['lanpartys']['url'] = cs_html_link('http://' . cs_secure($cs_lanpartys['lanpartys_url']),cs_secure($cs_lanpartys['lanpartys_url']));
$data['lanpartys']['start'] = cs_date('unix',$cs_lanpartys['lanpartys_start'],1);
$data['lanpartys']['end'] = cs_date('unix',$cs_lanpartys['lanpartys_end'],1);
$data['lanpartys']['maxguests'] = cs_secure($cs_lanpartys['lanpartys_maxguests']);
$data['lanpartys']['money'] = cs_secure($cs_lanpartys['lanpartys_money']);
$data['lanpartys']['needage'] = cs_secure($cs_lanpartys['lanpartys_needage']);
$data['lanpartys']['location'] = cs_secure($cs_lanpartys['lanpartys_location']);

if(empty($cs_lanpartys['lanpartys_pictures'])) {
  $data['lanpartys']['pictures'] = $cs_lang['nopic'];
}
else {
  $lanpartys_pics = explode("\n",$cs_lanpartys['lanpartys_pictures']);
  foreach($lanpartys_pics AS $pic) {
    $link = cs_html_img('uploads/lanpartys/thumb-' . $pic);
    $data['lanpartys']['pictures'] = cs_html_link('uploads/lanpartys/picture-' . $pic,$link) . ' ';
  }
}

$data['lanpartys']['adress'] = cs_secure($cs_lanpartys['lanpartys_adress']);

$data['lanpartys']['postal_place'] = $cs_lanpartys['lanpartys_postalcode'];
$data['lanpartys']['lanpartys_place'] = cs_secure($cs_lanpartys['lanpartys_place']);

$data['lanpartys']['network'] = cs_secure($cs_lanpartys['lanpartys_network'],1);
$data['lanpartys']['tournaments'] = cs_secure($cs_lanpartys['lanpartys_tournaments'],1);
$data['lanpartys']['features'] = cs_secure($cs_lanpartys['lanpartys_features'],1);
$data['lanpartys']['more'] = cs_secure($cs_lanpartys['lanpartys_more'],1);

echo cs_subtemplate(__FILE__,$data,'lanpartys','view');

?>