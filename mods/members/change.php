<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$op_members = cs_sql_option(__FILE__,'members');

$members_id = $_REQUEST['id'];
settype($members_id,'integer');

$data['members']['mod'] = $cs_lang[$op_members['label']];

$cells = 'squads_id,users_id,members_task,members_order,members_since,members_admin';
$cs_members = cs_sql_select(__FILE__,'members',$cells,"members_id = '" . $members_id . "'");

if(isset($_POST['submit'])) {

  $cs_members['members_task'] = $_POST['members_task'];
  $cs_members['members_since'] = cs_datepost('since','date');
  $cs_members['members_order'] = empty($_POST['members_order']) ? 1 : $_POST['members_order'];
  $cs_members['members_admin'] = empty($_POST['members_admin']) ? 0 : $_POST['members_admin'];
  
  $error = 0;
  $errormsg = '';

  if(empty($cs_members['members_task'])) {
    $error++;
    $errormsg .= $cs_lang['no_task'] . cs_html_br(1);
  }
  
  $where = "squads_id = '" . $cs_members['squads_id'] . "' AND users_id = '" . $account['users_id'] . "'";
  $search_admin = cs_sql_select(__FILE__,'members','members_admin',$where);
  if(empty($search_admin['members_admin'])) {
    $error++;
    $errormsg .= $cs_lang['no_admin'] . cs_html_br(1);
  }
}
if(!isset($_POST['submit'])) {
  $data['lang']['body'] = $cs_lang['errors_here'];
}
elseif(!empty($error)) {
  $data['lang']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['url']['form'] = cs_url('members','change');

  $squad_match = "squads_id = '" . $cs_members['squads_id'] . "'";
  $squad_infos = cs_sql_select(__FILE__,'squads','squads_name,squads_id',$squad_match);
  $squad_name = cs_secure($squad_infos['squads_name']);
  $data['members']['squad'] = cs_link($squad_name,'squads','view','id=' . $squad_infos['squads_id']);

  $users_match = "users_id = '" . $cs_members['users_id'] . "'";
  $users_infos = cs_sql_select(__FILE__,'users','users_nick,users_id,users_active,users_delete',$users_match);
  $users_nick = cs_secure($users_infos['users_nick']);
  $data['members']['user'] = cs_user($users_infos['users_id'],$users_infos['users_nick'], $users_infos['users_active'], $users_infos['users_delete']);

  $data['members']['task'] = cs_secure($cs_members['members_task']);

  $data['members']['order'] = (int) $cs_members['members_order'];
  
  $data['members']['since'] = cs_dateselect('since','date',$cs_members['members_since']);

  if($cs_members['members_admin'] == '1')
    $data['members']['admin'] = 'checked="checked"';
  else
    $data['members']['admin'] = '';

  $data['members']['id'] = $members_id;
  
  echo cs_subtemplate(__FILE__,$data,'members','change');
}
else {

  $more = 'where=' . $cs_members['squads_id'];

  unset($cs_members['squads_id']);
  unset($cs_members['users_id']);
  settype($cs_members['members_order'],'integer');

  $members_cells = array_keys($cs_members);
  $members_save = array_values($cs_members);
  cs_sql_update(__FILE__,'members',$members_cells,$members_save,$members_id);  

  cs_redirect($cs_lang['changes_done'],'members','center', $more);
}