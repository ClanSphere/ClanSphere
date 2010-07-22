<?php
// ClanSphere 2010 - www.clansphere.net
// $Id: list.php 3655 2010-03-11 20:05:19Z hajo $

$cs_lang = cs_translate('servers');

$id = empty($_GET['id']) ? '' : (int) $_GET['id'];

$results = array();
$data = array('servers');

$data['if']['server'] = false;

/* Test if fsockopen active */
if (fsockopen("udp://127.0.0.1", 1)) {
    include_once 'mods/servers/gameq/GameQ.php';

    /* Get Server SQL-Data */
    $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query';
    $select .= ', servers_class, servers_stats, servers_order, servers_id';
    $order = 'servers_order ASC';
    $where = empty($id) ? '' : 'servers_id = \'' . $id . '\'';
    $cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);

    /* if Server in SQL */
    if(!empty($cs_servers)) {
      $data['if']['server'] = true;

      /* Settings */
      $gq = new GameQ();

      for($run=0; $run<count($cs_servers); $run++) {
        $data['servers'][$run]['info'] = $cs_servers[$run]['servers_info'];
        $data['servers'][$run]['if']['live'] = false;
        $data['servers'][$run]['map'] = 'mods/servers/maps/no_response.jpg';
        $data['servers'][$run]['hostname'] = $cs_servers[$run]['servers_name'];
        if(!empty($cs_servers[$run]['servers_stats'])) {
          $gq->addServer(0, array($cs_servers[$run]['servers_class'],$cs_servers[$run]['servers_ip'],$cs_servers[$run]['servers_port']));
          $results[$run] = $gq->requestData();
          $server[$run] = $results[$run][0];

          if(!empty($server[$run]['gq_online'])) {
            $data['servers'][$run] = $server[$run];
            $data['servers'][$run]['if']['live'] = true;
            $data['servers'][$run]['playershead'] = array();
            $data['servers'][$run]['players'] = array();
            $data['servers'][$run]['pass'] = empty($server[$run]['password']) ? $cs_lang['no'] : $cs_lang['yes'];
            if(!empty($server[$run]['players'])) {
              foreach(array_keys($server[$run]['players'][0]) AS $value) {
                $playershead[$run][]['name'] = $cs_lang[$value];
              }
              $data['servers'][$run]['playershead'] = $playershead[$run];
              // Player HTML erstellen
              for($i=0; $i <count($server[$run]['players']); $i++) {
                $data['servers'][$run]['players'][$i][0] = '';
                foreach($server[$run]['players'][$i] AS $value) {
                  $data['servers'][$run]['players'][$i][0] .= '<td class="centerb">' . $value . '</td>';
                }
              }
            }

            //            /* full path to the map picture */
            //            if(file_exists('mods/servers/maps/' . $cs_servers[$run]['servers_class'] . '/' . $cs_servers[$run]['mapname'] . '.jpg')) {
            //              $data['servers'][$run]['map'] = 'mods/servers/maps/' . $cs_servers[$run]['servers_class'] . '/' . $cs_servers[$run]['mapname'] . '.jpg';
            //            }
            //            elseif(file_exists('mods/servers/maps/' . $data['servers'][$run]['servers_class'] . '/' . $data['servers'][$run]['mapname'] . '.png')) {
            //              $data['servers'][$run]['map'] = 'mods/servers/maps/' . $cs_servers[$run]['servers_class'] . '/' . $cs_servers[$run]['mapname'] . '.png';
            //            }
            //            else {
            //              $data['servers'][$run]['map'] = 'mods/servers/maps/' . $cs_servers[$run]['servers_class'] . '/default.jpg';
            //            }
            //
            //            /* if TS View, use teamspeak:// */
            //            if($data['servers'][$run]['mapname'] == 'Teamspeak')
            //              $data['servers'][$run]['proto'] = 'teamspeak://';
            //            else
            //              $data['servers'][$run]['proto'] = 'hlsw://';
            //
            //            $data['servers'][$run]['pass'] = empty($data['servers'][$run]['needpass']) ? $cs_lang['no'] : $cs_lang['yes'];
            //            flush();
          }
        }
      }
    }
    /* Show Serverslist */
    echo cs_subtemplate(__FILE__,$data,'servers','list');
#		echo '<pre>';
#		print_R($results);
		//		print_R($data);
#		echo '</pre>';
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