<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');
$cs_option = cs_sql_option(__FILE__, 'servers');
$id = empty($_GET['sid']) ? '' : (int) $_GET['sid'];

$data = array('servers' => array());

// Test if fsockopen active
if (fsockopen("udp://127.0.0.1", 1)) {
	include_once 'mods/servers/servers.php';

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
			$cs_servers[$run]['servers_game'] = $server_query_ex[1];
			if(!empty($cs_servers[$run]['servers_stats'])) {

				$objServers->addServer(0, $cs_servers[$run]);
				$results[$run] = $objServers->requestData();
				$server[$run] = $results[$run][0];

				if(!empty($server[$run]['gq_online'])) {
					$data['servers'][$run]['if']['live'] = true;
					$data['servers'][$run]['map'] = '';
					$data['servers'][$run]['mappic'] = 'uploads/servers/no_response.jpg';
					$data['servers'][$run]['mapname'] = '';
					$data['servers'][$run]['max_players'] = isset($server[$run]['max_players']) ? $server[$run]['max_players'] : 0;
					$data['servers'][$run]['num_players'] = isset($server[$run]['num_players']) ? $server[$run]['num_players'] : 0;
					$data['servers'][$run]['game_descr'] = isset($server[$run]['game_descr']) ? $server[$run]['game_descr'] : '';

					if(!empty($cs_servers[$run]['servers_stats'])) {
						$data['servers'][$run]['servers_ip'] = $cs_servers[$run]['servers_ip'];
						$data['servers'][$run]['servers_port'] = $cs_servers[$run]['servers_port'];
						if(isset($server[$run]['gamename']) AND !empty($server[$run]['gamename'])) {
							$data['servers'][$run]['game_descr'] = $server[$run]['gamename'];
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

						if(!isset($server[$run]['max_players'])) {
							if(isset($server[$run]['sv_maxclients'])) {
								$data['servers'][$run]['max_players'] = $server[$run]['sv_maxclients'];
							}
						}
						if(!isset($server[$run]['num_players'])) {
							if(isset($server[$run]['clients'])) {
								$data['servers'][$run]['num_players'] = $server[$run]['clients'];
							}
						}
						$data['servers'][$run] = $objServers->setProtocolLink($cs_servers[$run], $data['servers'][$run]);
						$data['servers'][$run]['pass'] = empty($data['servers'][$run]['pass']) ? $cs_lang['no'] : $cs_lang['yes'];
						$data['servers'][$run]['id'] = $cs_servers[$run]['servers_id'];
						flush();
					}
				}
			}
		}
	}
	echo cs_subtemplate(__FILE__,$data,'servers','navlist');
}
