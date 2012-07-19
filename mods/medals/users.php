<?php

$cs_lang = cs_translate('medals');
$data = array();

$users_id = (int) $_GET['id'];

$data['users']['addons'] = cs_addons('users','view',$users_id,'medals');

$tables = 'medalsuser mu LEFT JOIN {pre}_medals md ON md.medals_id = mu.medals_id';
$cells = 'mu.users_id AS users_id, md.medals_id AS medals_id, mu.medalsuser_date AS medalsuser_date, mu.medalsuser_id AS medalsuser_id, ';
$cells .= 'md.medals_name AS medals_name, md.medals_text AS medals_text, md.medals_extension AS medals_extension';

$data['medalsuser'] = cs_sql_select(__FILE__,$tables, $cells, "mu.users_id = '" . $users_id . "'",0,0,0);
$data['count']['medalsuser'] = count($data['medalsuser']);

for ($i = 0; $i < $data['count']['medalsuser']; $i++) {
  $data['medalsuser'][$i]['img_src'] = 'uploads/medals/medal-' . $data['medalsuser'][$i]['medals_id'] . '.' . $data['medalsuser'][$i]['medals_extension']; 
  $data['medalsuser'][$i]['medals_text'] = cs_secure($data['medalsuser'][$i]['medals_text'],1);
  $data['medalsuser'][$i]['medals_date'] = cs_date('unix',$data['medalsuser'][$i]['medalsuser_date']);
  $data['medalsuser'][$i]['medals_name'] = cs_secure($data['medalsuser'][$i]['medals_name']);
}

echo cs_subtemplate(__FILE__,$data,'medals','users');