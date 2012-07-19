<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

$data = array();

$start = empty($_REQUEST['start']) ? 0 : $_REQUEST['start'];
$cs_sort[1] = 'servers_name DESC';
$cs_sort[2] = 'servers_name ASC';
$sort = empty($_REQUEST['sort']) ? 2 : $_REQUEST['sort'];
$order = $cs_sort[$sort];
$server_count = cs_sql_count(__FILE__,'servers');

$data['server']['count'] = $server_count;
$data['server']['pages'] = cs_pages('servers','manage',$server_count,$start,0,$sort);
$data['server']['sort'] = cs_sort('servers','manage',$start,0,1,$sort);
$data['server']['headmsg'] = cs_getmsg();
$data['if']['viewfsock'] = false;

if (!fsockopen("udp://127.0.0.1", 1)) {
  $data['if']['viewfsock'] = true;
}

$from = "servers serv LEFT JOIN {pre}_games gam ON gam.games_id = serv.games_id";
$select = "serv.servers_id servers_id, serv.servers_name servers_name, serv.servers_class servers_class, gam.games_name games_name, ";
$select .= "serv.servers_stats servers_stats";
$cs_server = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);

if(!empty($cs_server)) {
  for($run=0; $run<count($cs_server); $run++) {
    $server_query_ex = explode(";",$cs_server[$run]['servers_class']);
    $cs_server[$run]['servers_class'] = $server_query_ex[0];
    $cs_server[$run]['servers_game'] = empty($server_query_ex[1]) ? $server_query_ex[0] : $server_query_ex[1];
    $data['servers'][$run]['id'] = $cs_server[$run]['servers_id'];
    $data['servers'][$run]['name'] = $cs_server[$run]['servers_name'];
    $data['servers'][$run]['game'] = $cs_server[$run]['games_name'];
    $data['servers'][$run]['class'] = $cs_server[$run]['servers_class'];
    $data['servers'][$run]['stats'] = $cs_server[$run]['servers_stats'] == 1 ? cs_icon('submit') : cs_icon('cancel');
    $data['servers'][$run]['edit'] = cs_link(cs_icon('edit'),'servers','edit','id=' . $cs_server[$run]['servers_id'],0,$cs_lang['edit']);
    $data['servers'][$run]['remove'] = cs_link(cs_icon('editdelete'),'servers','remove','id=' . $cs_server[$run]['servers_id'],0,$cs_lang['remove']);
  }
}
else
  $data['servers'] = array();

echo cs_subtemplate(__FILE__,$data,'servers','manage');