<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('servers');

$id = empty($_GET['sid']) ? '' : (int) $_GET['sid'];

$data = array('servers' => array());

// Test if fsockopen active
if (fsockopen("udp://127.0.0.1", 1)) {

	include_once 'mods/servers/gameq/GameQ.php';

	/* Get Server SQL-Data */
	$select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order, servers_id';
	$order = 'servers_order ASC';
	$where = empty($id) ? '' : 'servers_id = \'' . $id . '\'';
	$cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);
	$servers_count = count($cs_servers);

	/* if Server in SQL */
	if(!empty($servers_count)) {

		/* Settings */
		$gq = new GameQ();

		for($run=0; $run<$servers_count; $run++) {
			$data['servers'][$run]['if']['live'] = false;
			$data['servers'][$run]['hostname'] = $cs_servers[$run]['servers_name'];
			$server_query_ex = explode(";",$cs_servers[$run]['servers_class']);
			$cs_servers[$run]['servers_class'] = $server_query_ex[0];
			$cs_servers[$run]['servers_game'] = $server_query_ex[1];
			if(!empty($cs_servers[$run]['servers_stats'])) {

				$gq->addServer(0, array($cs_servers[$run]['servers_class'],$cs_servers[$run]['servers_ip'],$cs_servers[$run]['servers_port']));
				$gq->setOption('timeout', 200);
				$gq->setFilter('stripcolor');
				$results[$run] = $gq->requestData();
				$server[$run] = $results[$run][0];

				if(!empty($server[$run]['gq_online'])) {
					$data['servers'][$run]['if']['live'] = true;
					$data['servers'][$run]['map'] = 'mods/servers/maps/no_response.jpg';
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
							if(file_exists('uploads/servers/' . $cs_servers[$run]['servers_class'] . '/' . $data['servers'][$run]['map'] . '.jpg')) {
								$data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_class'] . '/' . $data['servers'][$run]['map'] . '.jpg';
							}
							else {
								$data['servers'][$run]['mappic'] = 'uploads/servers/' . $cs_servers[$run]['servers_class'] . '/default.jpg';
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



						/* if TS View, use teamspeak:// */
						if($cs_servers[$run]['servers_class'] == 'ts3') {
							$data['servers'][$run]['proto'] = 'teamspeak://';
							$data['servers'][$run]['num_players'] = 0;
							for($a=0; $a<count($server[$run]['teams']); $a++) {
								$data['servers'][$run]['num_players'] = $data['servers'][$run]['num_players'] + $server[$run]['teams'][$a]['total_clients'];
							}
						}
						else {
							$data['servers'][$run]['proto'] = 'hlsw://';
						}

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