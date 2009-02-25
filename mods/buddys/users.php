<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('buddys');

$users_id = empty($_GET['where']) ? $_GET['id'] : $_GET['where'];
settype($users_id,'integer');
$buddys_count = cs_sql_count(__FILE__,'buddys',"users_id = '" . $users_id . "'");

  $data['head']['action'] = $cs_lang['mod_name'];
  $data['head']['body_text'] = cs_addons('users','view',$users_id,'buddys');
  echo cs_subtemplate(__FILE__,$data,'users','head');

  $on_now = cs_time() - 300; 
  
  $from = 'buddys bds INNER JOIN {pre}_users usr ON bds.buddys_user = usr.users_id';
  $select = 'bds.buddys_id AS buddys_id, bds.buddys_time AS buddys_time, bds.buddys_user AS ';
  $select .= 'buddys_user, bds.users_id AS users_id, usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, usr.users_country AS users_country, usr.users_laston AS ';
  $select .= 'users_laston';
  
  $online = "bds.users_id = '" . $users_id . "' AND users_laston > '" . $on_now . "'";
  $offline = "bds.users_id = '" . $users_id . "' AND users_laston < '" . $on_now . "'";
  
  $buddys_off = cs_sql_select(__FILE__,$from,$select,$offline,'users_nick DESC','','0');
  $loop_off = count($buddys_off);
  
  $buddy_data = array();
  for($run=0; $run < $loop_off; $run++) {  
    if(!empty($buddys_off[$run]['users_id'])) {
    $buddy_data['buddys_off'][$run]['users_link'] = cs_user($buddys_off[$run]['buddys_user'], $buddys_off[$run]['users_nick'], $buddys_off[$run]['users_active'], $buddys_off[$run]['users_delete']);  
    $buddy_data['buddys_off'][$run]['users_nick'] = $buddys_off[$run]['users_nick'];
    $buddy_data['buddys_off'][$run]['users_country'] = cs_html_img('symbols/countries/' . $buddys_off[$run]['users_country'] . '.png');
    }
  }
  
  $buddys_on = cs_sql_select(__FILE__,$from,$select,$online,'users_nick DESC','','0');
  $loop_on = count($buddys_on);
  
  for($run2=0; $run2 < $loop_on; $run2++) {  
    if(!empty($buddys_on[$run]['users_id'])) {
    $buddy_data['buddys_on'][$run]['users_link'] = cs_user($buddys_on[$run]['buddys_user'], $buddys_on[$run]['users_nick'], $buddys_on[$run]['users_active'], $buddys_on[$run]['users_delete']);    
    $buddy_data['buddys_on'][$run2]['users_nick'] = $buddys_on[$run2]['users_nick'];
    $buddy_data['buddys_on'][$run2]['users_country'] = cs_html_img('symbols/countries/' . $buddys_on[$run2]['users_country'] . '.png');
    }
  }
  
  $buddy_data['buddys_on'] = $buddys_on;
  $buddy_data['buddys_off'] = $buddys_off;
  
  echo cs_subtemplate(__FILE__,$buddy_data,'buddys','users');

?>
