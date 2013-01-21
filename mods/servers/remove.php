<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');
$cs_post = cs_post('id');
$cs_get = cs_get('id');
$servers_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  cs_sql_delete(__FILE__,'servers',$servers_id);
  cs_redirect($cs_lang['del_true'], 'servers');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'servers');
}

$server = cs_sql_select(__FILE__,'servers','servers_name','servers_id = ' . $servers_id,0,0,1);
if(!empty($server)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_name'],$server['servers_name']);
  $data['servers']['id'] = $servers_id;
  echo cs_subtemplate(__FILE__,$data,'servers','remove');
}
else {
  cs_redirect('','servers');
}