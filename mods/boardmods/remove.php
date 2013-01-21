<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('boardmods');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$boardmodid = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if(isset($cs_post['agree'])) {
  cs_sql_delete(__FILE__,'boardmods',$boardmodid);
  cs_redirect($cs_lang['del_true'], 'boardmods');
}

if(isset($cs_post['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'boardmods');
}

$tables = 'boardmods bmo INNER JOIN {pre}_users usr ON usr.users_id = bmo.users_id';
$where = 'bmo.boardmods_id = ' . $boardmodid;
$boardmod = cs_sql_select(__FILE__,$tables,'usr.users_nick',$where,0,0,1);
if(!empty($boardmod)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['mod_remove'],$boardmod['users_nick']);
  $data['boardmod']['id'] = $boardmodid;
  echo cs_subtemplate(__FILE__,$data,'boardmods','remove');
}
else {
  cs_redirect('','boardmods');
}
