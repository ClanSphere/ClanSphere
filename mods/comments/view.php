<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('comments');

$data = array();

$com_id = $_GET['id'];
settype($com_id,'integer');
$select =  'comments_id, users_id, comments_fid, comments_mod, comments_text, comments_time, comments_ip, comments_guestnick';
$cs_com = cs_sql_select(__FILE__,'comments',$select,"comments_id = '" . $com_id . "'");

if(!empty($cs_com['users_id'])) {
  $cs_user = cs_sql_select(__FILE__,'users','users_id, users_nick, users_active, users_delete',"users_id ='".$cs_com['users_id']."'",0,0);
  $data['com']['user'] = cs_user($cs_com['users_id'],$cs_user['users_nick'],$cs_user['users_active'],$cs_user['users_delete']);
} else {
  $data['com']['user'] = $cs_com['comments_guestnick'] . ' ' . $cs_lang['guest'];
}

$data['com']['time'] = cs_date('unix',$cs_com['comments_time'],1);
$data['com']['ip'] = $cs_com['comments_ip'];

$com_mod = $cs_com['comments_mod'];
$modules = cs_checkdirs('mods');
foreach($modules as $mods) {
  if($mods['dir'] == $com_mod) {
     $data['com']['mod'] = $mods['name'];
  }
}

$data['com']['fid'] = $cs_com['comments_fid'];
$data['com']['text'] = cs_secure($cs_com['comments_text'],1,1);


echo cs_subtemplate(__FILE__,$data,'comments','view');