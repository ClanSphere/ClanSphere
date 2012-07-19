<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$cs_post = cs_post('id');
$cs_get = cs_get('id');

$data = array();

$members_id = empty($cs_get['id']) ? 0 : $cs_get['id'];
if (!empty($cs_post['id']))  $members_id = $cs_post['id'];

$op_members = cs_sql_option(__FILE__,'members');
$op_squads = cs_sql_option(__FILE__,'squads');

$data['head']['mod'] = $cs_lang[$op_members['label']];

$users_nick = '';
$cs_members['users_id'] = 0;

if(isset($_POST['submit'])) {

  $cs_members['squads_id'] = $_POST['squads_id'];
  $cs_members['members_task'] = $_POST['members_task'];
  $cs_members['members_since'] = cs_datepost('since','date');
  $cs_members['members_order'] = empty($_POST['members_order']) ? 1 : $_POST['members_order'];
  $cs_members['members_admin'] = empty($_POST['members_admin']) ? 0 : $_POST['members_admin'];

  $users_nick = empty($_REQUEST['users_nick']) ? '' : $_REQUEST['users_nick'];

  $error = '';

  $where = "users_nick = '" . cs_sql_escape($users_nick) . "'";
  $users_data = cs_sql_select(__FILE__, 'users', 'users_id', $where);
  if(empty($users_data['users_id'])) {
    $error .= $cs_lang['no_user'] . cs_html_br(1);
  }
  else
    $cs_members['users_id'] = $users_data['users_id'];

  if(empty($cs_members['squads_id'])) {
    $error .= $cs_lang['no_'.$op_squads['label']] . cs_html_br(1);
  }
  if(empty($cs_members['members_task'])) {
    $error .= $cs_lang['no_task'] . cs_html_br(1);
  }
  
  $where = "squads_id = '" . $cs_members['squads_id'] . "' AND users_id = '";
  $where .= $cs_members['users_id'] . "' AND members_id != '" . $members_id . "'";
  $search_collision = cs_sql_count(__FILE__,'members',$where);
  if(!empty($search_collision)) {
    $error .= $cs_lang['collision'] . cs_html_br(1);
  }
}
else {
  $cells = 'squads_id, users_id, members_task, members_order, members_since, members_admin';
  $cs_members = cs_sql_select(__FILE__,'members',$cells,"members_id = '" . $members_id . "'");
  $cs_users = cs_sql_select(__FILE__,'users','users_nick','users_id = ' . (int) $cs_members['users_id']);
  $users_nick = $cs_users['users_nick'];
}
if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['errors_here'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['members']['label'] = $cs_lang[$op_squads['label']];
  $squads_data = cs_sql_select(__FILE__,'squads','squads_name,squads_id',0,'squads_name',0,0);
  $data['members']['squad_sel'] = cs_dropdown('squads_id','squads_name',$squads_data,$cs_members['squads_id']);

  $data['users']['nick'] = cs_secure($users_nick);

  $data['members']['task'] = cs_secure($cs_members['members_task']);
  $data['members']['order'] = cs_secure($cs_members['members_order']);
  $data['members']['since'] = cs_dateselect('since','date',$cs_members['members_since']);
  $data['members']['admin'] = empty($cs_members['members_admin']) ? '' : 'checked="checked"';

  $data['members']['id'] = $members_id;

  echo cs_subtemplate(__FILE__,$data,'members','edit');
}
else {

  settype($cs_members['members_order'],'integer');

  $members_cells = array_keys($cs_members);
  $members_save = array_values($cs_members);
  cs_sql_update(__FILE__,'members',$members_cells,$members_save,$members_id);

  cs_redirect($cs_lang['changes_done'], 'members') ;
}