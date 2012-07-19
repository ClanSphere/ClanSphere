<?php
// ClanSphere 2010 - www.clansphere.net
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
$select = 'bds.buddys_id AS buddys_id, bds.buddys_time AS buddys_time, bds.buddys_user AS buddys_user, bds.users_id AS users_id, ';
$select .= 'usr.users_nick AS users_nick, usr.users_active AS users_active, usr.users_delete AS users_delete, usr.users_country AS users_country, usr.users_laston AS users_laston';
  
$online = "bds.users_id = '" . $users_id . "' AND users_laston > '" . $on_now . "'";
$offline = "bds.users_id = '" . $users_id . "' AND users_laston < '" . $on_now . "'";

$data2 = array();

$b_off = cs_sql_select(__FILE__,$from,$select,$offline,'users_nick DESC',0,0);
$loop_off = count($b_off);


for($a=0; $a < $loop_off; $a++) {

    $b_off[$a]['users_link'] = cs_user($b_off[$a]['buddys_user'], $b_off[$a]['users_nick'], $b_off[$a]['users_active'], $b_off[$a]['users_delete']);  
    $b_off[$a]['users_nick'] = $b_off[$a]['users_nick'];
    $b_off[$a]['users_country'] = cs_html_img('symbols/countries/' . $b_off[$a]['users_country'] . '.png');
}
  
$b_on = cs_sql_select(__FILE__,$from,$select,$online,'users_nick DESC',0,0);
$loop_on = count($b_on);
  
for($i=0; $i < $loop_on; $i++) {

    $b_on[$i]['users_link'] = cs_user($b_on[$i]['buddys_user'], $b_on[$i]['users_nick'], $b_on[$i]['users_active'], $b_on[$i]['users_delete']);    
    $b_on[$i]['users_nick'] = $b_on[$i]['users_nick'];
    $b_on[$i]['users_country'] = cs_html_img('symbols/countries/' . $b_on[$i]['users_country'] . '.png');
}
  
$data2['boff'] = empty($b_off) ? '' : $b_off;
$data2['bon'] = empty($b_on) ? '' : $b_on;
  
echo cs_subtemplate(__FILE__,$data2,'buddys','users');