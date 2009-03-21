<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('members');

$op_members = cs_sql_option(__FILE__,'members');
$op_squads = cs_sql_option(__FILE__,'squads');

$data = array();

$data['lang']['mod'] = $cs_lang[$op_members['label']];


if(isset($_POST['submit'])) {

  $cs_members['squads_id'] = $_POST['squads_id'];
  $cs_members['users_id'] = $_POST['users_id'];
  $cs_members['members_task'] = $_POST['members_task'];
  $cs_members['members_since'] = cs_datepost('since','date');
  $cs_members['members_order'] = empty($_POST['members_order']) ? 1 : $_POST['members_order'];
  $cs_members['members_admin'] = empty($_POST['members_admin']) ? 0 : $_POST['members_admin'];
  
  $error = '';

  if(empty($cs_members['squads_id']))
    $error .= $cs_lang['no_'.$op_squads['label']] . cs_html_br(1);
  
  if(empty($cs_members['users_id']))
    $error .= $cs_lang['no_user'] . cs_html_br(1);
  
  if(empty($cs_members['members_task']))
    $error .= $cs_lang['no_task'] . cs_html_br(1);
  
  $where = "squads_id = '" . $cs_members['squads_id'] . "' AND users_id = '";
  $where .= $cs_members['users_id'] . "'";
  $search_collision = cs_sql_count(__FILE__,'members',$where);
  
  if(!empty($search_collision))
    $error .= $cs_lang['collision'] . cs_html_br(1);
  
}
else {

  $cs_members['squads_id'] = 0;
  $cs_members['users_id'] = 0;
  $cs_members['members_task'] = '';
  $cs_members['members_since'] = cs_datereal('Y-m-d');
  $cs_members['members_order'] = 1;
  $cs_members['members_admin'] = 0;

  if(!empty($_GET['joinus'])) {
    $joinus_where = "joinus_id = '" . cs_sql_escape($_GET['joinus']) . "'";
    $cs_joinus = cs_sql_select(__FILE__,'joinus','*',$joinus_where);
    if(!empty($cs_joinus)) {
      $cs_members['squads_id'] = $cs_joinus['squads_id'];
      $cs_members['members_since'] = $cs_joinus['joinus_date'];

      $where = "users_nick = '" . $cs_joinus['joinus_nick'] . "'";
      $cs_member = cs_sql_select(__FILE__,'users','users_id',$where);
      $cs_members['users_id'] = $cs_member['users_id'];
    }
  }
}

if(!empty($error) OR !isset($_POST['submit'])) {

  $data['lang']['squad'] = $cs_lang[$op_squads['label']];
  $data['head']['text'] = !empty($error) ? $error : $cs_lang['errors_here'];
  
  $data_squads = cs_sql_select(__FILE__,'squads','squads_name,squads_id',0,'squads_name',0,0);
  $data_users = cs_sql_select(__FILE__,'users','users_nick,users_id',0,'users_nick',0,0);
  
  $data['squads'] = cs_dropdownsel($data_squads, $cs_members['squads_id'], 'squads_id');
  $data['users'] = cs_dropdownsel($data_users, $cs_members['users_id'], 'users_id');
  
  $data['value']['task'] = $cs_members['members_task'];
  $data['value']['order'] = $cs_members['members_order'];
  $data['value']['admin_sel'] = empty($cs_members['members_admin']) ? '' : ' checked="checked"';
  
  $data['dropdown']['since_year'] = cs_dateselect('since','date',$cs_members['members_since']);
  
  
  echo cs_subtemplate(__FILE__,$data,'members','create');

} else {
    
  settype($cs_banners['members_order'],'integer');

  $members_cells = array_keys($cs_members);
  $members_save = array_values($cs_members);
  cs_sql_insert(__FILE__,'members',$members_cells,$members_save);
  
  cs_redirect($cs_lang['create_done'],'members');
  
}

?>