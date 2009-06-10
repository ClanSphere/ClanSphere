<?php
// ClanSphere 2009 - www.clansphere.net

$cs_lang = cs_translate('servers');

$id = empty($_GET['sid']) ? '' : (int) $_GET['sid'];

$data = array();

// Test if fsockopen active
if (fsockopen("udp://127.0.0.1", 1)) {
	if (4.3 <= substr(phpversion(), 0, 3)) {
		include_once 'mods/servers/functions.php';

		/* Get Server SQL-Data */
		$select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order, servers_id';
		$order = 'servers_order ASC';
		$where = empty($id) ? '' : 'servers_id = \'' . $id . '\'';
		$cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);
		$cs_servers_count = count($cs_servers);

		/* if Server in SQL */
		if(!empty($cs_servers_count)) {

			// Settings
			$use_file = '?mod=servers&action=list';
			$use_bind = '&';

			if (!defined('PHGDIR')) {
				define('PHGDIR', 'mods/servers/');
			}
			$country = array('Germany');
			include_once(PHGDIR . 'classes/phgstats.class.php');
			$phgdir = PHGDIR;

			$phgstatsc = new phgstats();
			for($run=0; $run<$cs_servers_count; $run++) {
				$data['servers'][$run]['if']['live'] = false;
				$data['servers'][$run]['map'] = $phgdir . 'maps/no_response.jpg';
				$data['servers'][$run]['hostname'] = $cs_servers[$run]['servers_name'];
				if(!empty($cs_servers[$run]['servers_stats'])) {
					$phgstats = $phgstatsc->query($cs_servers[$run]['servers_class']);
					/* resolve ip adress */
					$host = dns($cs_servers[$run]['servers_ip']);
					/* get the serverinfo string */
					$server = $phgstats->getstream($host, $cs_servers[$run]['servers_port'], $cs_servers[$run]['servers_query']);
					/* get the server rules */
					if($server === true) {
						$data['servers'][$run] = $phgstats->getrules($phgdir);
						$data['servers'][$run]['if']['live'] = true;
						if(file_exists($phgdir . $data['servers'][$run]['map_path'] . '/' . $data['servers'][$run]['mapname'] . '.jpg')) {
							$data['servers'][$run]['map'] = $phgdir . $data['servers'][$run]['map_path'] . '/' . $data['servers'][$run]['mapname'] . '.jpg';
						}
						else {
							$data['servers'][$run]['map'] = $phgdir . $data['servers'][$run]['map_path'] . '/default.jpg';
						}
						$data['servers'][$run]['servers_ip'] = $cs_servers[$run]['servers_ip'];
						$data['servers'][$run]['servers_port'] = $cs_servers[$run]['servers_port'];

            /* if TS View, use teamspeak:// */
            if($data['servers'][$run]['mapname'] == 'Teamspeak')
              $data['servers'][$run]['proto'] = 'teamspeak://';
            else
              $data['servers'][$run]['proto'] = 'hlsw://';

						$data['servers'][$run]['pass'] = empty($data['servers'][$run]['pass']) ? $cs_lang['no'] : $cs_lang['yes'];
						$data['servers'][$run]['id'] = $cs_servers[$run]['servers_id'];
						flush();
					}
				}
			}
		}
		echo cs_subtemplate(__FILE__,$data,'servers','navlist');
	}
  else {
		//Old PHP Version
		echo $cs_lang['php'];
	}
}