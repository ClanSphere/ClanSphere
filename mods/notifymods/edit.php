<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('notifymods');
$data = array(); 

if (isset($_POST['submit'])) {

  $cs_bm['notifymods_gbook'] = isset($_POST['notifymods_gbook']) ? $_POST['notifymods_gbook'] : 0;
  $cs_bm['notifymods_joinus'] = isset($_POST['notifymods_joinus']) ? $_POST['notifymods_joinus'] : 0;
  $cs_bm['notifymods_fightus'] = isset($_POST['notifymods_fightus']) ? $_POST['notifymods_fightus'] : 0;
  $cs_bm['notifymods_files'] = isset($_POST['notifymods_files']) ? $_POST['notifymods_files'] : 0;
  $cs_bm['notifymods_board'] = isset($_POST['notifymods_board']) ? $_POST['notifymods_board'] : 0;
  
  $error = 0;
  $errormsg = '';

}
else if (isset($_POST['cancel']))
  cs_redirect($cs_lang['del_false'], 'notifymods');
else {
  $notifymods_id = $_GET['id'];
  $tables = 'notifymods ntm INNER JOIN {pre}_users usr ON usr.users_id = ntm.notifymods_user';
  $cells  = 'ntm.notifymods_id, ntm.notifymods_user, usr.users_nick AS users_nick, ' .
            'ntm.notifymods_gbook, ntm.notifymods_joinus, ntm.notifymods_fightus, ntm.notifymods_files, ntm.notifymods_board';
  $cs_bm = cs_sql_select(__FILE__,$tables,$cells,'notifymods_id = ' . $notifymods_id);
}

if (!isset($_POST['submit']) AND empty($error)) {
  $data['head']['body'] = $cs_lang['body'];
}
else if (!empty($error)) {
  $data['head']['body'] = $errormsg;
}

if (!empty($error) OR !isset($_POST['submit'])) {
  $data['nm']['id'] = empty($_POST['id']) ? $_GET['id'] : $_POST['id'];
  $data['nm']['user'] = cs_secure($cs_bm['users_nick']);
  $data['nm']['notifymods_gbook'] = $cs_bm['notifymods_gbook'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_joinus'] = $cs_bm['notifymods_joinus'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_fightus'] = $cs_bm['notifymods_fightus'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_files'] = $cs_bm['notifymods_files'] == 1 ? 'checked="checked"' : '';
  $data['nm']['notifymods_board'] = $cs_bm['notifymods_board'] == 1 ? 'checked="checked"' : '';
}
else {
  $notifymods_cells = array_keys($cs_bm);
  $notifymods_save = array_values($cs_bm);
  cs_sql_update(__FILE__,'notifymods',$notifymods_cells,$notifymods_save,$_POST['id']);
  cs_redirect($cs_lang['changes_done'],'notifymods');
} 

echo cs_subtemplate(__FILE__,$data,'notifymods','edit');