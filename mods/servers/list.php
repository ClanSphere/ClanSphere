<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

$id = empty($_GET['id']) ? 0 : (int) $_GET['id'];

$cache_name = 'servers_list_' . (int) $id;
$cache_time = 60;

$data = cs_cache_load($cache_name, $cache_time);

// Test if fsockopen active
if (empty($data) AND fsockopen("udp://127.0.0.1", 1)) {

  $results = array();
  $data = array('servers' => array());
  $data['if']['noquery'] = false;
  $data['if']['server'] = false;

  include_once 'mods/servers/servers.class.php';

  /* Get Server SQL-Data */
  $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_slots, servers_stats, servers_order, servers_id';
  $order = 'servers_order ASC';
  $where = empty($id) ? '' : 'servers_id = \'' . $id . '\'';
  $cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);
  $servers_count = count($cs_servers);

  /* if no Server in SQL */
  if(empty($servers_count)) {
    unset($data['servers']);
  }
  else {
    $data['if']['server'] = true;

    /* Settings */
    $objServers = Servers::__getInstance();

    for($run=0; $run<$servers_count; $run++) {
      $server_query_ex = explode(";",$cs_servers[$run]['servers_class']);
      $cs_servers[$run]['servers_class'] = $server_query_ex[0];
      $cs_servers[$run]['servers_game'] = $server_query_ex[0];
      $data['servers'][$run]['info'] = $cs_servers[$run]['servers_info'];
      $data['servers'][$run]['if']['live'] = false;
      $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/default.jpg';
      $data['servers'][$run]['hostname'] = $cs_servers[$run]['servers_name'];
      $data['servers'][$run]['ip'] = $cs_servers[$run]['servers_ip'];
      $data['servers'][$run]['port'] = $cs_servers[$run]['servers_port'];
      $data['servers'][$run]['game'] = isset($server_query_ex[1]) ? $server_query_ex[1] : $server_query_ex[0];
      $data['servers'][$run]['slots'] = $cs_servers[$run]['servers_slots'];
      $data['servers'][$run]['if']['playersexist'] = false;

      if(!empty($cs_servers[$run]['servers_stats'])) {
        $objServers->addServer(0, $cs_servers[$run]);

        $results[$run] = $objServers->requestData();
        $server = $results[$run][0];

        if($run == 10) {
          echo '<pre>';
          print_R($server);
        }

        if(!empty($server['gq_online'])) {
          $data['servers'][$run] = $server;
          $data['servers'][$run] = $objServers->normalize($data['servers'][$run], $cs_servers[$run]);
          $data['servers'][$run]['if']['live'] = true;
          $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/default.jpg';
          $data['servers'][$run]['game'] = isset($server_query_ex[1]) ? $server_query_ex[1] : $server_query_ex[0];
          $data['servers'][$run]['map'] = '';
          $data['servers'][$run]['if']['playersexist'] = false;
          $data['servers'][$run]['ip'] = $cs_servers[$run]['servers_ip'];
          $data['servers'][$run]['port'] = $cs_servers[$run]['servers_port'];
         
          /* Password */
          $data['servers'][$run]['pass'] = '--';
          if(isset($server['password'])) {
            $data['servers'][$run]['pass'] = empty($server['password']) ? $cs_lang['no'] : $cs_lang['yes'];
          }
          if(isset($server['pswrd'])) {
            $data['servers'][$run]['pass'] = empty($server['pswrd']) ? $cs_lang['no'] : $cs_lang['yes'];
          }
          if(isset($server['g_needpass'])) {
            $data['servers'][$run]['pass'] = empty($server['g_needpass']) ? $cs_lang['no'] : $cs_lang['yes'];
          }

          /* GameName */
          $data['servers'][$run]['game_descr'] = $objServers->getGameName($cs_servers[$run]['servers_game']);

          /* Version */
          $data['servers'][$run]['version'] = $objServers->getGameVersion($server);

          /* Mapname */
          if(isset($server['mapname']) && !empty($server['mapname'])) {
            $data['servers'][$run]['map'] = $server['mapname'];
          }

          /* MaxPlayers */
          if(!isset($server['max_players'])) {
            if(isset($server['sv_maxclients'])) {
              $data['servers'][$run]['max_players'] = $server['sv_maxclients'];
            }
          }

          /* Generate Players-HTML */
          if(!empty($server['players'])) {
            $data['servers'][$run]['if']['playersexist'] = true;
            foreach(array_keys($server['players'][0]) AS $value) {
              $playershead[$run][]['name'] = $cs_lang[$value];
            }
            $data['servers'][$run]['playershead'] = $playershead[$run];
            // Player HTML erstellen
            for($i=0; $i <count($server['players']); $i++) {
              foreach($data['servers'][$run]['players'][$i] AS $value) {
                $data['servers'][$run]['players'][$i][0] .= '<td class="centerb">' . $value . '</td>';
              }
            }
          }

          if(!isset($server['num_players']) && isset($server['numplayers'])) {
            $data['servers'][$run]['num_players'] = $server['numplayers'];
          }
          if(!isset($server['num_players']) && isset($server['playercount'])) {
            $data['servers'][$run]['num_players'] = $server['playercount'];
          }
          if(!isset($server['num_players']) && isset($server['clients'])) {
            $data['servers'][$run]['num_players'] = $server['clients'];
          }

          if(isset($server['map']) && !empty($server['map'])) {
            $data['servers'][$run]['map'] = $server['map'];
            if(file_exists('uploads/servers/' . $cs_servers[$run]['servers_game'] . '/' . $data['servers'][$run]['map'] . '.jpg')) {
              $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/' . $data['servers'][$run]['map'] . '.jpg';
            }
            else {
              $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/default.jpg';
            }
          }
          elseif(isset($server['mapname']) && !empty($server['mapname'])) {
            $data['servers'][$run]['map'] = $server['mapname'];
            if(file_exists('uploads/servers/' . $cs_servers[$run]['servers_game'] . '/' . $data['servers'][$run]['mapname'] . '.jpg')) {
              $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/' . $data['servers'][$run]['mapname'] . '.jpg';
            }
            else {
              $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/default.jpg';
            }
          }
          $select = 'maps_name, maps_picture, server_name';
          $where = 'server_name = \'' . $data['servers'][$run]['map'] . '\'';
          $sqlmap = cs_sql_select(__FILE__,'maps',$select,$where,0,0,1);
          if(!empty($sqlmap)) {
            $data['servers'][$run]['map'] = $sqlmap['maps_name'];
            if(file_exists('uploads/maps/' . $sqlmap['maps_picture'])) {
              $data['servers'][$run]['mappic'] = 'uploads/maps/' . $sqlmap['maps_picture'];
            }
          }

          $data['servers'][$run] = $objServers->setProtocolLink($cs_servers[$run], $data['servers'][$run]);
          flush();
        }
      }
    }
  }

  cs_cache_save($cache_name, $data, $cache_time);
}
elseif(empty($data)) {

  $data = array('servers' => array());
  $data['if']['noquery'] = true;

  /* if fsockopen deactive, list servers */
  $tables = 'servers srv INNER JOIN {pre}_games gam ON srv.games_id = gam.games_id';
  $select = 'srv.servers_name AS servers_name, srv.servers_ip AS servers_ip, srv.servers_port AS servers_port';
  $select .= ', srv.servers_info AS servers_info, srv.servers_slots AS servers_slots, srv.servers_type AS servers_type';
  $select .= ', gam.games_name AS games_name, gam.games_id AS games_id';
  $order = 'srv.servers_order';
  $cs_servers = cs_sql_select(__FILE__,$tables,$select,0,$order,0,0);
  $cs_servers_count = count($cs_servers);

  $data['servers'] = array();

  for($serv=0; $serv < $cs_servers_count; $serv++) {
    $data['servers'][$serv]['name'] = $cs_servers[$serv]['servers_name'];
    $data['servers'][$serv]['url'] = $cs_servers[$serv]['servers_ip'] . ':' . $cs_servers[$serv]['servers_port'];
    switch ($cs_servers[$serv]['servers_type']) {
      case 1:
        $data['servers'][$serv]['type'] = $cs_lang['clanserver'];
        break;
      case 2:
        $data['servers'][$serv]['type'] = $cs_lang['pubserver'];
        break;
      case 3:
        $data['servers'][$serv]['type'] = $cs_lang['voiceserver'];
        break;
    }
    $data['servers'][$serv]['slots'] = $cs_servers[$serv]['servers_slots'];
    $data['servers'][$serv]['img'] = 'uploads/games/' . $cs_servers[$serv]['games_id'] . '.gif';
    $data['servers'][$serv]['game'] = $cs_servers[$serv]['games_name'];
    $data['servers'][$serv]['info'] = $cs_servers[$serv]['servers_info'];
  }

  cs_cache_save($cache_name, $data, $cache_time);
}

if(empty($data['if']['noquery']))
  echo cs_subtemplate(__FILE__,$data,'servers','list');
else
  echo cs_subtemplate(__FILE__,$data,'servers','noquery');