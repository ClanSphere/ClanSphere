<?php
    // get data of server
    function info_navlist($phgdir, $sh_srv, $game, $host, $port, $queryport, $country, $stats) {
      global $cs_lang;

      // create server the object
      if($game[$sh_srv] == '1') { } else {
        $phgstats = phgstats::query($game[$sh_srv]);
    }
  
    // resolve ip adress
    $host[$sh_srv] = gethostbyname($host[$sh_srv]);  
  
    // get the serverinfo string
      if($stats[$sh_srv]=='1') {
        $server = $phgstats->getstream($host[$sh_srv], $port[$sh_srv], $queryport[$sh_srv]);
      } else {
        $server = 0;
      }
  
    if ($server === true) {
        // get the server rules
        $srv_rules_navlist  = $phgstats->getrules($phgdir);
        $srv_rules_navlist['playerlist'] = $phgstats->getplayers();     

        // full path to the map picture
        $srv_rules_navlist['map'] = $phgdir . $srv_rules_navlist['map_path'] . '/' . $srv_rules_navlist['mapname'] . '.jpg';
  
        if (!(file_exists($srv_rules_navlist['map']))) {
          // set default map if no picture found
          $srv_rules_navlist['map'] = $phgdir . $srv_rules_navlist['map_path'] . '/' . $srv_rules_navlist['map_default'];
        }
 
      } else {
    
      // default values if no response
        $tables = 'servers ser INNER JOIN {pre}_games gam on ser.games_id = gam.games_id';
        $select = 'ser.servers_name AS servers_name, ser.servers_ip AS servers_ip, ser.servers_port AS servers_port';
        $select .= ', ser.servers_info AS servers_info, gam.games_name AS games_name';
        $where = "ser.servers_ip = '" . $host[$sh_srv] . "' AND ser.servers_port = '" . $port[$sh_srv] . "'";
        $order = 'ser.servers_order DESC';
        $cs_servers = cs_sql_select(__FILE__,$tables,$select,$where,0,0,0);
    
        $srv_detail = "";
    
        $srv_rules_navlist['playerlist'] = '';
        $srv_rules_navlist['hostname']    = $cs_servers[0]['servers_name'];
        $srv_rules_navlist['gamename']    = $cs_servers[0]['games_name'];
        $srv_rules_navlist['map']         = $phgdir . 'maps/no_response.jpg';
        $srv_rules_navlist['mapname']     = '';
        $srv_rules_navlist['sets']        = '';
        $srv_rules_navlist['htmlinfo']    = cs_html_br(1) . cs_html_div(1,'text-align:center;') . $cs_servers[0]['servers_info'] . cs_html_div(0);
        $srv_rules_navlist['htmldetail']  = cs_html_roco(1,'leftb',0,2) . cs_html_br(1) . cs_html_div(1,'text-align:center;');
       $srv_rules_navlist['htmldetail'] .= $cs_servers[0]['servers_info'] . cs_html_div(0) . cs_html_roco(0);
      }
  
    // get server day time
      $srv_rules_navlist['time']= cs_date(1,cs_time(),1);
    
      // get server country / location
      $srv_rules_navlist['country'] = $country[$sh_srv];

      // get server adress
      $srv_rules_navlist['adress'] = $host[$sh_srv] . ':' . $port[$sh_srv];
     
      return $srv_rules_navlist;
    }
  
    function srv_info_navlist ($sh_srv, $srv_rules_navlist, $use_file, $use_bind, $only) {   
      global $cs_lang;
  
    $font1 = '<font style="font-weight: bold;">';
    $font0 = '</font>';
    
    echo cs_html_table(1,'centerb');

    // Server Name
    echo cs_html_roco(1,'centerb',0,2);
    echo $srv_rules_navlist['hostname'];
    echo cs_html_roco(0);

    // Map-Bild
    echo cs_html_roco(1,'centerb',0,2);
      echo cs_html_img($srv_rules_navlist['map'],75,75,0,$srv_rules_navlist['mapname']);

    // IP / Host
       echo cs_html_roco(1,'rightb');
    echo $font1 . $cs_lang['host_navlist'] . $font0;
      echo cs_html_roco(2,'leftb');
    // if TS View, use teamspeak://
    preg_match_all ("/Teamspeak/", $srv_rules_navlist['gamename'], $teamspeak);
    if(in_array("Teamspeak", $teamspeak[0])) {
        echo cs_html_link('teamspeak://' . $srv_rules_navlist['adress'],$srv_rules_navlist['adress'],'_blank');
      } else {
        echo cs_html_link('hlsw://' . $srv_rules_navlist['adress'],$srv_rules_navlist['adress'],'_blank');
      }
    echo cs_html_roco(0);
    
    // Game
       echo cs_html_roco(1,'rightb');
    echo $font1 . $cs_lang['game_navlist'] . $font0;
      echo cs_html_roco(2,'leftb');
    echo $srv_rules_navlist['gamename'];
    echo cs_html_roco(0);    
    
    // Mapname
     echo cs_html_roco(1,'rightb');
    echo $font1 . $cs_lang['map_navlist'] . $font0;
      echo cs_html_roco(2,'leftb');
    echo $srv_rules_navlist['mapname'];
    echo cs_html_roco(0);

    // Players
     echo cs_html_roco(1,'rightb');
    echo $font1 . $cs_lang['players_navlist'] . $font0;
       echo cs_html_roco(2,'leftb');
    echo $srv_rules_navlist['nowplayers'] . ' / ' . $srv_rules_navlist['maxplayers'];
      echo cs_html_roco(0);
    
    // Game
       echo cs_html_roco(1,'rightb');
    echo $font1 . $cs_lang['response_navlist'] . $font0;
      echo cs_html_roco(2,'leftb');
    echo $srv_rules_navlist['response'];
    echo cs_html_roco(0);        
     
    
    echo cs_html_table(0);
  }  
?>