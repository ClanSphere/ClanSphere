<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('newsletter');

$data = array();

if(isset($_POST['submit'])) {
  $data['users']['users_newsletter'] = empty($_POST['newsletter']) ? 0 : $_POST['newsletter'];
  $data['head']['body_text'] = empty($data['users']['users_newsletter']) ? $cs_lang['unsubscribe_letter'] : $cs_lang['subscribe_letter'];
  $users_cells = array_keys($data['users']);
  $users_save = array_values($data['users']);
  cs_sql_update(__FILE__,'users',$users_cells,$users_save,$account['users_id']);
}
else {
  $data['head']['body_text'] = $cs_lang['newsletter_info'];
}

$user = cs_sql_select(__FILE__,'users','users_id, users_newsletter',"users_id = '" . $account['users_id']. "'",0,0,1);

$data['users']['users_newsletter'] = $user['users_newsletter'];
$data['newsletter']['checked'] = empty($data['users']['users_newsletter']) ? '' : 'checked';
$data['url']['action'] = cs_url('newsletter','center');
$data['head']['back'] = cs_link($cs_lang['back'],'users','settings');

echo cs_subtemplate(__FILE__,$data,'newsletter','center');