<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('notifymods');

$data = array();

$data['nm']['users_id'] = 0;

if(isset($_POST['submit'])) {

  $data['nm']['notifymods_gbook'] = isset($_POST['notifymods_gbook']) ? 1 : 0;
  $data['nm']['notifymods_joinus'] = isset($_POST['notifymods_joinus']) ? 1 : 0;
  $data['nm']['notifymods_fightus'] = isset($_POST['notifymods_fightus']) ? 1 : 0;
  $data['nm']['notifymods_files'] = isset($_POST['notifymods_files']) ? 1 : 0;
  $data['nm']['notifymods_board'] = isset($_POST['notifymods_board']) ? 1 : 0;

  $users_nick = empty($_REQUEST['users_nick']) ? '' : $_REQUEST['users_nick'];

  $error = 0;
  $errormsg = '';

  $where = "users_nick = '" . cs_sql_escape($users_nick) . "'";
  $users_data = cs_sql_select(__FILE__, 'users', 'users_id', $where);
  if(empty($users_data['users_id'])) {
    $error++;
    $errormsg .= $cs_lang['no_user'] . cs_html_br(1);
  }
  else
    $data['nm']['users_id'] = $users_data['users_id'];

  $check = 'notifymods_user = ' . $data['nm']['users_id'];
  $find_user = cs_sql_count(__FILE__,'notifymods',$check);
  if(!empty($find_user)) {
  $error++;
  $errormsg .= $cs_lang['user_exists'] . cs_html_br(1);
  }

} else {
  $data['nm']['notifymods_gbook'] = 0;
  $data['nm']['notifymods_joinus'] = 0;
  $data['nm']['notifymods_fightus'] = 0;
  $data['nm']['notifymods_files'] = 0;
  $data['nm']['notifymods_board'] = 0;
  $users_nick = '';
}

if(!isset($_POST['submit']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['body'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $errormsg;
}

if(!empty($error) OR !isset($_POST['submit'])) {
  
  $users = cs_sql_select(__FILE__,'users','users_nick, users_id','users_active = 1 AND users_delete = 0','users_nick ASC',0,0);
  $data['nm']['users_dropdown'] = cs_dropdown('users_id','users_nick',$users,$data['nm']['users_id']);
  
  $data['nm']['notifymods_gbook'] = $data['nm']['notifymods_gbook'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_joinus'] = $data['nm']['notifymods_joinus'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_fightus'] = $data['nm']['notifymods_fightus'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_files'] = $data['nm']['notifymods_files'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_board'] = $data['nm']['notifymods_board'] == 1 ? 'checked="checked"' : '';

  $data['users']['nick'] = $users_nick;

} else {
  $sql_cells = array('notifymods_user', 'notifymods_gbook', 'notifymods_joinus', 'notifymods_fightus', 'notifymods_files', 'notifymods_board');
  $sql_content = array($data['nm']['users_id'], $data['nm']['notifymods_gbook'], $data['nm']['notifymods_joinus'], $data['nm']['notifymods_fightus'], $data['nm']['notifymods_files'], $data['nm']['notifymods_board']);
  cs_sql_insert(__FILE__,'notifymods',$sql_cells, $sql_content);
  
  cs_redirect($cs_lang['create_done'],'notifymods');
} 
  echo cs_subtemplate(__FILE__,$data,'notifymods','create');