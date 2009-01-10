<?php
/*
 * show the data of one server
 */ 
function srv_info ($sh_srv, $srv_rules, $use_file, $use_bind, $only) {   
	global $cs_lang;

	if ($only) {
		/* html: one server: refresh button */
    	$bar = cs_html_table(1,'forum',1);
	    $bar .= cs_html_roco(1,'leftb');
    	$bar .= cs_html_div(1,'text-align:center');
    	$bar .= cs_link($cs_lang['refresh'],'servers','list');
    	$bar .= cs_html_div(0);
    	$bar .= cs_html_roco(0);
    	$bar .= cs_html_table(0);
    	$bar .= cs_html_br(2); 
	}
	else {
	   	/* html: more server: resfresh and serverlist button */
	   	$bar = cs_html_table(1,'forum',1);
    	$bar .= cs_html_roco(1,'headb');
    	$bar .= $srv_rules['hostname'];
    	$bar .= cs_html_roco(0);
    	$bar .= cs_html_roco(1,'leftb');
    	$bar .= cs_html_div(1,'text-align:center');
    	$bar .= cs_link($cs_lang['slist'],'servers','list');
		$bar .= ' | ' ;
		$bar .= cs_link($cs_lang['refresh'],'servers','list','sh_srv=' . $sh_srv);
		$bar .= cs_html_div(0);
		$bar .= cs_html_roco(0);
		$bar .= cs_html_table(0);
		$bar .= cs_html_br(1);
	}
    
    /* html: menu bar top */
	echo $bar;
  
    /* html: table to show server infos (1 server) */
	echo cs_html_table(1,'forum',1);
    
	/* html: hostname, country and daytime */
    echo cs_html_roco(1,'leftb',0,2);
    echo cs_html_div(1,'text-align:center;');
    echo $srv_rules['country'] . ' ' . $srv_rules['time'];
	echo cs_html_div(0);
    echo cs_html_roco(0);
    
	/* 	html: titels (server info) */
    echo cs_html_roco(1,'leftb',0,0);
    echo cs_html_div(1,'text-align:center;');
    echo $cs_lang['servers'];
    echo cs_html_div(0);
    echo cs_html_roco(2,'leftb',0,0);
    echo cs_html_div(1,'text-align:center;');
    echo $cs_lang['map'];
    echo cs_html_div(0);
    echo cs_html_roco(0);

	/* html: adress, game, gametype, mapname, players, privileges */
    echo cs_html_roco(1,'leftb');
    echo cs_html_table(1,'forum',0,'40%');
	echo cs_html_roco(1,'leftb');
    echo $cs_lang['ip'];
    echo cs_html_roco(2,'leftb');
	/* if TS View, use teamspeak:// */
	preg_match_all ("/Teamspeak/", $srv_rules['gamename'], $teamspeak);
	if(in_array("Teamspeak", $teamspeak[0])) {
    	echo cs_html_link('teamspeak://' . $srv_rules['adress'],$srv_rules['adress'],'_blank');
	}
    else {
    	echo cs_html_link('hlsw://' . $srv_rules['adress'],$srv_rules['adress'],'_blank');
    }
    echo cs_html_roco(0);
    echo $srv_rules['htmldetail'];
    echo cs_html_table(0);
    
    /* html: map picture */
    echo cs_html_roco(2,'leftb');
    echo cs_html_div(1,'text-align:center;');
    echo cs_html_img($srv_rules['map'],0,0,0,$srv_rules['mapname']);
    echo cs_html_div(0);
    echo cs_html_roco(0);

	/* html: close info table */
    echo cs_html_table(0);
    	
	/* html: open playerlist table */
	echo cs_html_br(1);
	echo cs_html_table(1,'forum',1);
    
	/* html: playerlist */
	echo $srv_rules['playerlist'];
	
	/* html: close playerlist table */
	echo cs_html_table(0);
}
			
/*
 * get data of server
 */ 
