<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$buddy_data = array();
$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];

$users_id = $account['users_id'];
$buddys_count = cs_sql_count(__FILE__,'buddys',"users_id = '" . $users_id . "'");

if(!isset($_GET['notice'])) {
  
  $buddy_data['if']['manage'] = TRUE;
  $buddy_data['if']['notice'] = FALSE;
  
  $buddy_data['head']['buddys_count'] = $buddys_count;
  $buddy_data['head']['pages']        = cs_pages('buddys','center',$buddys_count,$start);
  $buddy_data['head']['message']     = cs_getmsg();
  
  $on_now = cs_time() - 300; 
  
  $from = 'buddys bds INNER JOIN {pre}_users usr ON bds.buddys_user = usr.users_id';
  $select = 'bds.buddys_id AS buddys_id, bds.buddys_time AS buddys_time, bds.buddys_user AS ';
  $select .= 'buddys_user, bds.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, usr.users_invisible AS users_invisible, usr.users_country AS users_country, usr.users_laston AS ';
  $select .= 'users_laston';
  
  $online = "bds.users_id = '" . $users_id . "' AND users_laston > '" . $on_now . "' AND users_invisible = '0'";
  $offline = "bds.users_id = '" . $users_id . "' AND users_laston < '" . $on_now . "' AND users_invisible = '0'";
  
  $buddys_off = cs_sql_select(__FILE__,$from,$select,$offline,'users_nick DESC',0,0);
  $loop_off = count($buddys_off);

  $buddys_on = cs_sql_select(__FILE__,$from,$select,$online,'users_nick DESC',0,0);
  $loop_on = count($buddys_on);
  
  $buddy_data['buddys_off'] = array();
  $buddy_data['buddys_on'] = array();

  for($run=0; $run < $loop_off; $run++) {  
      $buddy_data['buddys_off'][$run]['users_id']     = $buddys_off[$run]['buddys_user'];
      $buddy_data['buddys_off'][$run]['users_nick']   = $buddys_off[$run]['users_nick'];
      $buddy_data['buddys_off'][$run]['users_link']   = cs_user($buddys_off[$run]['buddys_user'], $buddys_off[$run]['users_nick'], $buddys_off[$run]['users_active'], $buddys_off[$run]['users_delete']);
      $buddy_data['buddys_off'][$run]['buddys_id']    = $buddys_off[$run]['buddys_id'];      
      $buddy_data['buddys_off'][$run]['users_country']= $buddys_off[$run]['users_country'];
  }
  for($run=0; $run < $loop_on; $run++) {
      $buddy_data['buddys_on'][$run]['users_id']      = $buddys_on[$run]['buddys_user'];
      $buddy_data['buddys_on'][$run]['users_nick']    = $buddys_on[$run]['users_nick'];
      $buddy_data['buddys_on'][$run]['users_link']    = cs_user($buddys_on[$run]['buddys_user'], $buddys_on[$run]['users_nick'], $buddys_on[$run]['users_active'], $buddys_on[$run]['users_delete']);
      $buddy_data['buddys_on'][$run]['buddys_id']     = $buddys_on[$run]['buddys_id'];
      $buddy_data['buddys_on'][$run]['users_country'] = $buddys_on[$run]['users_country'];
  }
}
if(isset($_GET['notice'])) {
  
  $buddy_data['if']['manage'] = FALSE;
  $buddy_data['if']['notice'] = TRUE;
  
  $id = $_GET['notice'];
  settype($id,'integer');
  
  $from = 'buddys bds INNER JOIN {pre}_users usr ON bds.buddys_user = usr.users_id';
  $select = 'bds.buddys_id AS buddys_id, bds.buddys_time AS buddys_time, bds.buddys_user AS ';
  $select .= 'buddys_user, bds.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, usr.users_laston AS ';
  $select .= 'users_laston, bds.buddys_notice AS buddys_notice';
  $where = "buddys_id = '" . $id . "'";
  
  $cs_buddys = cs_sql_select(__FILE__,$from,$select,$where);
  $buddys_loop = count($cs_buddys);
  
  $buddy_data['buddys']['users_link']     = cs_user($cs_buddys['buddys_user'], $cs_buddys['users_nick'], $cs_buddys['users_active'], $cs_buddys['users_delete']);
  $buddy_data['buddys']['users_laston']   = cs_date('unix',$cs_buddys['users_laston'],1);
  $buddy_data['buddys']['buddys_time']    = cs_date('unix',$cs_buddys['buddys_time'],1);
  $buddy_data['buddys']['buddys_notice']  = cs_secure($cs_buddys['buddys_notice'],1,1);

}

echo cs_subtemplate(__FILE__,$buddy_data,'buddys','center');