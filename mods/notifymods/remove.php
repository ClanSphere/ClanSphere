<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('notifymods');
$cs_get = cs_get('id');
$cs_post = cs_post('id');
$notify_id = empty($cs_get['id']) ? $cs_post['id'] : $cs_get['id'];

if (isset($cs_post['agree'])) {
  cs_sql_delete(__FILE__,'notifymods',$notify_id);
  cs_redirect($cs_lang['del_true'], 'notifymods');
}

if (isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'notifymods');
}

$data = array();
$data['nm']['id'] = $notify_id;
$data['head']['body'] = sprintf($cs_lang['del_rly'],$notify_id);
echo cs_subtemplate(__FILE__,$data,'notifymods','remove');
