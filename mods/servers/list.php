<?php
$cs_lang = cs_translate('servers');

$id = empty($_GET['id']) ? '' : (int) $_GET['id'];

$data['if']['oldphp'] = false;

/* Test if fsockopen active */
if (fsockopen("udp://127.0.0.1", 1)) {
  if (4.3 <= substr(phpversion(), 0, 3)) {
    include_once 'functions.php';

    /* Get Server SQL-Data */
    $select = 'servers_name, servers_ip, servers_port, servers_info, servers_query, servers_class, servers_stats, servers_order, servers_id';
    $order = 'servers_order ASC';
    $where = empty($id) ? '' : 'servers_id = \'' . $id . '\'';
    $cs_servers = cs_sql_select(__FILE__,'servers',$select,$where,$order,0,0);
    $cs_servers_count = count($cs_servers);
	
	$data['servers'] = array();
    
    /* if Server in SQL */
    if(!empty($cs_servers_count)) {
    	$data['if']['server'] = true;

      /* Settings */
      define ('PHGDIR', 'mods/servers/');
      $use_file = '?mod=servers&action=list';    
      $use_bind = '&';   

      $country = array('Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany','Germany'); 
      include_once(PHGDIR . 'classes/phgstats.class.php');  
      $phgdir = PHGDIR;

      $phgstatsc = new phgstats();
      for($run=0; $run<$cs_servers_count; $run++) {
      	$data['servers'][$run]['info'] = $cs_servers[$run]['servers_info'];
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
		        $data['servers'][$run]['playershead'] = $phgstats->getplayers_head();
		        $data['servers'][$run]['players'] = $phgstats->getplayers();
		        /* full path to the map picture */
		        if(file_exists($phgdir . $data['servers'][$run]['map_path'] . '/' . $data['servers'][$run]['mapname'] . '.jpg')) {
		        	$data['servers'][$run]['map'] = $phgdir . $data['servers'][$run]['map_path'] . '/' . $data['servers'][$run]['mapname'] . '.jpg';
		        }
		        else {
		        	$data['servers'][$run]['map'] = $phgdir . $data['servers'][$run]['map_path'] . '/default.jpg';
		        }
		        $data['servers'][$run]['servers_ip'] = $cs_servers[$run]['servers_ip'];
	          /* if TS View, use teamspeak:// */
	          preg_match_all("/Teamspeak/", $data['servers'][$run]['gametype'], $teamspeak);
	          if(in_array("Teamspeak", $teamspeak[0])) {
	          	$data['servers'][$run]['proto'] = 'teamspeak://';
	          }
	          else {
	          	$data['servers'][$run]['proto'] = 'hlsw://';
	          }
	          $data['servers'][$run]['pass'] = empty($data['servers'][$run]['pass']) ? $cs_lang['no'] : $cs_lang['yes'];
	          flush();
	        }
        } 

      }
    }
    /* Show Serverslist */
    echo cs_subtemplate(__FILE__,$data,'servers','list');
  }
  else {
  	/* Old PHP Version */
  	echo cs_subtemplate(__FILE__,$data,'servers','oldphp');
  } 
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
echo '<pre>';
print_R($cs_servers);
?>