<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');
$cs_get = cs_get('id');

$op_squads = cs_sql_option(__FILE__,'squads');
$data['head']['mod'] = $cs_lang[$op_squads['label'].'s'];

if(isset($cs_get['agree'])) {
  $where = 'squads_id = ' . $cs_get['id'] . ' AND users_id = ' . $account['users_id'];
  $search_admin = cs_sql_select(__FILE__,'members','members_admin',$where);
  if(empty($search_admin['members_admin']) AND $account['access_squads'] < 5) {
    $msg = $cs_lang['no_admin'];
  }
  else {
    $where = 'squads_id = ' . $cs_get['id'];
    $getpic = cs_sql_select(__FILE__,'squads','squads_picture, squads_name',$where);
    if(!empty($getpic['squads_picture'])) {
      cs_unlink('squads', $getpic['squads_picture']);
    }
    $where = 'squads_id = ' . $cs_get['id'];
    cs_sql_delete(__FILE__,'squads',$cs_get['id']);
    cs_sql_delete(__FILE__,'members',$cs_get['id'],'squads_id');
    $msg = $cs_lang['sq_del_true'];
  }

  if($account['access_squads'] >= 3) {
    $action = 'manage';
  } else {
    $action = 'center';
  }
  cs_redirect($msg,'squads',$action);
}

if(isset($cs_get['cancel'])) {
  cs_redirect($cs_lang['del_false'], 'squads');
}

$squad = cs_sql_select(__FILE__,'squads','squads_name','squads_id = ' . $cs_get['id'],0,0,1);
if(!empty($squad)) {
  $data = array();
  $data['head']['body'] = sprintf($cs_lang['remove_entry'],$cs_lang['squad'],$squad['squads_name']);
  $data['url']['agree'] = cs_url('squads','remove','id=' . $cs_get['id'] . '&amp;agree');
  $data['url']['cancel'] = cs_url('squads','remove','id=' . $cs_get['id'] . '&amp;cancel');
  echo cs_subtemplate(__FILE__,$data,'squads','remove');
}
else {
  cs_redirect('','squads');
}
