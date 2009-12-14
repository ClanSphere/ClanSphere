<?php
// ClanSphere 2009 - www.clansphere.net 
// $Id: edit.php 2266 2009-03-21 10:37:39Z duRiel $

$cs_lang = cs_translate('medals');
$data = array();

$start = empty($_GET['start']) ? 0 : (int) $_GET['start'];

$tables = "users u RIGHT JOIN {pre}_medalsuser m ON u.users_id = m.users_id GROUP BY u.users_id";
$count = cs_sql_count(__FILE__, $tables);

$data['pages']['list'] = cs_pages('medals','list',$count,$start);

$tables = "users u RIGHT JOIN {pre}_medalsuser m ON u.users_id = m.users_id GROUP BY u.users_id";
$cells = "u.users_id AS users_id, u.users_nick AS users_nick, COUNT(m.medals_id) AS medals";

$data['users'] = cs_sql_select(__FILE__, $tables, $cells, 0, "medals DESC", $start, $account["users_limit"]);

echo cs_subtemplate(__FILE__, $data, "medals", "list");