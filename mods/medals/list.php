<?php
// ClanSphere 2010 - www.clansphere.net 
// $Id: edit.php 2266 2009-03-21 10:37:39Z duRiel $

$cs_lang = cs_translate('medals');
$data = array();

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$tables = "users u RIGHT JOIN {pre}_medalsuser m ON u.users_id = m.users_id AND u.users_active = 1 AND u.users_delete = 0 GROUP BY u.users_id";
$count = cs_sql_count(__FILE__, $tables);

$data['pages']['list'] = cs_pages('medals','list',$count,$start);

$cells = "u.users_id AS users_id, u.users_nick AS users_nick, COUNT(m.medals_id) AS medals";
$cells .= ", u.users_active AS users_active, u.users_delete AS users_delete";

$data['users'] = cs_sql_select(__FILE__, $tables, $cells, 0, "medals DESC", $start, $account["users_limit"]);

$count = count($data['users']);

for ($i = 0; $i < $count; $i++) {
  
  $data['users'][$i]['user'] = cs_user($data['users'][$i]['users_id'], $data['users'][$i]['users_nick'], $data['users'][$i]['users_active'], $data['users'][$i]['users_delete']);
  
}



echo cs_subtemplate(__FILE__, $data, "medals", "list");