function info($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats) {
	global $cs_lang;
    
	/* create server the object */
    if($game[$sh_srv] == '1') { } else {
    	$phgstatsc = new phgstats();
    	$phgstats = $phgstatsc->query($game[$sh_srv]);
	}

	/* resolve ip adress */
    $host[$sh_srv] = dns($host[$sh_srv]);

	/* get the serverinfo string */
    if($stats[$sh_srv]=='1') {
    	$server = $phgstats->getstream($host[$sh_srv], $port[$sh_srv], $queryport[$sh_srv]);
	}
    else {
    	$server = 0;
	}

	if ($server === true) {
		/* get the server rules */
      	$srv_rules  = $phgstats->getrules($phgdir);
      	$srv_rules['playerlist'] = $phgstats->getplayers();     
        
		/* full path to the map picture */
	    $srv_rules['map'] = $phgdir . $srv_rules['map_path'] . '/' . $srv_rules['mapname'] . '.jpg';
	
    	if (!(file_exists($srv_rules['map']))) {
			/* set default map if no picture found */
		    $srv_rules['map'] = $phgdir . $srv_rules['map_path'] . '/' . $srv_rules['map_default'];
		}
	}
	else {
		/* default values if no response */
		$tables = 'servers ser INNER JOIN {pre}_games gam on ser.games_id = gam.games_id';
       	$select = 'ser.servers_name AS servers_name, ser.servers_ip AS servers_ip, ser.servers_port AS servers_port';
	   	$select .= ', ser.servers_info AS servers_info, gam.games_name AS games_name';
    	$where = "ser.servers_ip = '" . $host[$sh_srv] . "' AND ser.servers_port = '" . $port[$sh_srv] . "'";
       	$order = 'ser.servers_order DESC';
       	$cs_servers = cs_sql_select(__FILE__,$tables,$select,$where,0,0,0);
		
	    $srv_detail = "";
		
		$srv_rules['playerlist'] = '';
		$srv_rules['hostname']    = $cs_servers[0]['servers_name'];
		$srv_rules['gamename']    = $cs_servers[0]['games_name'];
     	$srv_rules['map']         = $phgdir . 'maps/no_response.jpg';
     	$srv_rules['mapname']     = '';
     	$srv_rules['sets']        = '';
     	$srv_rules['htmlinfo']    = cs_html_br(1) . cs_html_div(1,'text-align:center;') . $cs_servers[0]['servers_info'] . cs_html_div(0);
     	$srv_rules['htmldetail']  = cs_html_roco(1,'leftb',0,2) . cs_html_br(1) . cs_html_div(1,'text-align:center;');
 	 	$srv_rules['htmldetail'] .= $cs_servers[0]['servers_info'] . cs_html_div(0) . cs_html_roco(0);
	}
	/* get server day time */
    $srv_rules['time']= cs_date(1,cs_time(),1);
    	
	/* get server country / location */
	$srv_rules['country'] = $country[$sh_srv];

	/* get server adress */
	$srv_rules['adress'] = $host[$sh_srv] . ':' . $port[$sh_srv];
    
	return $srv_rules;
}	

/*
 * show the data of two or more server
 */ 
function srv_list ($sh_srv, $srv_rules, $use_file, $use_bind) {
	global $cs_lang;

	/* html: server ip and gamename */
	echo cs_html_roco(1,'leftb');
    echo cs_html_div(1,'text-align:center');
    echo $cs_lang['ip'];
    echo cs_html_br(1);
    echo cs_link($srv_rules['adress'],'servers','list','sh_srv=' . $sh_srv);
    echo cs_html_br(2);
    echo $cs_lang['type'];
    echo cs_html_br(1);
    echo $srv_rules['gamename'];
    echo cs_html_br(2);
	/* if TS View, use teamspeak:// */
	preg_match_all ("/Teamspeak/", $srv_rules['gamename'], $teamspeak);
    if(in_array("Teamspeak", $teamspeak[0])) {
    	echo cs_html_link('teamspeak://' . $srv_rules['adress'],'Connect','_blank');
	}
    else {
    	echo cs_html_link('hlsw://' . $srv_rules['adress'],'HLSW','_blank');
    }
    echo cs_html_div(0);

	/* html: server info link */
	echo cs_html_roco(2,'leftb');
    echo cs_html_div(1,'text-align:center');
    echo cs_link($srv_rules['hostname'],'servers','list','sh_srv=' . $sh_srv);
    echo cs_html_div(0);

	/* html: server details table */
	echo cs_html_table(1,'forum',0,'40%');
	echo $srv_rules['htmlinfo'];
	echo cs_html_table(0);
	
   	/* html: map picture */
	echo cs_html_roco(3,'leftb');
	echo cs_html_div(1,'vertical-align:middle');
    echo cs_html_img($srv_rules['map'],50,50,'',$srv_rules['mapname']);
	echo cs_html_div(0);
	echo cs_html_roco(0);
}			
?>