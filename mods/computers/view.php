<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('computers');
$cs_get = cs_get('id');
$data = array();

$cs_computers_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$cs_computers = cs_sql_select(__FILE__,'computers','*',"computers_id = '" . $cs_computers_id . "'");


$who = "users_id = '" . $cs_computers['users_id'] . "'";
$cs_users = cs_sql_select(__FILE__,'users','users_nick, users_active, users_delete',$who);
$data['com']['user'] = cs_user($cs_computers['users_id'],$cs_users['users_nick'], $cs_users['users_active'], $cs_users['users_delete']);

$data['com']['since'] = cs_date('unix',$cs_computers['computers_since'],1);
$data['com']['name'] = cs_secure($cs_computers['computers_name']);
$data['com']['software'] = cs_secure($cs_computers['computers_software']);
$data['com']['mainboard'] = cs_secure($cs_computers['computers_mainboard']);
$data['com']['memory'] = cs_secure($cs_computers['computers_memory']);

if(empty($cs_computers['computers_pictures'])) {
  $data['pictures'][0]['thumb'] = $cs_lang['nopic'];
}
else {
  $run = 0;
  $computer_pics = explode("\n",$cs_computers['computers_pictures']);
  foreach($computer_pics AS $pic) {
    $link = cs_html_img('uploads/computers/thumb-' . $pic);
    $data['pictures'][$run]['thumb'] = cs_html_link('uploads/computers/picture-' . $pic,$link) . ' ';
    $run++;
  }
}

$data['com']['processors'] = cs_secure($cs_computers['computers_processors']);
$data['com']['graphics'] = cs_secure($cs_computers['computers_graphics']);
$data['com']['sounds'] = cs_secure($cs_computers['computers_sounds']);
$data['com']['harddisks'] = cs_secure($cs_computers['computers_harddisks']);
$data['com']['drives'] = cs_secure($cs_computers['computers_drives']);
$data['com']['screens'] = cs_secure($cs_computers['computers_screens']);
$data['com']['interfaces'] = cs_secure($cs_computers['computers_interfaces']);
$data['com']['networks'] = cs_secure($cs_computers['computers_networks']);
$data['com']['more'] = cs_secure($cs_computers['computers_more']);


echo cs_subtemplate(__FILE__,$data,'computers','view');

?>