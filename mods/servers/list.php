<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

$id = empty($_GET['id']) ? '' : (int) $_GET['id'];

$results = array();
$data = array('servers' => array());

$data['if']['server'] = false;

// Test if fsockopen active
if (fsockopen("udp://127.0.0.1", 1)) {
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
      $cs_servers[$run]['servers_game'] = isset($server_query_ex[1]) ? $server_query_ex[1] : $server_query_ex[0];
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
        $server[$run] = $results[$run][0];

        if(!empty($server[$run]['gq_online'])) {
          $data['servers'][$run] = $server[$run];
          $data['servers'][$run] = $objServers->normalize($data['servers'][$run]);
          $data['servers'][$run]['if']['live'] = true;
          $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/default.jpg';
          $data['servers'][$run]['game'] = isset($server_query_ex[1]) ? $server_query_ex[1] : $server_query_ex[0];
          $data['servers'][$run]['map'] = '';
          $data['servers'][$run]['if']['playersexist'] = false;
          $data['servers'][$run]['ip'] = $cs_servers[$run]['servers_ip'];
          $data['servers'][$run]['port'] = $cs_servers[$run]['servers_port'];
          $data['servers'][$run]['pass'] = '--';
          
          if($cs_servers[$run]['servers_game'] == 'ut3') {
            $data['servers'][$run]['port'] = $cs_servers[$run]['servers_query'];
          }
          
          
          if(isset($server[$run]['password'])) {
            $data['servers'][$run]['pass'] = empty($server[$run]['password']) ? $cs_lang['no'] : $cs_lang['yes'];
          }
          
          if(isset($server[$run]['pswrd'])) {
            $data['servers'][$run]['pass'] = empty($server[$run]['pswrd']) ? $cs_lang['no'] : $cs_lang['yes'];
          }
          
          if(isset($server[$run]['g_needpass'])) {
            $data['servers'][$run]['pass'] = empty($server[$run]['g_needpass']) ? $cs_lang['no'] : $cs_lang['yes'];
          }
          
          if(!isset($server[$run]['game_descr']) OR empty($server[$run]['game_descr'])) {
            $data['servers'][$run]['game_descr'] = $server[$run]['gamename'];
          }
          
          if(!isset($server[$run]['version']) OR empty($server[$run]['version'])) {
            $data['servers'][$run]['version'] = $server[$run]['shortversion'];
          }
          
          if(isset($server[$run]['mapname']) && !empty($server[$run]['mapname'])) {
            $data['servers'][$run]['map'] = $server[$run]['mapname'];
          }
          
          if(!isset($server[$run]['max_players'])) {
            if(isset($server[$run]['sv_maxclients'])) {
              $data['servers'][$run]['max_players'] = $server[$run]['sv_maxclients'];
            }
          }
          
          /* Generate Players-HTML */
          if(!empty($server[$run]['players'])) {
            $data['servers'][$run]['if']['playersexist'] = true;
            foreach(array_keys($server[$run]['players'][0]) AS $value) {
              $playershead[$run][]['name'] = $cs_lang[$value];
            }
            $data['servers'][$run]['playershead'] = $playershead[$run];
            // Player HTML erstellen
            for($i=0; $i <count($server[$run]['players']); $i++) {
              foreach($data['servers'][$run]['players'][$i] AS $value) {
                $data['servers'][$run]['players'][$i][0] .= '<td class="centerb">' . $value . '</td>';
              }
            }
          }
          
          if(isset($server[$run]['map']) && !empty($server[$run]['map'])) {
            $data['servers'][$run]['map'] = $server[$run]['map'];
            if(file_exists('uploads/servers/' . $cs_servers[$run]['servers_game'] . '/' . $data['servers'][$run]['map'] . '.jpg')) {
              $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/' . $data['servers'][$run]['map'] . '.jpg';
            }
            else {
              $data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_game'] . '/default.jpg';
            }
          }
          elseif(isset($server[$run]['mapname']) && !empty($server[$run]['mapname'])) {
            $data['servers'][$run]['map'] = $server[$run]['mapname'];
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

  /* Show Serverslist */
  echo cs_subtemplate(__FILE__,$data,'servers','list');
}
else {
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
  echo cs_subtemplate(__FILE__,$data,'servers','noquery');
}
