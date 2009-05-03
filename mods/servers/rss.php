<?php

$from = 'servers srv INNER JOIN {pre}_games gms ON srv.games_id = gms.games_id ';
$select = 'srv.servers_name AS title, gms.games_name AS text, srv.servers_id AS id';
$order = 'servers_id DESC';
$cs_servers = cs_sql_select(__FILE__,$from,$select,0,$order,0,8);

include_once('mods/rss/generate.php');
cs_update_rss('servers','view',$cs_lang['mod_name'],$cs_lang['rss_info'],$cs_servers);