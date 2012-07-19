<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');

$op_squads = cs_sql_option(__FILE__,'squads');
$label = $op_squads['label'];

if(isset($_POST['submit'])) {

  $cs_squads['squads_id'] = $_POST['squads_id'];
  settype($cs_squads['squads_id'],'integer');
  $cs_squads['squads_pwd'] = $_POST['squads_pwd'];
  
  $error = '';
  
  if(empty($cs_squads['squads_id'])) {
    $error .= $cs_lang['no_'.$op_squads['label']] . cs_html_br(1);
  }
  if(empty($cs_squads['squads_pwd'])) {
    $error .= $cs_lang['no_pwd_'.$op_squads['label']] . cs_html_br(1);
  }
  else {
    $where = "squads_id = '" . $cs_squads['squads_id'] . "'";
    $safe = cs_sql_select(__FILE__,'squads','squads_pwd',$where);
    if($safe['squads_pwd'] != $cs_squads['squads_pwd']) {
      $error .= $cs_lang['wrong_pwd'] . cs_html_br(1);
    }
  }

  $where = "squads_id = '" . $cs_squads['squads_id'] . "' AND users_id = '" . $account['users_id'] . "'";
  $search_collision = cs_sql_count(__FILE__,'members',$where);
  if(!empty($search_collision)) {
    $error .= $cs_lang['collision'] . cs_html_br(1);
  }
}
else {
  $cs_squads['squads_id'] = 0;
  $cs_squads['squads_pwd'] = '';
}

if(!isset($_POST['submit'])) {
  $data['head']['body'] = $cs_lang['body_join'];
}
elseif(!empty($error)) {
  $data['head']['body'] = $error;
}


if(!empty($error) OR !isset($_POST['submit'])) {

  $data['head']['mod'] = $cs_lang[$label.'s'];
  $data['lang']['label'] = $cs_lang[$label];
  
  $squads_data = cs_sql_select(__FILE__,'squads','squads_name,squads_id',0,'squads_name',0,0);
  $data['squads']['squad_sel'] = cs_dropdown('squads_id','squads_name',$squads_data,$cs_squads['squads_id']);
  
  echo cs_subtemplate(__FILE__,$data,'squads','join');

}
else {

  $cs_members['squads_id'] = $cs_squads['squads_id'];
  $cs_members['users_id'] = $account['users_id'];
  $cs_members['members_task'] = $cs_lang['member'];
  $cs_members['members_since'] = cs_datereal('Y-m-d');
  $cs_members['members_order'] = 50;
  $cs_members['members_admin'] = 0;
  
  $members_cells = array_keys($cs_members);
  $members_save = array_values($cs_members);
  cs_sql_insert(__FILE__,'members',$members_cells,$members_save);
  
  cs_redirect($cs_lang['join_done'],'squads','center');
}