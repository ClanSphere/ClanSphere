<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

$id = empty($_GET['sid']) ? 0 : (int) $_GET['sid'];

$cache_name = 'servers_navrandom_' . (int) $id;
$cache_time = 60;

// Test if fsockopen active
if (empty($data) AND fsockopen("udp://127.0.0.1", 1)) {

  $data = array('servers' => array());
  $data['if']['live'] = false;

  include_once 'mods/servers/servers.class.php';

  /* Get Server SQL-Data */
  $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order, servers_id';
  $order = '{random}';
  $cs_servers = cs_sql_select(__FILE__,'servers',$select,0,$order,0,1);

  /* Settings */
  $objServers = Servers::__getInstance();

  $data['servers']['hostname'] = $cs_servers['servers_name'];
  $server_query_ex = explode(";",$cs_servers['servers_class']);
  $cs_servers['servers_class'] = $server_query_ex[0];
  $cs_servers['servers_game'] = empty($server_query_ex[1]) ? '' : $server_query_ex[1];
  if(!empty($cs_servers['servers_stats'])) {

    $objServers->addServer(0, $cs_servers);
    $results = $objServers->requestData();
    $server = $results[0];

    if(!empty($server['gq_online'])) {
      $data['if']['live'] = true;
      $data['servers']['map'] = '';
      $data['servers']['mappic'] = 'uploads/servers/no_response.jpg';
      $data['servers']['mapname'] = '';
      $data['servers']['max_players'] = isset($server['max_players']) ? $server['max_players'] : 0;
      $data['servers']['num_players'] = isset($server['num_players']) ? $server['num_players'] : 0;
      $data['servers']['game_descr'] = isset($server['game_descr']) ? $server['game_descr'] : '';

      if(!empty($cs_servers['servers_stats'])) {
        $data['servers']['servers_ip'] = $cs_servers['servers_ip'];
        $data['servers']['servers_port'] = $cs_servers['servers_port'];
        if(isset($server['gamename']) AND !empty($server['gamename'])) {
          $data['servers']['game_descr'] = $server['gamename'];
        }

        if(isset($server['map']) && !empty($server['map'])) {
          $data['servers']['map'] = $server['map'];
          if(file_exists('uploads/servers/' . $cs_servers['servers_game'] . '/' . $data['servers']['map'] . '.jpg')) {
            $data['servers']['mappic'] = 'uploads/servers/' . $cs_servers['servers_game'] . '/' . $data['servers']['map'] . '.jpg';
          }
          else {
            $data['servers']['mappic'] = 'uploads/servers/' . $cs_servers['servers_game'] . '/default.jpg';
          }
        }
        elseif(isset($server['mapname']) && !empty($server['mapname'])) {
          $data['servers']['map'] = $server['mapname'];
          if(file_exists('uploads/servers/' . $cs_servers['servers_game'] . '/' . $data['servers']['mapname'] . '.jpg')) {
            $data['servers']['mappic'] = 'uploads/servers/' . $cs_servers['servers_game'] . '/' . $data['servers']['mapname'] . '.jpg';
          }
          else {
            $data['servers']['mappic'] = 'uploads/servers/' . $cs_servers['servers_game'] . '/default.jpg';
          }
        }

        $select = 'maps_name, maps_picture, server_name';
        $where = 'server_name = \'' . $data['servers']['map'] . '\'';
        $sqlmap = cs_sql_select(__FILE__,'maps',$select,$where,0,0,1);
        if(!empty($sqlmap)) {
          $data['servers']['map'] = $sqlmap['maps_name'];
          if(file_exists('uploads/maps/' . $sqlmap['maps_picture'])) {
            $data['servers']['mappic'] = 'uploads/maps/' . $sqlmap['maps_picture'];
          }
        }

        if(!isset($server['max_players'])) {
          if(isset($server['sv_maxclients'])) {
            $data['servers']['max_players'] = $server['sv_maxclients'];
          }
        }
        if(!isset($server['num_players'])) {
          if(isset($server['clients'])) {
            $data['servers']['num_players'] = $server['clients'];
          }
        }

        $data['servers'] = $objServers->setProtocolLink($cs_servers, $data['servers']);
        $data['servers']['pass'] = empty($data['servers']['pass']) ? $cs_lang['no'] : $cs_lang['yes'];
        $data['servers']['id'] = $cs_servers['servers_id'];
        flush();
      }
    }
  }

  cs_cache_save($cache_name, $data, $cache_time);
}

if(empty($data))
  echo 'fsockopen error';
else
  echo cs_subtemplate(__FILE__,$data,'servers','navrandom');