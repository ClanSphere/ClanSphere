<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');
$cs_option = cs_sql_option(__FILE__, 'servers');
$id = empty($_GET['sid']) ? 0 : (int) $_GET['sid'];

$cache_name = 'servers_navlist_' . (int) $id;
$cache_time = 60;

$data = cs_cache_load($cache_name, $cache_time);

// Test if fsockopen active
if (empty($data) AND fsockopen("udp://127.0.0.1", 1)) {

  $data = array('servers' => array());

  include_once 'mods/servers/servers.class.php';

  /* Get Server SQL-Data */
  $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order, servers_id';
  $order = 'servers_order ASC';
  $where = empty($id) ? '' : 'servers_id = \'' . $id . '\'';
  $cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);
  $servers_count = count($cs_servers);

  /* if Server in SQL */
  if(!empty($servers_count)) {

    /* Settings */
    $objServers = Servers::__getInstance();

    for($run=0; $run<$servers_count; $run++) {
      $data['servers'][$run]['if']['live'] = false;
      $data['servers'][$run]['mappic'] = 'uploads/servers/no_response.jpg';
      $data['servers'][$run]['hostname'] = $cs_servers[$run]['servers_name'];
      $server_query_ex = explode(";",$cs_servers[$run]['servers_class']);
      $cs_servers[$run]['servers_class'] = $server_query_ex[0];
      $cs_servers[$run]['servers_game'] = $server_query_ex[0];
      if(!empty($cs_servers[$run]['servers_stats'])) {

        $objServers->addServer(0, $cs_servers[$run]);
        $results[$run] = $objServers->requestData();
        $server = $results[$run][0];

        if(!empty($server['gq_online'])) {
          $data['servers'][$run] = $server;
          $data['servers'][$run] = $objServers->normalize($data['servers'][$run], $cs_servers[$run]);
          $data['servers'][$run]['if']['live'] = true;
          $data['servers'][$run]['map'] = '';
          $data['servers'][$run]['mappic'] = 'uploads/servers/no_response.jpg';
          $data['servers'][$run]['mapname'] = '';
          $data['servers'][$run]['max_players'] = isset($server['max_players']) ? $server['max_players'] : 0;
          $data['servers'][$run]['num_players'] = isset($server['num_players']) ? $server['num_players'] : 0;

          if(!empty($cs_servers[$run]['servers_stats'])) {
            $data['servers'][$run]['servers_ip'] = $cs_servers[$run]['servers_ip'];
            $data['servers'][$run]['servers_port'] = $cs_servers[$run]['servers_port'];

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

            if(!isset($server['max_players'])) {
              if(isset($server['sv_maxclients'])) {
                $data['servers'][$run]['max_players'] = $server['sv_maxclients'];
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
            
            $data['servers'][$run] = $objServers->setProtocolLink($cs_servers[$run], $data['servers'][$run]);
            $data['servers'][$run]['id'] = $cs_servers[$run]['servers_id'];
            flush();
          }
        }
      }
    }
  }

  cs_cache_save($cache_name, $data, $cache_time);
}

if(empty($data))
  echo 'fsockopen error';
else
  echo cs_subtemplate(__FILE__,$data,'servers','navlist');