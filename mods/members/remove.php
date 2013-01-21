<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');
$cs_get = cs_get('id,agree,cancel');

if(isset($cs_get['agree'])) {
  cs_sql_delete(__FILE__,'members',$cs_get['id']);
  cs_redirect($cs_lang['del_true'], 'members');
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'members');
}

$tables = 'members mem INNER JOIN {pre}_users usr on usr.users_id = mem.users_id';
$where = 'mem.members_id = ' . $cs_get['id'];
$member = cs_sql_select(__FILE__,$tables,'usr.users_nick',$where,0,0,1);
if(!empty($member)) {
  $data = array();
  $op_members = cs_sql_option(__FILE__,'members');
  $data['head']['mod'] = $cs_lang[$op_members['label']];
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$data['head']['mod'],$member['users_nick']);
  $data['url']['agree'] = cs_url('members','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('members','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'members','remove');
}
else {
  cs_redirect('','members');
}
