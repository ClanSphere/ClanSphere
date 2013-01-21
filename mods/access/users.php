<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('access');
$cs_post = cs_post();
$access_id = empty($_REQUEST['id']) ? 0 : $_REQUEST['id'];

$data = array();

if(isset($cs_post['submit']) && isset($cs_post['users_nick']) && isset($_REQUEST['id'])) {

  $select = 'users_id, access_id, users_nick, users_delete';
  $where = "users_delete = '0' AND users_nick = '" . $cs_post['users_nick'] . "'";
  $cs_user = cs_sql_select(__FILE__,'users', $select, $where);
  
  $errormsg = '';

  $errormsg .= count($cs_user) > 0 ? '' : $cs_lang['user_notfound'] . cs_html_br(1);
  $errormsg .= $cs_user['access_id'] != $access_id ? '' : $cs_lang['user_ingroup'] . cs_html_br(1);
  $errormsg .= $account['users_id'] != $cs_user['users_id'] ? '' : $cs_lang['user_account'] . cs_html_br(1);
  $errormsg .= $access_id > 0 ? '' : $cs_lang['no_access'];
  
  if (empty($errormsg))
  {    
    $cs_access_user['access_id'] = $access_id;
    $users_id = $cs_user['users_id'];
  
    $user_cells = array_keys($cs_access_user);
    $user_save = array_values($cs_access_user);
    cs_sql_update(__FILE__,'users',$user_cells,$user_save,$users_id);
  }
}

if(!isset($cs_post['submit'])) {
  $data['head']['msg'] = $cs_lang['users_head'];
}
elseif(!empty($errormsg)) {
  $data['head']['msg'] = $errormsg;
}
else {
  $data['head']['msg'] = $cs_lang['user_added'];
}

$select = 'access_id, access_name';
$where = "access_id = '" . $access_id . "'";
$cs_access = cs_sql_select(__FILE__,'access', $select, $where);

$data['access']['id'] = $access_id;
$data['access']['name'] = $cs_access['access_name'];


$select = 'users_id, access_id, users_nick, users_delete, users_active';
$where = "users_delete = '0' AND access_id = '" . $access_id . "'";
$sort = 'users_nick ASC';
$cs_access_users = cs_sql_select(__FILE__,'users', $select, $where, $sort, 0, 0);
$users_loop = count($cs_access_users);

if (empty($users_loop)) {
  $data['users'] = '';
}

for($run = 0; $run < $users_loop; $run++) {
  $data['users'][$run]['nick'] = cs_user($cs_access_users[$run]['users_id'], $cs_access_users[$run]['users_nick'], $cs_access_users[$run]['users_active'], $cs_access_users[$run]['users_delete']);
}

echo cs_subtemplate(__FILE__,$data,'access','users');