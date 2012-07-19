<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('squads');
$cs_post = cs_post('id');

$op_squads = cs_sql_option(__FILE__,'squads');
$label = $op_squads['label'];

if(isset($_POST['agree'])) {
  $squads_id = $cs_post['id'];
  $where = "squads_id = '" . $squads_id . "' AND users_id = '" . $account['users_id'] . "'";
  $getme = cs_sql_select(__FILE__,'members','members_id',$where);
  cs_sql_delete(__FILE__,'members',$getme['members_id']);

  cs_redirect($cs_lang['sq_del_true'],'squads','center');
}

if(isset($_POST['cancel'])) {
  cs_redirect($cs_lang['del_false'],'squads','center');
}
else {
   $data['head']['mod'] = $cs_lang[$label.'s'];
   $data['lang']['label'] = $cs_lang[$label];

  $where = "mem.users_id = '" . $account['users_id'] . "'";
  $select = 'sqd.squads_name AS squads_name, sqd.squads_id AS squads_id';
  $from = 'members mem INNER JOIN {pre}_squads sqd ON mem.squads_id = sqd.squads_id';
  $sqd_data = cs_sql_select(__FILE__,$from,$select,$where,'sqd.squads_name',0,0);
  $data['squads']['squad_sel'] = cs_dropdown('id','squads_name',$sqd_data,0,'squads_id');
    
  echo cs_subtemplate(__FILE__,$data,'squads','leave');
}