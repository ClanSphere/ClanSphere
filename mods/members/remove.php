<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');
$cs_get = cs_get('id');
$data = array();

$members_id = empty($cs_get['id']) ? 0 : $cs_get['id'];

$op_members = cs_sql_option(__FILE__,'members');
$data['head']['mod'] = $cs_lang[$op_members['label']];

if(isset($_GET['agree'])) {
  cs_sql_delete(__FILE__,'members',$members_id);
  cs_redirect($cs_lang['del_true'], 'members');
}

if(isset($_GET['cancel']))
  cs_redirect($cs_lang['del_false'], 'members');

else {

  $data['head']['body'] = sprintf($cs_lang['remove_rly'],$members_id);
  $data['url']['agree'] = cs_url('members','remove','id=' . $members_id . '&amp;agree');
  $data['url']['cancel'] = cs_url('members','remove','id=' . $members_id . '&amp;cancel');

  echo cs_subtemplate(__FILE__,$data,'members','remove');
}
